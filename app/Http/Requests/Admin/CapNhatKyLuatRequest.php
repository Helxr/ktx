<?php

namespace App\Http\Requests\Admin;

use App\Enums\DisciplineLevel;
use Illuminate\Foundation\Http\FormRequest;

class CapNhatKyLuatRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'noidung' => ['required', 'string'],
            'ngayvipham' => ['required', 'date'],
            'mucdo' => ['required', 'string', 'in:' . implode(',', DisciplineLevel::values())],
        ];
    }
}


