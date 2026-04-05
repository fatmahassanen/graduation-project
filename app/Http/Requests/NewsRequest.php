<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NewsRequest extends FormRequest
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
        $newsId = $this->route('news') ? $this->route('news')->id : null;

        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('news')->ignore($newsId),
            ],
            'excerpt' => ['required', 'string'],
            'body' => ['required', 'string'],
            'featured_image_id' => ['nullable', 'integer', 'exists:media,id'],
            'category' => [
                'required',
                'string',
                Rule::in([
                    'announcement',
                    'achievement',
                    'research',
                    'partnership',
                ]),
            ],
            'is_featured' => ['nullable', 'boolean'],
            'language' => ['required', 'string', 'size:2'],
            'status' => [
                'required',
                'string',
                Rule::in(['draft', 'published', 'archived']),
            ],
        ];
    }
}
