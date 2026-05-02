<?php

namespace App\Http\Requests\Guest;

use Illuminate\Foundation\Http\FormRequest;

class LuuDangkyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'phong_id' => ['required', 'exists:phong,id'],
            'giuong_no' => ['nullable', 'integer'],
            'ho_ten' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150'],
            'so_dien_thoai' => ['required', 'string', 'regex:/^(0[3|5|7|8|9])[0-9]{8}$/', 'max:11'],
            'so_cccd' => ['required', 'string', 'regex:/^[0-9]{9}$|^[0-9]{12}$/', 'max:12'],
            'anh_the' => ['nullable', 'image', 'max:4096'],
            'anh_cccd' => ['nullable', 'image', 'max:4096'],
        ];
    }

    public function messages(): array
    {
        return [
            'so_dien_thoai.regex' => 'Số điện thoại không đúng định dạng Việt Nam (bắt đầu bằng 03, 05, 07, 08, hoặc 09).',
            'so_cccd.regex' => 'Số CCCD phải có 9 hoặc 12 chữ số.',
        ];
    }
}


