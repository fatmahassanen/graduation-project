<?php

namespace App\Http\Controllers;

use App\Mail\AdmissionSubmitted;
use App\Models\Admission;
use App\Rules\DifferentFromField;
use App\Rules\EgyptianPhone;
use App\Services\NationalIdService;
use App\Traits\HandlesImageUploads;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

/**
 * AdmissionController
 *
 * Handles public admission form submission with National ID extraction
 */
class AdmissionController extends Controller
{
    use HandlesImageUploads;

    protected NationalIdService $nationalIdService;

    public function __construct(NationalIdService $nationalIdService)
    {
        $this->nationalIdService = $nationalIdService;
    }

    /**
     * Show the admission application form.
     */
    public function create(): View|RedirectResponse
    {
        // Smart Access Logic: Check if user already has an application
        $existingAdmission = Admission::where('user_id', auth()->id())->first();

        if ($existingAdmission) {
            // If Pending or Accepted: Redirect to portal (no re-application allowed)
            if (in_array($existingAdmission->status, ['pending', 'accepted'])) {
                return redirect()->route('student.portal')
                    ->with('info', 'You already have a submitted application. View it below.');
            }

            // If Rejected: Allow re-application with auto-filled data
            if ($existingAdmission->status === 'rejected') {
                $governorates = NationalIdService::getGovernoratesForDropdown();

                return view('admission.create', [
                    'governorates' => $governorates,
                    'admission' => $existingAdmission,
                    'isReapplication' => true,
                    'isDraft' => false,
                ]);
            }

            // If Draft: Continue editing with current step
            if ($existingAdmission->status === 'draft') {
                $governorates = NationalIdService::getGovernoratesForDropdown();

                return view('admission.create', [
                    'governorates' => $governorates,
                    'admission' => $existingAdmission,
                    'isReapplication' => false,
                    'isDraft' => true,
                ]);
            }
        }

        // New application: No existing data
        $governorates = NationalIdService::getGovernoratesForDropdown();

        return view('admission.create', [
            'governorates' => $governorates,
            'admission' => null,
            'isReapplication' => false,
            'isDraft' => false,
        ]);
    }

    /**
     * Store a new admission application or update rejected one.
     */
    public function store(Request $request): RedirectResponse
    {
        // Check if this is a "Save as Draft" action
        $isDraftSave = $request->has('save_draft');

        // Identity Protection: Check existing admission
        $existingAdmission = Admission::where('user_id', auth()->id())->first();

        // If Pending or Accepted: Block submission (should never happen due to create() logic)
        if ($existingAdmission && in_array($existingAdmission->status, ['pending', 'accepted'])) {
            return redirect()->route('student.portal')
                ->with('error', 'You already have an active admission application.');
        }

        // Determine if this is a re-application (rejected status) or draft continuation
        $isReapplication = $existingAdmission && $existingAdmission->status === 'rejected';
        $isDraftContinuation = $existingAdmission && $existingAdmission->status === 'draft';

        // Validation rules - relaxed for drafts
        if ($isDraftSave) {
            return $this->saveDraft($request, $existingAdmission);
        }

        // Full validation for final submission
        $validated = $request->validate([
            // National ID & Auto-extracted fields
            'national_id' => [
                'required',
                'string',
                'size:14',
                'regex:/^\d{14}$/',
                // Unique check: Ignore current user's existing admission
                ($isReapplication || $isDraftContinuation)
                    ? 'unique:admissions,national_id,'.$existingAdmission->id
                    : 'unique:admissions,national_id',
            ],
            'birth_date' => 'required|date|before:today',
            'birth_governorate' => 'required|string|max:255',
            'gender' => 'required|in:male,female',

            // Student Information
            'first_name' => 'required|string|max:255',
            'second_name' => 'required|string|max:255',
            'third_name' => 'required|string|max:255',
            'fourth_name' => 'required|string|max:255',
            'religion' => 'required|in:Muslim,Christian,Jewish,Other',

            // Address Information
            'current_governorate' => 'required|string|max:255',
            'city_center' => 'required|string|max:255',
            'village_district' => 'required|string|max:255',
            'street_address' => 'required|string|max:500',

            // Contact Information
            'phone' => [
                'required',
                new EgyptianPhone,
                new DifferentFromField('parent_phone', 'parent phone'),
            ],

            // Documents - Only required if not re-applying or if user wants to change them
            'student_photo' => ($isReapplication || $isDraftContinuation) ? 'nullable|image|mimes:jpeg,png,jpg|max:2048' : 'required|image|mimes:jpeg,png,jpg|max:2048',
            'birth_certificate' => ($isReapplication || $isDraftContinuation) ? 'nullable|file|mimes:pdf|max:5120' : 'required|file|mimes:pdf|max:5120',
            'qualification_certificate' => ($isReapplication || $isDraftContinuation) ? 'nullable|file|mimes:pdf|max:5120' : 'required|file|mimes:pdf|max:5120',
            'student_id_document' => ($isReapplication || $isDraftContinuation) ? 'nullable|file|mimes:pdf|max:5120' : 'required|file|mimes:pdf|max:5120',

            // Parent Information
            'parent_name' => 'required|string|max:255',
            'parent_phone' => [
                'required',
                new EgyptianPhone,
            ],
            'father_occupation' => 'required|string|max:255',
            'parent_id_document' => ($isReapplication || $isDraftContinuation) ? 'nullable|file|mimes:pdf|max:5120' : 'required|file|mimes:pdf|max:5120',
        ], [
            'national_id.required' => 'National ID is required.',
            'national_id.size' => 'National ID must be exactly 14 digits.',
            'national_id.regex' => 'National ID must contain only numbers.',
            'national_id.unique' => 'This National ID has already been registered.',
            'religion.in' => 'Please select a valid religion.',
            'gender.in' => 'Please select a valid gender.',
        ]);

        // Validate National ID format using service
        if (! $this->nationalIdService->validate($validated['national_id'])) {
            throw ValidationException::withMessages([
                'national_id' => 'Invalid Egyptian National ID format.',
            ]);
        }

        // Validate unique file uploads (prevent same file for different requirements)
        // Only validate files that are being uploaded
        $this->validateUniqueFiles($request);

        // Start database transaction
        DB::beginTransaction();

        try {
            // Prepare data array
            $data = [
                'user_id' => auth()->id(),
                'national_id' => $validated['national_id'],
                'first_name' => $validated['first_name'],
                'second_name' => $validated['second_name'],
                'third_name' => $validated['third_name'],
                'fourth_name' => $validated['fourth_name'],
                'gender' => $validated['gender'],
                'religion' => $validated['religion'],
                'birth_date' => $validated['birth_date'],
                'birth_governorate' => $validated['birth_governorate'],
                'current_governorate' => $validated['current_governorate'],
                'city_center' => $validated['city_center'],
                'village_district' => $validated['village_district'],
                'street_address' => $validated['street_address'],
                'phone' => $validated['phone'],
                'email' => auth()->user()->email,
                'parent_name' => $validated['parent_name'],
                'parent_phone' => $validated['parent_phone'],
                'father_occupation' => $validated['father_occupation'],
                'status' => 'pending',
                'current_step' => 4, // Completed all steps
                'reviewed_at' => null, // Reset review timestamp
                'reviewed_by' => null, // Reset reviewer
                'rejection_reason' => null, // Clear rejection reason
                'student_code' => null, // Clear student code
            ];

            // Upload files with error handling
            // File Persistence: Only upload new files if provided
            try {
                if ($request->hasFile('student_photo')) {
                    // Delete old file if exists and re-applying
                    if (($isReapplication || $isDraftContinuation) && $existingAdmission->student_photo) {
                        Storage::disk('public')->delete($existingAdmission->student_photo);
                    }
                    $data['student_photo'] = $this->uploadImage($request->file('student_photo'), 'admissions/photos');
                } elseif (($isReapplication || $isDraftContinuation) && $existingAdmission->student_photo) {
                    // Keep existing file
                    $data['student_photo'] = $existingAdmission->student_photo;
                }

                if ($request->hasFile('birth_certificate')) {
                    if (($isReapplication || $isDraftContinuation) && $existingAdmission->birth_certificate) {
                        Storage::disk('public')->delete($existingAdmission->birth_certificate);
                    }
                    $data['birth_certificate'] = $request->file('birth_certificate')->store('admissions/documents', 'public');
                } elseif (($isReapplication || $isDraftContinuation) && $existingAdmission->birth_certificate) {
                    $data['birth_certificate'] = $existingAdmission->birth_certificate;
                }

                if ($request->hasFile('qualification_certificate')) {
                    if (($isReapplication || $isDraftContinuation) && $existingAdmission->qualification_certificate) {
                        Storage::disk('public')->delete($existingAdmission->qualification_certificate);
                    }
                    $data['qualification_certificate'] = $request->file('qualification_certificate')->store('admissions/documents', 'public');
                } elseif (($isReapplication || $isDraftContinuation) && $existingAdmission->qualification_certificate) {
                    $data['qualification_certificate'] = $existingAdmission->qualification_certificate;
                }

                if ($request->hasFile('student_id_document')) {
                    if (($isReapplication || $isDraftContinuation) && $existingAdmission->student_id_document) {
                        Storage::disk('public')->delete($existingAdmission->student_id_document);
                    }
                    $data['student_id_document'] = $request->file('student_id_document')->store('admissions/documents', 'public');
                } elseif (($isReapplication || $isDraftContinuation) && $existingAdmission->student_id_document) {
                    $data['student_id_document'] = $existingAdmission->student_id_document;
                }

                if ($request->hasFile('parent_id_document')) {
                    if (($isReapplication || $isDraftContinuation) && $existingAdmission->parent_id_document) {
                        Storage::disk('public')->delete($existingAdmission->parent_id_document);
                    }
                    $data['parent_id_document'] = $request->file('parent_id_document')->store('admissions/documents', 'public');
                } elseif (($isReapplication || $isDraftContinuation) && $existingAdmission->parent_id_document) {
                    $data['parent_id_document'] = $existingAdmission->parent_id_document;
                }
            } catch (\Exception $e) {
                Log::error('File upload failed during admission submission: '.$e->getMessage());
                throw ValidationException::withMessages([
                    'files' => 'File upload failed. Please try again.',
                ]);
            }

            // Create or Update admission record
            if ($isReapplication || $isDraftContinuation) {
                // Update existing record
                $existingAdmission->update($data);
                $admission = $existingAdmission;
                $message = $isReapplication 
                    ? 'Application re-submitted successfully! Track your status in your profile.'
                    : 'Application submitted successfully! Track your status in your profile.';
            } else {
                // Create new record
                $admission = Admission::create($data);
                $message = 'Application submitted successfully! Track your status in your profile.';
            }

            // Commit transaction BEFORE attempting email
            DB::commit();

            // Try to send submission confirmation email (sync mode for demo)
            try {
                Mail::to($admission->email)->send(new AdmissionSubmitted($admission));
            } catch (\Exception $e) {
                Log::error('Failed to send submission email: '.$e->getMessage(), [
                    'admission_id' => $admission->id,
                    'email' => $admission->email,
                ]);
                // Continue anyway - admission is already saved
            }

            return redirect()->route('student.portal')
                ->with('success', $message);
        } catch (\Exception $e) {
            // Rollback transaction
            DB::rollBack();

            // Delete uploaded files if any (only new uploads, not existing ones)
            if (! ($isReapplication || $isDraftContinuation)) {
                $this->cleanupUploadedFiles($data);
            }

            Log::error('Admission submission failed: '.$e->getMessage());

            return back()
                ->withInput()
                ->withErrors(['error' => 'Submission failed. Please try again.']);
        }
    }

    /**
     * Save application as draft with minimal validation
     */
    private function saveDraft(Request $request, $existingAdmission = null): RedirectResponse
    {
        // Minimal validation for draft - only validate what's provided
        $rules = [];
        
        // Only validate fields that are present
        if ($request->filled('national_id')) {
            $rules['national_id'] = [
                'string',
                'size:14',
                'regex:/^\d{14}$/',
                $existingAdmission 
                    ? 'unique:admissions,national_id,'.$existingAdmission->id
                    : 'unique:admissions,national_id',
            ];
        }

        if ($request->filled('birth_date')) {
            $rules['birth_date'] = 'date|before:today';
        }

        if ($request->filled('phone')) {
            $rules['phone'] = [new EgyptianPhone];
        }

        if ($request->filled('parent_phone')) {
            $rules['parent_phone'] = [new EgyptianPhone];
        }

        // Validate files if uploaded
        if ($request->hasFile('student_photo')) {
            $rules['student_photo'] = 'image|mimes:jpeg,png,jpg|max:2048';
        }

        if ($request->hasFile('birth_certificate')) {
            $rules['birth_certificate'] = 'file|mimes:pdf|max:5120';
        }

        if ($request->hasFile('qualification_certificate')) {
            $rules['qualification_certificate'] = 'file|mimes:pdf|max:5120';
        }

        if ($request->hasFile('student_id_document')) {
            $rules['student_id_document'] = 'file|mimes:pdf|max:5120';
        }

        if ($request->hasFile('parent_id_document')) {
            $rules['parent_id_document'] = 'file|mimes:pdf|max:5120';
        }

        $validated = $request->validate($rules);

        DB::beginTransaction();

        try {
            // Prepare data array with only filled fields
            $data = [
                'user_id' => auth()->id(),
                'email' => auth()->user()->email,
                'status' => 'draft',
                'current_step' => $request->input('current_step', 1),
            ];

            // Add text fields if present
            $textFields = [
                'national_id', 'birth_date', 'birth_governorate', 'gender',
                'first_name', 'second_name', 'third_name', 'fourth_name', 'religion',
                'current_governorate', 'city_center', 'village_district', 'street_address',
                'phone', 'parent_name', 'parent_phone', 'father_occupation'
            ];

            foreach ($textFields as $field) {
                if ($request->filled($field)) {
                    $data[$field] = $request->input($field);
                }
            }

            // Handle file uploads
            try {
                if ($request->hasFile('student_photo')) {
                    if ($existingAdmission && $existingAdmission->student_photo) {
                        Storage::disk('public')->delete($existingAdmission->student_photo);
                    }
                    $data['student_photo'] = $this->uploadImage($request->file('student_photo'), 'admissions/photos');
                } elseif ($existingAdmission && $existingAdmission->student_photo) {
                    $data['student_photo'] = $existingAdmission->student_photo;
                }

                $documentFields = ['birth_certificate', 'qualification_certificate', 'student_id_document', 'parent_id_document'];
                
                foreach ($documentFields as $field) {
                    if ($request->hasFile($field)) {
                        if ($existingAdmission && $existingAdmission->$field) {
                            Storage::disk('public')->delete($existingAdmission->$field);
                        }
                        $data[$field] = $request->file($field)->store('admissions/documents', 'public');
                    } elseif ($existingAdmission && $existingAdmission->$field) {
                        $data[$field] = $existingAdmission->$field;
                    }
                }
            } catch (\Exception $e) {
                Log::error('File upload failed during draft save: '.$e->getMessage());
                throw ValidationException::withMessages([
                    'files' => 'File upload failed. Please try again.',
                ]);
            }

            // Create or update draft
            if ($existingAdmission) {
                $existingAdmission->update($data);
                $admission = $existingAdmission;
            } else {
                $admission = Admission::create($data);
            }

            DB::commit();

            return back()->with('success', 'Draft saved successfully! You can continue later.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Draft save failed: '.$e->getMessage());

            return back()
                ->withInput()
                ->withErrors(['error' => 'Failed to save draft. Please try again.']);
        }
    }

    /**
     * Validate that all uploaded files are unique (no duplicate files).
     * Only validates files that are actually being uploaded.
     */
    private function validateUniqueFiles(Request $request): void
    {
        $files = [];

        // Only check files that are being uploaded
        if ($request->hasFile('birth_certificate')) {
            $files['birth_certificate'] = $request->file('birth_certificate');
        }
        if ($request->hasFile('qualification_certificate')) {
            $files['qualification_certificate'] = $request->file('qualification_certificate');
        }
        if ($request->hasFile('student_id_document')) {
            $files['student_id_document'] = $request->file('student_id_document');
        }
        if ($request->hasFile('parent_id_document')) {
            $files['parent_id_document'] = $request->file('parent_id_document');
        }

        // If less than 2 files being uploaded, no need to check uniqueness
        if (count($files) < 2) {
            return;
        }

        $fileHashes = [];
        $fileNames = [];

        foreach ($files as $fieldName => $file) {
            // Check filename uniqueness
            $fileName = $file->getClientOriginalName();
            if (in_array($fileName, $fileNames)) {
                throw ValidationException::withMessages([
                    $fieldName => "You cannot upload the same file '{$fileName}' for different requirements.",
                ]);
            }
            $fileNames[] = $fileName;

            // Check file content hash
            $hash = md5_file($file->getRealPath());
            if (in_array($hash, $fileHashes)) {
                throw ValidationException::withMessages([
                    $fieldName => 'You cannot upload the same file for different requirements. Please upload unique files.',
                ]);
            }
            $fileHashes[] = $hash;
        }
    }

    /**
     * Clean up uploaded files in case of error
     */
    private function cleanupUploadedFiles(array $data): void
    {
        $fileFields = [
            'student_photo',
            'birth_certificate',
            'qualification_certificate',
            'student_id_document',
            'parent_id_document',
        ];

        foreach ($fileFields as $field) {
            if (isset($data[$field])) {
                try {
                    Storage::disk('public')->delete($data[$field]);
                } catch (\Exception $e) {
                    Log::warning("Failed to delete file {$field}: ".$e->getMessage());
                }
            }
        }
    }
}
