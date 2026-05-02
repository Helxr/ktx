<section>
    <header class="mb-10 flex items-center justify-between">
        <div>
            <h2 class="font-display text-2xl font-black text-ink-primary uppercase tracking-tight">
                Thông tin <span class="text-brand-emerald">định danh</span>
            </h2>
            <p class="mt-1 text-[10px] font-bold uppercase tracking-widest text-ink-secondary/50">
                Cập nhật thông tin cơ bản và định danh sinh viên
            </p>
        </div>
        <div class="hidden sm:block">
            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-brand-50 text-brand-emerald ring-1 ring-brand-emerald/10">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0zm1.294 6.336a6.721 6.721 0 01-3.17.789 6.721 6.721 0 01-3.168-.789 3.376 3.376 0 016.338 0z" /></svg>
            </div>
        </div>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-10">
        @csrf
        @method('patch')

        {{-- Basic Info Grid --}}
        <div class="grid gap-8 md:grid-cols-2">
            {{-- Name --}}
            <div class="space-y-2 group">
                <label for="name" class="text-[10px] font-black uppercase tracking-[0.2em] text-ink-secondary/40 ml-1 transition-colors group-focus-within:text-brand-emerald">Họ và tên</label>
                <div class="relative">
                    <input id="name" name="name" type="text" class="pdu-input pl-11" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
                    <div class="absolute left-4 top-1/2 -translate-y-1/2 text-ink-secondary/30 group-focus-within:text-brand-emerald transition-colors">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                </div>
                <x-input-error class="mt-1 ml-1" :messages="$errors->get('name')" />
            </div>

            {{-- Email --}}
            <div class="space-y-2 group">
                <label for="email" class="text-[10px] font-black uppercase tracking-[0.2em] text-ink-secondary/40 ml-1 transition-colors group-focus-within:text-brand-emerald">Địa chỉ Email</label>
                <div class="relative">
                    <input id="email" name="email" type="email" class="pdu-input pl-11" value="{{ old('email', $user->email) }}" required autocomplete="username" />
                    <div class="absolute left-4 top-1/2 -translate-y-1/2 text-ink-secondary/30 group-focus-within:text-brand-emerald transition-colors">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </div>
                </div>
                <x-input-error class="mt-1 ml-1" :messages="$errors->get('email')" />

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div class="mt-4 rounded-2xl bg-amber-50/50 p-4 ring-1 ring-inset ring-amber-200/50">
                        <div class="flex items-center gap-3">
                            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-amber-100 text-amber-600">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            </div>
                            <p class="text-xs font-bold text-amber-800">
                                Email chưa được xác minh.
                                <button form="send-verification" class="ml-1 underline decoration-amber-500/30 underline-offset-4 hover:text-amber-900 transition-colors">
                                    Gửi lại mã
                                </button>
                            </p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        @if($user->vaitro === 'sinhvien')
            <div class="pt-10 border-t border-ui-border grid gap-8 md:grid-cols-2">
                {{-- Mã sinh viên --}}
                <div class="space-y-2 group">
                    <label for="masinhvien" class="text-[10px] font-black uppercase tracking-[0.2em] text-ink-secondary/40 ml-1">Mã sinh viên</label>
                    <input id="masinhvien" name="masinhvien" type="text" class="pdu-input bg-ui-bg/50 cursor-not-allowed opacity-80" value="{{ old('masinhvien', optional($user->sinhvien)->masinhvien) }}" readonly />
                    <p class="text-[9px] font-medium text-ink-secondary/40 ml-1 italic">* Liên hệ BQL để thay đổi MSSV</p>
                </div>

                {{-- Lớp --}}
                <div class="space-y-2 group">
                    <label for="lop" class="text-[10px] font-black uppercase tracking-[0.2em] text-ink-secondary/40 ml-1 transition-colors group-focus-within:text-brand-emerald">Lớp / Khóa học</label>
                    <input id="lop" name="lop" type="text" class="pdu-input" value="{{ old('lop', optional($user->sinhvien)->lop) }}" placeholder="Ví dụ: CNTT K15" />
                    <x-input-error class="mt-1 ml-1" :messages="$errors->get('lop')" />
                </div>

                {{-- Số điện thoại --}}
                <div class="space-y-2 group">
                    <label for="sodienthoai" class="text-[10px] font-black uppercase tracking-[0.2em] text-ink-secondary/40 ml-1 transition-colors group-focus-within:text-brand-emerald">Số điện thoại</label>
                    <div class="relative">
                        <input id="sodienthoai" name="sodienthoai" type="text" class="pdu-input pl-11" value="{{ old('sodienthoai', optional($user->sinhvien)->sodienthoai) }}" />
                        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-ink-secondary/30 group-focus-within:text-brand-emerald transition-colors">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        </div>
                    </div>
                    <x-input-error class="mt-1 ml-1" :messages="$errors->get('sodienthoai')" />
                </div>

                {{-- Giới tính --}}
                <div class="space-y-2 group">
                    <label for="gioitinh" class="text-[10px] font-black uppercase tracking-[0.2em] text-ink-secondary/40 ml-1 transition-colors group-focus-within:text-brand-emerald">Giới tính</label>
                    <select id="gioitinh" name="gioitinh" class="pdu-select" required>
                        <option value="">-- Chọn giới tính --</option>
                        <option value="Nam" {{ old('gioitinh', optional($user->sinhvien)->gioitinh) === 'Nam' ? 'selected' : '' }}>Nam giới</option>
                        <option value="Nữ" {{ old('gioitinh', optional($user->sinhvien)->gioitinh) === 'Nữ' ? 'selected' : '' }}>Nữ giới</option>
                    </select>
                    <x-input-error class="mt-1 ml-1" :messages="$errors->get('gioitinh')" />
                </div>
            </div>
        @endif

        <div class="flex items-center gap-6 pt-6">
            <button type="submit" class="pdu-btn-primary px-12 py-4 text-sm font-black uppercase tracking-widest shadow-xl shadow-brand-emerald/20 transition-all hover:-translate-y-0.5 active:translate-y-0">
                Lưu hồ sơ
            </button>

            @if (session('status') === 'profile-updated')
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
                    Đã cập nhật
                </div>
            @endif
        </div>
    </form>
</section>
