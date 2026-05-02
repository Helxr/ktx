<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class LuuHopDongRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'sinhvien_id' => \App\Rules\CommonRules::sinhvienId(),
            'phong_id' => \App\Rules\CommonRules::phongId(),
            'ngay_bat_dau' => ['required', 'date'],
            'ngay_ket_thuc' => ['required', 'date', 'after:ngay_bat_dau'],
        ];
    }

    public function messages(): array
    {
        return [
            'sinhvien_id.required' => 'Vui lòng chọn sinh viên.',
            'sinhvien_id.numeric' => 'Sinh viên không hợp lệ.',
            'sinhvien_id.exists' => 'Sinh viên không tồn tại.',
            'phong_id.required' => 'Vui lòng chọn phòng.',
            'phong_id.numeric' => 'Phòng không hợp lệ.',
            'phong_id.exists' => 'Phòng không tồn tại.',
            'ngay_bat_dau.required' => 'Vui lòng nhập ngày bắt đầu.',
            'ngay_bat_dau.date' => 'Ngày bắt đầu không hợp lệ.',
            'ngay_ket_thuc.required' => 'Vui lòng nhập ngày kết thúc.',
            'ngay_ket_thuc.date' => 'Ngày kết thúc không hợp lệ.',
            'ngay_ket_thuc.after' => 'Ngày kết thúc phải sau ngày bắt đầu.',
        ];
    }
}


