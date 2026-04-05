<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $pageId = $this->route('page') ? $this->route('page')->id : null;

        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('pages')->where(function ($query) {
                    return $query->where('language', $this->input('language', 'en'));
                })->ignore($pageId),
            ],
            'category' => [
                'required',
                'string',
                Rule::in([
                    'admissions',
                    'faculties',
                    'events',
                    'about',
                    'quality',
                    'media',
                    'campus',
                    'staff',
                    'student_services',
                ]),
            ],
            'status' => [
                'required',
                'string',
                Rule::in(['draft', 'published', 'archived']),
            ],
            'language' => ['required', 'string', 'size:2'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'meta_keywords' => ['nullable', 'string', 'max:500'],
            'og_image' => ['nullable', 'string', 'max:500'],
        ];
    }
}
