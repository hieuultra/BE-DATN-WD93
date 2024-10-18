<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'img' => 'required|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|boolean',
        ];
    }
    // @return array<string, string>
    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập tên.',
            'name.string' => 'Tên phải là một chuỗi ký tự.',
            'name.max' => 'Tên không được vượt quá :max ký tự.',
            
            'img.required' => 'Vui lòng tải lên một hình ảnh.',
            'img.file' => 'Tệp phải là một file hợp lệ.',
            'img.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif, svg.',
            'img.max' => 'Kích thước hình ảnh không được vượt quá :max kilobytes.',
            
            'status.required' => 'Vui lòng chọn trạng thái.',
            'status.boolean' => 'Trạng thái chỉ có thể là đúng hoặc sai.',
        ];
    }
}
