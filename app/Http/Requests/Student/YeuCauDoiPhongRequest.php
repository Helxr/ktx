<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;

class YeuCauDoiPhongRequest extends FormRequest
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
            'phong_moi_id' => \App\Rules\CommonRules::phongMoiId(),
            'lydo' => ['required', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'phong_moi_id.required' => 'Vui long chon phong moi.',
            'phong_moi_id.numeric' => 'Phong khong hop le.',
            'phong_moi_id.exists' => 'Phong khong ton tai.',
            'lydo.required' => 'Vui long nhap ly do doi phong.',
            'lydo.string' => 'Ly do phai la van ban.',
            'lydo.max' => 'Ly do khong duoc vuot qua 500 ky tu.',
        ];
    }
}


