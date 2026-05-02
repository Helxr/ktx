<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class LuuLichSuBaoTriRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ngaybaotri' => ['required', 'date'],
            'noidung' => ['required', 'string'],
            'chiphi' => ['nullable', 'numeric', 'min:0'],
            'donvithuchien' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'ngaybaotri.required' => 'Vui lòng nhập ngày bảo trì.',
            'ngaybaotri.date' => 'Ngày bảo trì không hợp lệ.',
            'noidung.required' => 'Vui lòng nhập nội dung bảo trì.',
        ];
    }
}


