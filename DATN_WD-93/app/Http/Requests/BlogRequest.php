<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogRequest extends FormRequest
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
    public function rules()
    {
        return [
            'title' => 'required|string',
            'short_content' => 'required|string', // Bắt buộc, là chuỗi, tối đa 255 ký tự
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Không bắt buộc, là file ảnh, kích thước tối đa 2MB
            'content' => 'required|string|min:10', // Bắt buộc, là chuỗi, tối thiểu 10 ký tự
            'topic_id' => 'required|exists:topics,id', // Bắt buộc, phải tồn tại trong bảng topics, cột id
        ];
    }

    /**
     * Thông báo lỗi tùy chỉnh cho các quy tắc xác thực.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.required' => 'Tên bài viết là bắt buộc.',
            'title.string' => 'Tên bài viết phải là chuỗi ký tự.',

            'short_content.required' => 'Mô tả là bắt buộc.',
            'short_content.string' => 'Mô tả phải là chuỗi ký tự.',
            
            'image.required' => 'Ảnh bài viết là bắt buộc.',
            'image.image' => 'Ảnh phải là định dạng hợp lệ (jpeg, png, jpg, gif).',
            'image.mimes' => 'Ảnh chỉ được phép có định dạng: jpeg, png, jpg, gif.',
            'image.max' => 'Kích thước ảnh không được vượt quá 2MB.',

            'content.required' => 'Nội dung bài viết là bắt buộc.',
            'content.string' => 'Nội dung bài viết phải là chuỗi ký tự.',
            'content.min' => 'Nội dung bài viết phải có ít nhất 10 ký tự.',

            'topic_id.required' => 'Chủ đề bài viết là bắt buộc.',
            'topic_id.exists' => 'Chủ đề bài viết không tồn tại.',
        ];
    }
}
