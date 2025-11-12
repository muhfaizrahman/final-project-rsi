<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Field Utama
            'full_name' => ['required', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:100'],
            'country' => ['nullable', 'string', 'max:100'],
            'biography' => ['nullable', 'string'],
            
            // Field File Upload
            'profile_photo_url' => ['nullable', 'image', 'max:2048'],
            'background_photo_url' => ['nullable', 'image', 'max:2048'],

            // Field Dinamis (Skills)
            'skills' => ['nullable', 'array'],
            'skills.*' => ['nullable', 'string', 'max:100'],
            
            // Field Dinamis (Educations) - Menggunakan array of objects
            'educations' => ['nullable', 'array'],
            'educations.*.institution_name' => ['required_with:educations', 'string', 'max:255'],
            'educations.*.degree' => ['required_with:educations', 'string', 'max:255'],
            'educations.*.field_of_study' => ['nullable', 'string', 'max:255'],
            'educations.*.start_date' => ['required_with:educations', 'date'],
            'educations.*.end_date' => ['nullable', 'date', 'after_or_equal:educations.*.start_date'],
            'educations.*.description' => ['nullable', 'string'],
        ];
    }
}
