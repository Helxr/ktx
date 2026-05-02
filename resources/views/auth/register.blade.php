<x-guest-layout>
    <div class="mb-8">
        <a href="{{ route('home') }}" class="group inline-flex items-center gap-2 text-[10px] font-bold uppercase tracking-widest text-slate-400 transition-colors hover:text-slate-900">
            <svg class="h-3 w-3 transition-transform group-hover:-translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Quay lại trang chủ
        </a>
    </div>

    <div class="mb-8 text-center">
        <div class="mx-auto mb-5 flex h-16 w-16 items-center justify-center rounded-2xl bg-brand-50 text-brand-600 shadow-inner ring-1 ring-inset ring-brand-100">
            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
        </div>
        <h1 class="text-3xl font-bold tracking-tight text-slate-900 font-display">Tạo hồ sơ mới</h1>
        <p class="mt-2 text-sm font-medium text-slate-500">Khởi đầu hành trình lưu trú của bạn ngay hôm nay.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <div class="space-y-1.5">
            <label for="name" class="text-[10px] font-bold uppercase tracking-widest text-slate-500 ml-1">Họ và tên đầy đủ</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" class="linear-input" placeholder="Nguyễn Văn A" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-1 ml-1" />
        </div>

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
            <div class="space-y-1.5">
                <label for="mssv" class="text-[10px] font-bold uppercase tracking-widest text-slate-500 ml-1">Mã số sinh viên</label>
                <input id="mssv" type="text" name="mssv" value="{{ old('mssv', $prefillMssv ?? '') }}" class="linear-input" placeholder="SV123456" autocomplete="off" />
            </div>

            <div class="space-y-1.5">
                <label for="gioitinh" class="text-[10px] font-bold uppercase tracking-widest text-slate-500 ml-1">Giới tính</label>
                <select id="gioitinh" name="gioitinh" class="linear-select" required>
                    <option value="">Chọn giới tính</option>
                    <option value="Nam" {{ old('gioitinh') === 'Nam' ? 'selected' : '' }}>Nam giới</option>
                    <option value="Nữ" {{ old('gioitinh') === 'Nữ' ? 'selected' : '' }}>Nữ giới</option>
                </select>
                <x-input-error :messages="$errors->get('gioitinh')" class="mt-1 ml-1" />
            </div>
        </div>

        <div class="space-y-1.5">
            <label for="email" class="text-[10px] font-bold uppercase tracking-widest text-slate-500 ml-1">Địa chỉ Email</label>
            <input id="email" type="email" name="email" value="{{ old('email', $prefillEmail ?? '') }}" class="linear-input" placeholder="name@university.edu.vn" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-1 ml-1" />
        </div>

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
            <div class="space-y-1.5">
                <label for="password" class="text-[10px] font-bold uppercase tracking-widest text-slate-500 ml-1">Mật khẩu</label>
                <input id="password" type="password" name="password" class="linear-input" placeholder="••••••••" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-1 ml-1" />
            </div>

            <div class="space-y-1.5">
                <label for="password_confirmation" class="text-[10px] font-bold uppercase tracking-widest text-slate-500 ml-1">Xác nhận</label>
                <input id="password_confirmation" type="password" name="password_confirmation" class="linear-input" placeholder="••••••••" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 ml-1" />
            </div>
        </div>

        <button type="submit" class="linear-btn-primary w-full py-4 text-base font-bold shadow-xl shadow-brand-500/20">
            Khởi tạo tài khoản
        </button>

        <div class="pt-4 text-center">
            <p class="text-sm font-medium text-slate-500">
                Đã có tài khoản cư trú? 
                <a href="{{ route('login') }}" class="font-bold text-brand-600 hover:text-brand-700 transition-colors">Quay lại đăng nhập</a>
            </p>
        </div>
    </form>
</x-guest-layout>
