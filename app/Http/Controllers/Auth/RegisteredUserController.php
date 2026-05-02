<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Sinhvien;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(Request $request): View
    {
        return view('auth.register', [
            'prefillMssv' => old('mssv', (string) $request->query('mssv', '')),
            'prefillEmail' => old('email', (string) $request->query('email', '')),
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'gioitinh' => ['required', 'in:Nam,Nữ'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'vaitro' => 'sinhvien', // Mặc định khi đăng ký là sinh viên
            'gioitinh' => $request->gioitinh,
        ]);

        // Tạo bản ghi sinh viên trống liên kết với user vừa tạo
        Sinhvien::create([
            'user_id' => $user->id,
            'masinhvien' => null,
            'lop' => null,
            'sodienthoai' => null,
            'phong_id' => null,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
