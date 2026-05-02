<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GiaHanHopDongRequest extends FormRequest
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
            'ngay_ket_thuc' => ['required', 'date', 'after:today'],
        ];
    }

    public function messages(): array
    {
        return [
            'ngay_ket_thuc.required' => 'Bạn phải nhập ngày kết thúc.',
            'ngay_ket_thuc.date' => 'Ngày kết thúc không hợp lệ.',
            'ngay_ket_thuc.after' => 'Ngày kết thúc mới phải sau ngày hôm nay và sau ngày kết thúc hiện tại của hợp đồng.',
        ];
    }

    /**
     * Custom validation to check that ngay_ket_thuc is after current contract end date.
     * This is handled in the controller after fetching the contract.
     */
}


