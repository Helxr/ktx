@php
    $vaitro = auth()->user()->vaitro;
    $isAdmin = in_array($vaitro, ['admin', 'admin_truong', 'admin_toanha', 'le_tan'], true);
    $layout = $isAdmin ? 'admin-layout' : 'student-layout';
@endphp

<x-dynamic-component :component="$layout">
    <x-slot:title>Hồ sơ cá nhân</x-slot:title>

    <div class="animate-in fade-in slide-in-from-bottom-4 duration-700">
        <div class="grid grid-cols-1 gap-8 lg:grid-cols-12">
            {{-- Main Column --}}
            <div class="lg:col-span-8 space-y-8">
                {{-- Profile Info Section --}}
                <article class="rounded-3xl border border-ui-border bg-ui-card/50 backdrop-blur-xl p-8 shadow-sm transition-all hover:border-brand-emerald/20">
                    @include('profile.partials.update-profile-information-form')
                </article>

                {{-- Password Section --}}
                <article class="rounded-3xl border border-ui-border bg-ui-card/50 backdrop-blur-xl p-8 shadow-sm transition-all hover:border-brand-emerald/20">
                    @include('profile.partials.update-password-form')
                </article>
            </div>

            {{-- Sidebar Column --}}
            <aside class="lg:col-span-4 space-y-8">
                {{-- Status Card --}}
                <article class="rounded-3xl border border-ui-border bg-white p-6 shadow-sm overflow-hidden relative group">
                    <div class="absolute -right-4 -top-4 h-24 w-24 rounded-full bg-brand-emerald/5 blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
                    <div class="relative">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-brand-50 text-brand-emerald">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            </div>
                            <h3 class="text-[11px] font-black uppercase tracking-[0.2em] text-ink-primary">Trạng thái hồ sơ</h3>
                        </div>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-medium text-ink-secondary">Xác minh danh tính</span>
                                <span class="rounded-full bg-emerald-50 px-2 py-0.5 text-[8px] font-black uppercase text-emerald-600 ring-1 ring-inset ring-emerald-500/20">Đã xác minh</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-medium text-ink-secondary">Bảo mật 2 lớp</span>
                                <span class="text-[10px] font-bold text-ink-secondary/40 italic">Chưa kích hoạt</span>
                            </div>
                        </div>
                    </div>
                </article>

                {{-- Support Card --}}
                <article class="rounded-3xl bg-ink-primary p-8 text-white shadow-xl shadow-slate-900/10 relative overflow-hidden group">
                    <div class="absolute -right-8 -bottom-8 h-32 w-32 rounded-full bg-white/5 blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
                    <div class="relative">
                        <div class="h-12 w-12 flex items-center justify-center rounded-2xl bg-white/10 mb-6">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <h4 class="font-display text-lg font-black uppercase tracking-tight mb-2">Hỗ trợ hồ sơ?</h4>
                        <p class="text-xs font-medium leading-relaxed text-white/60">Nếu bạn không thể cập nhật MSSV hoặc Giới tính, vui lòng liên hệ Ban quản lý KTX để được hỗ trợ xác minh trực tiếp.</p>
                    </div>
                </article>

                {{-- Delete Account Section --}}
                <article class="rounded-3xl border border-rose-100 bg-rose-50/20 p-8 shadow-sm">
                    @include('profile.partials.delete-user-form')
                </article>
            </aside>
        </div>
    </div>
</x-dynamic-component>
