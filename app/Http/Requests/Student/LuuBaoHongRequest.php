<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;

class LuuBaoHongRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'mota' => ['required'],
            'noidung' => ['nullable', 'string'],
            'anhminhhoa' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ];
    }

    public function messages(): array
    {
        return [
            'mota.required' => 'Mô tả lỗi không được để trống.',
            'anhminhhoa.image' => 'Tệp đính kèm phải là hình ảnh.',
            'anhminhhoa.mimes' => 'Ảnh chỉ chấp nhận định dạng jpg, jpeg, png, webp.',
            'anhminhhoa.max' => 'Ảnh tối đa 4MB.',
        ];
    }
}


