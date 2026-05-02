@extends('student.layouts.chinh')

@section('student_page_title', 'Đánh giá không gian sống')

@section('noidung')
    @if($daDanhGia)
        <div class="rounded-[3rem] border border-ui-border bg-ui-card/50 backdrop-blur-xl p-16 text-center shadow-sm animate-in fade-in zoom-in-95 duration-700">
            <div class="mx-auto mb-8 flex h-24 w-24 items-center justify-center rounded-full bg-emerald-50 text-emerald-500 shadow-inner ring-8 ring-emerald-50/50">
                <svg class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <h3 class="font-display text-2xl font-black text-ink-primary uppercase tracking-tight">Ghi nhận đánh giá!</h3>
            <p class="mt-3 text-sm font-medium text-ink-secondary/60 max-w-sm mx-auto leading-relaxed">Bạn đã hoàn thành việc đóng góp ý kiến cho tháng này. Hệ thống sẽ mở lại vào kỳ đánh giá tiếp theo.</p>
            <div class="mt-10">
                <a href="{{ route('student.phongcuatoi') }}" class="pdu-btn-primary px-10 py-4 text-[10px] font-black uppercase tracking-widest shadow-xl shadow-brand-emerald/10 inline-flex items-center gap-2">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                    Quay lại Phòng của tôi
                </a>
            </div>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 animate-in fade-in slide-in-from-bottom-4 duration-1000">
            {{-- Form Section --}}
            <div class="lg:col-span-8">
                <article class="rounded-[2.5rem] border border-ui-border bg-white p-10 shadow-sm transition-all hover:border-brand-emerald/10">
                    @if($phong)
                        <div class="mb-10 flex items-center gap-6 p-6 rounded-3xl bg-ui-bg/50 border border-ui-border">
                            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-white shadow-sm ring-1 ring-ui-border text-brand-emerald">
                                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                            </div>
                            <div>
                                <div class="text-[9px] font-black uppercase tracking-widest text-ink-secondary/40 mb-1">Đang đánh giá cho</div>
                                <div class="font-display text-xl font-black text-ink-primary uppercase tracking-tight">{{ $phong->tenphong }} <span class="text-brand-emerald opacity-40 ml-2">•</span> <span class="text-sm font-bold text-ink-secondary/60 ml-2 uppercase tracking-widest tabular-nums">Tầng {{ $phong->tang }}</span></div>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('student.themdanhgia') }}" class="space-y-10">
                            @csrf
                            
                            {{-- Star Rating --}}
                            <div class="space-y-4">
                                <label class="text-[10px] font-black uppercase tracking-[0.2em] text-ink-secondary/40 ml-1">Mức độ hài lòng</label>
                                <div class="flex flex-wrap items-center gap-4 py-8 px-10 rounded-3xl bg-slate-50 border border-slate-100 shadow-inner">
                                    @for($i = 5; $i >= 1; $i--)
                                        <div class="relative group">
                                            <input type="radio" name="diem" id="star{{ $i }}" value="{{ $i }}" class="peer sr-only" {{ old('diem', 5) == $i ? 'checked' : '' }} required>
                                            <label for="star{{ $i }}" class="cursor-pointer flex flex-col items-center gap-2 group">
                                                <div class="text-slate-300 peer-checked:text-amber-400 group-hover:text-amber-300 transition-all duration-300 transform group-hover:scale-110">
                                                    <svg class="h-12 w-12" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                    </svg>
                                                </div>
                                                <span class="text-[9px] font-black uppercase tracking-widest text-slate-400 peer-checked:text-amber-600 transition-colors">{{ $i }} Sao</span>
                                            </label>
                                        </div>
                                    @endfor
                                </div>
                                @error('diem')
                                    <p class="mt-2 text-[10px] font-bold text-rose-600 uppercase tracking-widest ml-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Feedback --}}
                            <div class="space-y-4 group">
                                <label for="nhanxet" class="text-[10px] font-black uppercase tracking-[0.2em] text-ink-secondary/40 ml-1 transition-colors group-focus-within:text-brand-emerald">Ý kiến đóng góp (Tùy chọn)</label>
                                <textarea name="nhanxet" id="nhanxet" rows="6" 
                                          class="pdu-input min-h-[150px] py-4 leading-relaxed placeholder:text-ink-secondary/20" 
                                          placeholder="Chia sẻ trải nghiệm của bạn về vệ sinh, an ninh, tiện ích hoặc thái độ phục vụ của nhân viên KTX...">{{ old('nhanxet') }}</textarea>
                                @error('nhanxet')
                                    <p class="mt-2 text-[10px] font-bold text-rose-600 uppercase tracking-widest ml-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Action --}}
                            <div class="pt-6 flex flex-col sm:flex-row items-center gap-4">
                                <button type="submit" class="w-full sm:w-auto pdu-btn-primary px-12 py-5 text-[11px] font-black uppercase tracking-[0.2em] shadow-xl shadow-brand-emerald/20 transition-all hover:-translate-y-0.5 active:translate-y-0">
                                    Gửi đánh giá ngay
                                </button>
                                <a href="{{ route('student.phongcuatoi') }}" class="w-full sm:w-auto h-14 px-8 rounded-2xl border border-ui-border text-[10px] font-black uppercase tracking-widest text-ink-secondary hover:bg-ui-bg transition-colors flex items-center justify-center">
                                    Hủy bỏ
                                </a>
                            </div>
                        </form>
                    @else
                        <div class="py-16 text-center">
                            <div class="mx-auto mb-6 flex h-20 w-20 items-center justify-center rounded-3xl bg-ui-bg text-ink-secondary/20">
                                <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                            </div>
                            <h3 class="font-display text-xl font-black text-ink-primary uppercase tracking-tight">Không tìm thấy phòng</h3>
                            <p class="mt-2 text-xs font-medium text-ink-secondary/60 max-w-sm mx-auto">Bạn cần có phòng cư trú chính thức để thực hiện chức năng đánh giá này.</p>
                            <div class="mt-8">
                                <a href="{{ route('student.danhsachphong') }}" class="pdu-btn-primary px-8 py-3 text-[10px] font-black uppercase tracking-widest">
                                    Tìm phòng ngay
                                </a>
                            </div>
                        </div>
                    @endif
                </article>
            </div>

            {{-- Sidebar --}}
            <aside class="lg:col-span-4 space-y-6">
                <article class="rounded-3xl bg-ink-primary p-8 text-white shadow-xl shadow-slate-900/10 relative overflow-hidden group">
                    <div class="absolute -right-8 -bottom-8 h-32 w-32 rounded-full bg-white/5 blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
                    <div class="relative">
                        <div class="h-12 w-12 flex items-center justify-center rounded-2xl bg-white/10 mb-6">
                            <svg class="h-6 w-6 text-brand-emerald" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <h4 class="font-display text-lg font-black uppercase tracking-tight mb-2">Tại sao cần đánh giá?</h4>
                        <p class="text-xs font-medium leading-relaxed text-white/60">Ý kiến của bạn là cơ sở để Ban quản lý điều chỉnh chất lượng dịch vụ, an ninh và vệ sinh tại KTX. Mọi đánh giá đều được bảo mật danh tính đối với các thành viên khác.</p>
                    </div>
                </article>

                <div class="rounded-3xl border border-ui-border bg-white p-8 shadow-sm">
                    <h3 class="font-display text-[11px] font-black text-ink-primary uppercase tracking-[0.2em] mb-6 flex items-center gap-2">
                        <span class="h-1.5 w-6 bg-brand-emerald rounded-full"></span>
                        Tiêu chí đánh giá
                    </h3>
                    <div class="space-y-4">
                        <div class="flex items-center gap-3">
                            <div class="h-2 w-2 rounded-full bg-brand-emerald/40"></div>
                            <span class="text-xs font-bold text-ink-secondary/70">Vệ sinh khu vực chung</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="h-2 w-2 rounded-full bg-brand-emerald/40"></div>
                            <span class="text-xs font-bold text-ink-secondary/70">An ninh & Trật tự</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="h-2 w-2 rounded-full bg-brand-emerald/40"></div>
                            <span class="text-xs font-bold text-ink-secondary/70">Cơ sở vật chất, điện nước</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="h-2 w-2 rounded-full bg-brand-emerald/40"></div>
                            <span class="text-xs font-bold text-ink-secondary/70">Thái độ hỗ trợ của BQL</span>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    @endif
@endsection
