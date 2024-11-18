<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TopicRequest extends FormRequest
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
            "name" => 'required|string|max:255'
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => "Không được bỏ trống tên chuyên mục",
            'name.string' => "Tên chuyên mục sai định dạng",
            'name.max:255' => "Tên chuyên mục quá dài",
        ];
    }
}
