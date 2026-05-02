<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CapNhatCauHinhRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'gia_dien' => ['required', 'numeric', 'min:0'],
            'gia_nuoc' => ['required', 'numeric', 'min:0'],
            'hotline' => ['required', 'string'],
        ];
    }
}


