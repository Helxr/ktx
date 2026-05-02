<?php

namespace App\Http\Requests\Admin;

use App\Models\Lienhe;
use Illuminate\Foundation\Http\FormRequest;

class CapNhatTrangThaiLienHeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'trang_thai' => ['required', 'in:' . implode(',', [
                Lienhe::TRANG_THAI_CHUA_XU_LY,
                Lienhe::TRANG_THAI_DA_XU_LY,
            ])],
            'ghi_chu_admin' => ['nullable', 'string'],
        ];
    }
}


