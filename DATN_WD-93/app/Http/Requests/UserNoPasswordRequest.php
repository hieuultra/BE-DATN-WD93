<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserNoPasswordRequest extends FormRequest
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
            'email' => 'required|email|unique:users,email',
            'name' => 'required|string|min:3|max:255',
            'phone' => 'required|string|max:15|regex:/^(\+?[0-9]{1,3})?([0-9]{10})$/',
            'role' => 'required|string|max:50',
            'address' => 'nullable',
            'image' => 'nullable',
        ];
    }
    public function messages()
    {
        return [
            'email.required' => 'Email bắt buộc nhập*.',
            'email.email' => 'Email không hợp lệ*.',
            'email.unique' => 'Email đã tồn tại*.',
            'name.min' => 'Tên phải có ít nhất 3 ký tự*.',
            'name.required' => 'Tên bắt buộc nhập*.',
            'phone.required' => 'Số điện thoại bắt buộc nhập*.',
            'phone.regex' => 'Số điện thoại không đúng định dạng*.',
            'role.required' => 'Chức vụ bắt buộc nhập*.',
        ];
    }
}
