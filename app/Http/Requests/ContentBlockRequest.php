<?php

namespace App\Http\Requests;

use App\Services\ContentBlockService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ContentBlockRequest extends FormRequest
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
        return [
            'page_id' => ['required', 'integer', 'exists:pages,id'],
            'type' => [
                'required',
                'string',
                Rule::in([
                    'hero',
                    'text',
                    'card_grid',
                    'video',
                    'faq',
                    'testimonial',
                    'gallery',
                    'contact_form',
                ]),
            ],
            'content' => ['required', 'array'],
            'display_order' => ['nullable', 'integer', 'min:0'],
            'is_reusable' => ['nullable', 'boolean'],
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            if ($this->has('type') && $this->has('content')) {
                $service = app(ContentBlockService::class);
                
                if (!$service->validateBlockContent($this->input('type'), $this->input('content'))) {
                    $validator->errors()->add(
                        'content',
                        'The content does not match the required schema for type: ' . $this->input('type')
                    );
                }
            }
        });
    }
}
