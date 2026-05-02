<?php

namespace App\Http\Requests\Admin;

use App\Enums\DisciplineLevel;
use Illuminate\Foundation\Http\FormRequest;

class LuuKyLuatRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'sinhvien_id' => \App\Rules\CommonRules::sinhvienId(),
            'noidung' => ['required', 'string'],
            'ngayvipham' => ['required', 'date'],
            'mucdo' => ['required', 'string', 'in:' . implode(',', DisciplineLevel::values())],
        ];
    }
}


