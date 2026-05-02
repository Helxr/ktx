<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;

class LuuDanhGiaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'diem' => ['required', 'integer', 'min:1', 'max:5'],
            'noidung' => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'diem.required' => 'Vui lòng chọn số sao đánh giá.',
            'diem.integer' => 'Điểm đánh giá phải là số nguyên.',
            'diem.min' => 'Điểm đánh giá tối thiểu là 1 sao.',
            'diem.max' => 'Điểm đánh giá tối đa là 5 sao.',
        ];
    }
}


