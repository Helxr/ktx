<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class LuuThongBaoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tieude' => ['required', 'string', 'max:255'],
            'noidung' => ['required', 'string'],
            'doituong' => ['nullable', 'in:sinhvien,admin,tatca'],
            'ngaydang' => ['nullable', 'date'],
        ];
    }

    public function messages(): array
    {
        return [
            'tieude.required' => 'Vui lòng nhập tiêu đề.',
            'noidung.required' => 'Vui lòng nhập nội dung.',
        ];
    }
}


