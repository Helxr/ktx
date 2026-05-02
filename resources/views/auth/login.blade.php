<x-guest-layout>
    <div class="mb-8">
        <a href="{{ route('home') }}" class="group inline-flex items-center gap-2 text-[10px] font-bold uppercase tracking-widest text-slate-400 transition-colors hover:text-slate-900">
            <svg class="h-3 w-3 transition-transform group-hover:-translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Quay lại trang chủ
        </a>
    </div>

    <div class="mb-10 text-center">
        <div class="mx-auto mb-5 flex h-16 w-16 items-center justify-center rounded-2xl bg-brand-50 text-brand-600 shadow-inner ring-1 ring-inset ring-brand-100">
            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-1-1m0 0l-1-1m1 1l1-1m-1 1l1 1m-4-4h14M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
        </div>
        <h1 class="text-3xl font-bold tracking-tight text-slate-900 font-display">Chào mừng trở lại</h1>
        <p class="mt-2 text-sm font-medium text-slate-500">Đăng nhập để quản lý không gian lưu trú của bạn.</p>
    </div>

    <x-auth-session-status class="mb-6 rounded-xl bg-emerald-50 p-4 text-sm font-bold text-emerald-600 ring-1 ring-emerald-100" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <div class="space-y-1.5">
            <label for="email" class="text-[10px] font-bold uppercase tracking-widest text-slate-500 ml-1">Địa chỉ Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" class="linear-input" placeholder="name@university.edu.vn" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-1 ml-1" />
        </div>

        <div class="space-y-1.5">
            <div class="flex items-center justify-between px-1">
                <label for="password" class="text-[10px] font-bold uppercase tracking-widest text-slate-500">Mật khẩu</label>
                @if (Route::has('password.request'))
                    <a class="text-[10px] font-bold uppercase tracking-widest text-brand-600 hover:text-brand-700 transition-colors" href="{{ route('password.request') }}">Quên mật khẩu?</a>
                @endif
            </div>
            <input id="password" type="password" name="password" class="linear-input" placeholder="••••••••" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-1 ml-1" />
        </div>

        <div class="flex items-center px-1">
            <label for="remember_me" class="group flex cursor-pointer items-center gap-3">
                <div class="relative flex h-5 w-5 items-center justify-center">
                    <input id="remember_me" type="checkbox" name="remember" class="peer h-full w-full appearance-none rounded-md border border-slate-300 bg-ui-card transition-all checked:border-brand-600 checked:bg-brand-600 focus:outline-none focus:ring-2 focus:ring-brand-500/20" />
                    <svg class="pointer-events-none absolute h-3.5 w-3.5 scale-0 text-slate-100 transition-transform peer-checked:scale-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="4"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                </div>
                <span class="text-sm font-bold text-slate-600 transition-colors group-hover:text-slate-900">Nhớ phiên đăng nhập</span>
            </label>
        </div>

        <button type="submit" class="linear-btn-primary w-full py-4 text-base font-bold shadow-xl shadow-brand-500/20">
            Tiếp tục truy cập
        </button>

        <div class="pt-4 text-center">
            <p class="text-sm font-medium text-slate-500">
                Chưa có tài khoản cư trú? 
                <a href="{{ route('register') }}" class="font-bold text-brand-600 hover:text-brand-700 transition-colors">Yêu cầu cấp mới</a>
            </p>
        </div>
    </form>
</x-guest-layout>
