<?php

namespace App\Http\Requests\Student;

use App\Models\User;
use App\Models\Sinhvien;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CapNhatHoSoRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            // Thêm các trường cho sinh viên
            'masinhvien' => [
                'nullable',
                'string',
                'max:20',
                Rule::unique('sinhvien')->ignore($this->user()->sinhvien->id ?? 0),
            ],
            'lop' => ['nullable', 'string', 'max:50'],
            'sodienthoai' => ['nullable', 'string', 'max:15'],
            'gioitinh' => ['nullable', 'in:Nam,Nữ'],
        ];
    }

    public function messages(): array
    {
        return [
            'masinhvien.unique' => 'Mã sinh viên này đã tồn tại trên hệ thống.',
        ];
    }
}


