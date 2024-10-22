<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'nameUser' => 'required|string|max:255',
            'phoneUser' => 'required|string|max:15',
            'addressUser' => 'required|string|max:255',
            'emailUser' => 'required|string|email|max:255',
        ];
    }
    /**
     * Get the custom validation messages for the rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'nameUser.required' => 'Name is required.',
            'nameUser.string' => 'Name must be a string.',
            'nameUser.max' => 'Name cannot be longer than 255 characters.',

            'phoneUser.required' => 'Phone number is required.',
            'phoneUser.string' => 'Phone number must be a string.',
            'phoneUser.max' => 'Phone number cannot be longer than 15 characters.',

            'addressUser.required' => 'Address is required.',
            'addressUser.string' => 'Address must be a string.',
            'addressUser.max' => 'Address cannot be longer than 255 characters.',

            'emailUser.required' => 'Email is required.',
            'emailUser.string' => 'Email must be a string.',
            'emailUser.email' => 'Email must be a valid email address.',
            'emailUser.max' => 'Email cannot be longer than 255 characters.',
        ];
    }
}
