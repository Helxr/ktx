@extends('student.layouts.chinh')

@section('student_page_title', 'Thông báo hệ thống')

@section('noidung')
    <div class="mb-6 flex items-center justify-end">
        <div class="flex items-center gap-2 bg-ui-bg/50 p-1.5 rounded-xl border border-ui-border">
            <a href="{{ route('student.thongbao') }}" 
               class="px-4 py-2 text-[10px] font-black uppercase tracking-widest transition-all rounded-lg {{ $loai === 'tatca' ? 'bg-ink-primary text-slate-100 shadow-sm' : 'text-ink-secondary/60 hover:text-ink-primary' }}">
                Tất cả
            </a>
            <a href="{{ route('student.thongbao', ['loai' => 'moi_nhat']) }}" 
               class="px-4 py-2 text-[10px] font-black uppercase tracking-widest transition-all rounded-lg {{ $loai === 'moi_nhat' ? 'bg-ink-primary text-slate-100 shadow-sm' : 'text-ink-secondary/60 hover:text-ink-primary' }}">
                Mới nhất
            </a>
        </div>
    </div>

    {{-- Stats Bento Grid --}}
    <div class="mb-10 grid gap-6 sm:grid-cols-3 animate-in fade-in slide-in-from-bottom-4 duration-700">
        <article class="group relative overflow-hidden rounded-xl border border-ui-border bg-ui-card p-6 shadow-sm transition-all hover:border-brand-emerald/30">
            <div class="relative flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-ui-bg text-ink-primary ring-1 ring-ui-border group-hover:bg-brand-50 group-hover:text-brand-600 transition-colors">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                </div>
                <div>
                    <div class="text-[9px] font-black uppercase tracking-widest text-ink-secondary/40 mb-0.5">Tổng số thông báo</div>
                    <div class="font-display text-2xl font-black text-ink-primary tabular-nums tracking-tighter">{{ $thongKe['tong_so'] }}</div>
                </div>
            </div>
        </article>
        <article class="group relative overflow-hidden rounded-xl border border-ui-border bg-ui-card p-6 shadow-sm transition-all hover:border-brand-emerald/30">
            <div class="relative flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-ui-bg text-ink-primary ring-1 ring-ui-border group-hover:bg-brand-50 group-hover:text-brand-600 transition-colors">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                </div>
                <div>
                    <div class="text-[9px] font-black uppercase tracking-widest text-ink-secondary/40 mb-0.5">Trong tháng này</div>
                    <div class="font-display text-2xl font-black text-ink-primary tabular-nums tracking-tighter">{{ $thongKe['trong_thang'] }}</div>
                </div>
            </div>
        </article>
        <article class="group relative overflow-hidden rounded-xl border border-ui-border bg-ui-card p-6 shadow-sm transition-all hover:border-brand-emerald/30">
            <div class="relative flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-ui-bg text-ink-primary ring-1 ring-ui-border group-hover:bg-brand-50 group-hover:text-brand-600 transition-colors">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-7.714 2.143L11 21l-2.286-6.857L1 12l7.714-2.143L11 3z" /></svg>
                </div>
                <div>
                    <div class="text-[9px] font-black uppercase tracking-widest text-ink-secondary/40 mb-0.5">Tin mới tuần này</div>
                    <div class="font-display text-2xl font-black text-ink-primary tabular-nums tracking-tighter">{{ $thongKe['tuan_nay'] }}</div>
                </div>
            </div>
        </article>
    </div>

    {{-- Notifications List --}}
    <div class="space-y-4 animate-in fade-in slide-in-from-bottom-4 duration-1000">
        @forelse($thongbao as $tb)
            <a href="{{ route('student.chitietthongbao', $tb->id) }}" class="group block rounded-xl border border-ui-border bg-ui-card p-8 shadow-sm transition-all hover:border-brand-emerald/40 hover:shadow-xl hover:shadow-brand-emerald/5">
                <div class="flex items-start gap-8">
                    <div class="hidden sm:flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl bg-ui-card shadow-sm ring-1 ring-ui-border group-hover:ring-brand-emerald/20 transition-all">
                        <svg class="h-8 w-8 text-ink-secondary/30 group-hover:text-brand-emerald transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.114 5.636a9 9 0 010 12.728M16.463 8.288a5.25 5.25 0 010 7.424M6.75 8.25l4.72-4.72a.75.75 0 011.28.53v15.88a.75.75 0 01-1.28.53l-4.72-4.72H4.51c-.88 0-1.704-.507-1.938-1.354A9.01 9.01 0 012.25 12c0-.83.112-1.633.322-2.396C2.806 8.756 3.63 8.25 4.51 8.25H6.75z" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="mb-2 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                            <h3 class="font-display text-xl font-black text-ink-primary uppercase tracking-tight truncate group-hover:text-brand-emerald transition-colors">{{ $tb->tieude }}</h3>
                            <div class="flex items-center gap-2 shrink-0">
                                <span class="text-[9px] font-black text-ink-secondary/40 uppercase tracking-[0.2em] tabular-nums">{{ date('d/m/Y', strtotime($tb->ngaydang)) }}</span>
                                <div class="h-1 w-1 rounded-full bg-ui-border"></div>
                                <span class="text-[9px] font-black text-brand-emerald uppercase tracking-widest">Tin mới</span>
                            </div>
                        </div>
                        <p class="line-clamp-2 text-xs font-medium leading-relaxed text-ink-secondary/60">{{ $tb->noidung }}</p>
                        
                        <div class="mt-6 flex items-center gap-4">
                            <div class="flex items-center gap-1.5 text-[9px] font-black text-ink-primary uppercase tracking-widest">
                                <svg class="h-3.5 w-3.5 opacity-30" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                Chi tiết
                            </div>
                            <div class="h-px w-8 bg-ui-border"></div>
                            <div class="text-[9px] font-black text-ink-secondary/30 uppercase tracking-[0.2em]">Bởi Ban quản lý</div>
                        </div>
                    </div>
                </div>
            </a>
        @empty
            <div class="rounded-2xl border border-ui-border bg-ui-card p-16 text-center shadow-sm">
                <div class="mx-auto mb-6 flex h-24 w-24 items-center justify-center rounded-xl bg-ui-bg text-ink-secondary/20 ring-8 ring-ui-bg/30">
                    <svg class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 01-2 2H6a2 2 0 01-2-2m16 0l-8 4-8-4m8 4v10" /></svg>
                </div>
                <h3 class="font-display text-xl font-black text-ink-primary uppercase tracking-tight">Hộp thư trống</h3>
                <p class="mt-2 text-xs font-medium text-ink-secondary/60 max-w-sm mx-auto">Hiện tại không có thông báo nào mới dành cho bạn. Hãy quay lại sau nhé!</p>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if(method_exists($thongbao, 'links'))
        <div class="mt-10">
            {{ $thongbao->links() }}
        </div>
    @endif
@endsection
