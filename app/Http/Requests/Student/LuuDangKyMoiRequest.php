<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;

class LuuDangKyMoiRequest extends FormRequest
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
            'phong_id' => \App\Rules\CommonRules::phongId(),
        ];
    }

    public function messages(): array
    {
        return [
            'phong_id.required' => 'Ban chua chon phong.',
            'phong_id.numeric' => 'Phong khong hop le.',
            'phong_id.exists' => 'Phong khong ton tai.',
        ];
    }
}


