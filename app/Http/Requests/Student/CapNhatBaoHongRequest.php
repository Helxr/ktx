<?php

namespace App\Http\Requests\Student;

use App\Enums\MaintenanceStatus;
use Illuminate\Foundation\Http\FormRequest;

class CapNhatBaoHongRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'trangthai' => ['required', 'in:' . implode(',', [
                MaintenanceStatus::PENDING->value,
                MaintenanceStatus::SCHEDULED->value,
                MaintenanceStatus::IN_PROGRESS->value,
                MaintenanceStatus::COMPLETED->value,
            ])],
            'ngayhen' => ['nullable', 'date'],
            'noidung' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'trangthai.required' => 'Trạng thái không được để trống.',
            'trangthai.in' => 'Trạng thái không hợp lệ.',
            'ngayhen.date' => 'Ngày hẹn phải là định dạng ngày hợp lệ.',
        ];
    }
}


