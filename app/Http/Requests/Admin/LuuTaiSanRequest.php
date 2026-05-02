<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class LuuTaiSanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tentaisan' => ['required', 'string'],
            'soluong' => ['required', 'numeric', 'min:1'],
            'tinhtrang' => ['required', 'string'],
        ];
    }
}


