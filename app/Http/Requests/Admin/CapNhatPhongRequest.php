<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CapNhatPhongRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tenphong' => ['required'],
            'tang' => ['required', 'numeric', 'min:1'],
            'giaphong' => ['required', 'numeric', 'min:0'],
            'soluongtoida' => ['required', 'numeric', 'min:1'],
            'succhuamax' => ['required', 'numeric', 'min:1', 'same:soluongtoida'],
            'mota' => ['nullable'],
            'gioitinh' => ['required', 'in:Nam,Nữ'],
        ];
    }

    public function messages(): array
    {
        return [
            'tenphong.required' => 'Ten phong khong duoc de trong.',
            'tang.required' => 'Tang khong duoc de trong.',
            'giaphong.required' => 'Gia phong khong duoc de trong.',
            'giaphong.numeric' => 'Gia phong phai la so.',
            'soluongtoida.required' => 'So luong toi da khong duoc de trong.',
            'soluongtoida.numeric' => 'So luong toi da phai la so.',
            'soluongtoida.min' => 'So luong toi da phai lon hon hoac bang 1.',
            'succhuamax.required' => 'Suc chua toi da khong duoc de trong.',
            'succhuamax.same' => 'Suc chua toi da phai bang so luong toi da.',
            'gioitinh.required' => 'Gioi tinh khong duoc de trong.',
        ];
    }
}


