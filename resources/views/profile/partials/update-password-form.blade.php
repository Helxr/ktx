<section>
    <header class="mb-10 flex items-center justify-between">
        <div>
            <h2 class="font-display text-2xl font-black text-ink-primary uppercase tracking-tight">
                Bảo mật <span class="text-brand-emerald">tài khoản</span>
            </h2>
            <p class="mt-1 text-[10px] font-bold uppercase tracking-widest text-ink-secondary/50">
                Đảm bảo mật khẩu của bạn đủ mạnh để bảo vệ dữ liệu cư trú
            </p>
        </div>
        <div class="hidden sm:block">
            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-brand-50 text-brand-emerald ring-1 ring-brand-emerald/10">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" /></svg>
            </div>
        </div>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-8">
        @csrf
        @method('put')

        <div class="grid gap-8 md:grid-cols-1">
            {{-- Current Password --}}
            <div class="space-y-2 group">
                <label for="update_password_current_password" class="text-[10px] font-black uppercase tracking-[0.2em] text-ink-secondary/40 ml-1 transition-colors group-focus-within:text-brand-emerald">Mật khẩu hiện tại</label>
                <div class="relative">
                    <input id="update_password_current_password" name="current_password" type="password" class="pdu-input pl-11" autocomplete="current-password" />
                    <div class="absolute left-4 top-1/2 -translate-y-1/2 text-ink-secondary/30 group-focus-within:text-brand-emerald transition-colors">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    </div>
                </div>
                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-1 ml-1" />
            </div>

            <div class="grid gap-8 md:grid-cols-2">
                {{-- New Password --}}
                <div class="space-y-2 group">
                    <label for="update_password_password" class="text-[10px] font-black uppercase tracking-[0.2em] text-ink-secondary/40 ml-1 transition-colors group-focus-within:text-brand-emerald">Mật khẩu mới</label>
                    <div class="relative">
                        <input id="update_password_password" name="password" type="password" class="pdu-input pl-11" autocomplete="new-password" />
                        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-ink-secondary/30 group-focus-within:text-brand-emerald transition-colors">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                        </div>
                    </div>
                    <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-1 ml-1" />
                </div>

                {{-- Confirm Password --}}
                <div class="space-y-2 group">
                    <label for="update_password_password_confirmation" class="text-[10px] font-black uppercase tracking-[0.2em] text-ink-secondary/40 ml-1 transition-colors group-focus-within:text-brand-emerald">Xác nhận mật khẩu</label>
                    <div class="relative">
                        <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="pdu-input pl-11" autocomplete="new-password" />
                        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-ink-secondary/30 group-focus-within:text-brand-emerald transition-colors">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </div>
                    </div>
                    <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-1 ml-1" />
                </div>
            </div>
        </div>

        <div class="flex items-center gap-6 pt-4">
            <button type="submit" class="pdu-btn-primary px-10 py-4 text-xs font-black uppercase tracking-widest shadow-xl shadow-brand-emerald/20 transition-all hover:-translate-y-0.5 active:translate-y-0">
                Đổi mật khẩu
            </button>

            @if (session('status') === 'password-updated')
                <div
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-x-4"
                    x-transition:enter-end="opacity-100 translate-x-0"
                    x-init="setTimeout(() => show = false, 4000)"
                    class="flex items-center gap-3 text-[10px] font-black uppercase tracking-widest text-emerald-600"
                >
                    <div class="flex h-6 w-6 items-center justify-center rounded-full bg-emerald-100">
                        <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="4"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    Đã cập nhật bảo mật
                </div>
            @endif
        </div>
    </form>
</section>
