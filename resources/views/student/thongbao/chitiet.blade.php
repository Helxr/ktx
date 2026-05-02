@extends('student.layouts.chinh')

@section('student_page_title', 'Chi tiết thông báo')

@section('noidung')
    <div class="mb-6">
        <a href="{{ route('student.thongbao') }}" class="inline-flex items-center text-xs font-bold text-ink-secondary/40 hover:text-brand-emerald transition-colors">
            <svg class="mr-2 h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
            Quay lại danh sách
        </a>
    </div>

    <article class="max-w-none">
        <h1 class="text-2xl font-bold tracking-tight text-ink-primary leading-tight break-words mb-4">{{ $thongbao->tieude }}</h1>
        <div class="flex items-center gap-4 mb-8 pb-6 border-b border-ui-border">
            <div class="flex items-center gap-2">
                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-ui-bg text-ink-secondary/40 ring-1 ring-ui-border">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                </div>
                <span class="text-xs font-bold text-ink-secondary/40">Đăng ngày {{ date('d/m/Y', strtotime($thongbao->ngaydang)) }}</span>
                </div>
                <div class="h-4 w-px bg-ui-border"></div>
                <span class="text-xs font-bold text-brand-emerald bg-brand-50 px-2 py-0.5 rounded-md ring-1 ring-brand-emerald/10">Bản tin chính thức</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 animate-in fade-in slide-in-from-bottom-4 duration-1000">
        {{-- Main Content --}}
        <div class="lg:col-span-8">
            <article class="rounded-[2.5rem] border border-ui-border bg-ui-card/50 backdrop-blur-xl p-10 shadow-sm transition-all hover:border-brand-emerald/10">
                <div class="prose prose-slate max-w-none prose-headings:font-display prose-headings:font-black prose-headings:uppercase prose-headings:tracking-tighter prose-p:font-medium prose-p:leading-relaxed prose-p:text-ink-secondary/70">
                    {!! nl2br(e($thongbao->noidung)) !!}
                </div>
                
                <div class="mt-16 pt-8 border-t border-ui-border/60 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-ink-primary text-white shadow-lg shadow-slate-900/20">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </div>
                        <div>
                            <div class="text-[10px] font-black uppercase tracking-widest text-ink-primary">Xác thực bởi BQL</div>
                            <div class="text-[8px] font-bold uppercase tracking-[0.2em] text-ink-secondary/40">Hệ thống quản lý KTX</div>
                        </div>
                    </div>
                    <button onclick="window.print()" class="h-10 px-6 rounded-xl border border-ui-border text-[9px] font-black uppercase tracking-widest text-ink-secondary hover:bg-ui-bg transition-colors flex items-center gap-2">
                        <svg class="h-3.5 w-3.5 opacity-40" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
                        In thông báo
                    </button>
                </div>
            </article>
        </div>

        {{-- Sidebar: Related --}}
        <aside class="lg:col-span-4 space-y-6">
            <div class="rounded-3xl border border-ui-border bg-white p-8 shadow-sm">
                <h3 class="font-display text-lg font-black text-ink-primary uppercase tracking-tight mb-6 flex items-center gap-2">
                    <span class="h-1.5 w-6 bg-brand-emerald rounded-full"></span>
                    Liên quan
                </h3>
                
                @if($thongbaoLienQuan->count() > 0)
                    <div class="space-y-6">
                        @foreach($thongbaoLienQuan as $tb)
                            <a href="{{ route('student.chitietthongbao', $tb->id) }}" class="group block">
                                <div class="text-[8px] font-black text-brand-emerald uppercase tracking-widest mb-1">{{ date('d/m/Y', strtotime($tb->ngaydang)) }}</div>
                                <h4 class="text-sm font-bold text-ink-primary leading-snug tracking-tight group-hover:text-brand-emerald transition-colors line-clamp-2">{{ $tb->tieude }}</h4>
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="py-10 text-center">
                        <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-2xl bg-ui-bg text-ink-secondary/20">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 01-2 2H6a2 2 0 01-2-2m16 0l-8 4-8-4m8 4v10" /></svg>
                        </div>
                        <p class="text-[9px] font-black uppercase tracking-widest text-ink-secondary/40">Không có tin liên quan</p>
                    </div>
                @endif
                
                <div class="mt-8 pt-8 border-t border-ui-border/60">
                    <a href="{{ route('student.thongbao') }}" class="w-full h-12 flex items-center justify-center rounded-xl bg-ui-bg text-[10px] font-black uppercase tracking-widest text-ink-primary hover:bg-ui-border transition-colors">
                        Xem tất cả thông báo
                    </a>
                </div>
            </div>
            
            <article class="rounded-3xl bg-ink-primary p-8 text-white shadow-xl shadow-slate-900/10 relative overflow-hidden group">
                <div class="absolute -right-8 -bottom-8 h-32 w-32 rounded-full bg-white/5 blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
                <div class="relative">
                    <div class="h-12 w-12 flex items-center justify-center rounded-2xl bg-white/10 mb-6">
                        <svg class="h-6 w-6 text-brand-emerald" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h4 class="font-display text-lg font-black uppercase tracking-tight mb-2">Hỗ trợ sinh viên</h4>
                    <p class="text-xs font-medium leading-relaxed text-white/60 mb-6">Nếu bạn có thắc mắc về nội dung thông báo, vui lòng liên hệ văn phòng BQL tại tầng 1 tòa A1.</p>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between text-[10px] font-bold text-white/40 uppercase tracking-widest border-b border-white/5 pb-2">
                            <span>Hotline</span>
                            <span class="text-white">024.123.4567</span>
                        </div>
                    </div>
                </div>
            </article>
        </aside>
    </div>
@endsection
