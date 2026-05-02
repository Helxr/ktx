<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\CapNhatHoSoRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(CapNhatHoSoRequest $request): RedirectResponse
    {
        $nguoiDung = $request->user();
        $nguoiDung->fill($request->validated());

        if ($nguoiDung->isDirty('email')) {
            $nguoiDung->email_verified_at = null;
        }

        $nguoiDung->save();

        // Cập nhật thông tin sinh viên nếu có
        if ($nguoiDung->vaitro === 'sinhvien') {
            $sinhvien = $nguoiDung->sinhvien ?? new \App\Models\Sinhvien(['user_id' => $nguoiDung->id]);
            $sinhvien->fill([
                'masinhvien' => $request->masinhvien,
                'lop' => $request->lop,
                'sodienthoai' => $request->sodienthoai,
            ]);
            $sinhvien->save();
        }

        // Cập nhật giới tính người dùng
        if ($request->filled('gioitinh')) {
            $nguoiDung->gioitinh = $request->gioitinh;
            $nguoiDung->save();
        }

        return Redirect::route('profile.edit')
            ->with('status', 'profile-updated')
            ->with('toast_loai', 'thanhcong')
            ->with('toast_noidung', 'Cập nhật hồ sơ thành công.');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $nguoiDung = $request->user();

        Auth::logout();

        $nguoiDung->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}



