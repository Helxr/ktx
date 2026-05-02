@extends('student.layouts.chinh')

@section('student_page_title', 'Bảng điều khiển')

@section('noidung')
    @php
        $isAlumni = auth()->user()->vaitro === \App\Enums\UserRole::CuuSinhVien;
        $tongTienCanDong = (int) $hoadonchuathanhtoan->sum('tongtien');
        $ngayConLaiHopDong = null;

        if (!empty($sinhvien?->ngay_het_han)) {
            $ngayConLaiHopDong = now()->startOfDay()->diffInDays(
                \Illuminate\Support\Carbon::parse($sinhvien->ngay_het_han)->startOfDay(),
                false
            );
        }

        $tongThanhVien = (isset($thanhviencungphong) ? $thanhviencungphong->count() : 0) + ($sinhvien ? 1 : 0);
        $hoaDonGanNhat = $hoadonchuathanhtoan->take(3);
        $trangThaiDon = $isAlumni ? 'Cựu sinh viên' : 'Đang cư trú';

        if (!$isAlumni) {
            if (empty($sinhvien?->phong_id)) {
                $trangThaiDon = 'Chờ xếp phòng';
            } elseif (is_null($ngayConLaiHopDong)) {
                $trangThaiDon = 'Chờ ký Hợp đồng';
            }
        }
    @endphp

    <div class="space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-700">
        
        {{-- KPI Cards Grid --}}
        <section class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Card 1: Phòng --}}
            <article class="group relative overflow-hidden rounded-xl bg-ui-card p-6 shadow-sm transition-all hover:border-brand-emerald/30 hover:shadow-sm">
                <div class="absolute -right-6 -top-6 h-24 w-24 rounded-full bg-brand-emerald opacity-50 group-hover:scale-150 transition-transform duration-700"></div>
                <div class="relative">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-brand-50 text-brand-emerald ring-1 ring-brand-emerald/10">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        </div>
                        <span class="text-[10px] font-black uppercase tracking-[0.2em] text-ink-secondary/30">Phòng ở</span>
                    </div>
                    <div class="font-display text-2xl font-black text-ink-primary tracking-tighter mb-0.5 uppercase">{{ $phonghientai->tenphong ?? 'Chờ xếp' }}</div>
                    <div class="text-[10px] font-bold text-ink-secondary/60 uppercase tracking-widest">
                        {{ $phonghientai ? ('Tòa '.$phonghientai->toa.' • Tầng '.$phonghientai->tang) : 'Chưa có thông tin' }}
                    </div>
                </div>
            </article>

            {{-- Card 2: Tài chính --}}
            <article class="group relative overflow-hidden rounded-xl bg-ui-card p-6 shadow-sm transition-all hover:border-brand-emerald/30 hover:shadow-sm">
                <div class="absolute -right-6 -top-6 h-24 w-24 rounded-full {{ $tongTienCanDong > 0 ? 'bg-rose-500/5' : 'bg-brand-emerald/5' }} blur-xl opacity-50 group-hover:scale-150 transition-transform duration-700"></div>
                <div class="relative">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl {{ $tongTienCanDong > 0 ? 'bg-rose-50 text-rose-600 ring-1 ring-rose-500/10' : 'bg-brand-50 text-brand-emerald ring-1 ring-brand-emerald/10' }}">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <span class="text-[10px] font-black uppercase tracking-[0.2em] text-ink-secondary/30">Nghĩa vụ</span>
                    </div>
                    <div class="font-display text-2xl font-black {{ $tongTienCanDong > 0 ? 'text-rose-600' : 'text-ink-primary' }} tabular-nums tracking-tighter mb-0.5">{{ number_format($tongTienCanDong) }}đ</div>
                    <div class="text-[10px] font-bold {{ $tongTienCanDong > 0 ? 'text-rose-600/60' : 'text-emerald-600' }} uppercase tracking-widest">
                        {{ $tongTienCanDong > 0 ? 'Cần thanh toán ngay' : 'Đã hoàn tất chi phí' }}
                    </div>
                </div>
            </article>

            {{-- Card 3: Trạng thái --}}
            <article class="group relative overflow-hidden rounded-xl bg-ui-card p-6 shadow-sm transition-all hover:border-brand-emerald/30 hover:shadow-sm">
                <div class="absolute -right-6 -top-6 h-24 w-24 rounded-full bg-slate-900/5 blur-xl opacity-50 group-hover:scale-150 transition-transform duration-700"></div>
                <div class="relative">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-ui-bg text-ink-primary ring-1 ring-ui-border">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <span class="text-[10px] font-black uppercase tracking-[0.2em] text-ink-secondary/30">Hợp đồng</span>
                    </div>
                    <div class="font-display text-xl font-black text-ink-primary tracking-tighter mb-0.5 uppercase">{{ $trangThaiDon }}</div>
                    <div class="text-[10px] font-bold text-ink-secondary/60 uppercase tracking-widest">Năm học {{ date('Y') }}-{{ date('Y')+1 }}</div>
                </div>
            </article>
        </section>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            {{-- LEFT: Hóa đơn --}}
            <div class="lg:col-span-8 space-y-6">
                <article class="rounded-xl bg-ui-card overflow-hidden shadow-sm transition-all hover:border-brand-emerald/10">
                    <div class="flex items-center justify-between px-8 py-6 border-b border-ui-border bg-ui-bg/20">
                        <h2 class="text-[11px] font-black text-ink-primary uppercase tracking-[0.25em]">Hóa đơn gần nhất</h2>
                        <a href="{{ route('student.hoadoncuaem') }}" class="group flex items-center gap-1.5 text-[10px] font-black text-brand-emerald uppercase tracking-widest transition-all hover:gap-2">
                            Tất cả
                            <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                        </a>
                    </div>

                    <div class="divide-y divide-ui-border">
                        @forelse ($hoaDonGanNhat as $hoadon)
                            <div class="group flex items-center justify-between p-4 transition-colors hover:bg-ui-bg/30">
                                <div class="flex items-center gap-4 min-w-0">
                                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-ui-bg text-ink-secondary group-hover:bg-brand-50 group-hover:text-brand-600 transition-colors">
                                        @if($hoadon->loai_hoadon === 'dien_nuoc')
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                        @else
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <h4 class="font-bold text-ink-primary text-sm truncate tracking-tight">{{ $hoadon->loai_hoadon === 'dien_nuoc' ? 'Tiền điện nước' : 'Phí cư trú' }}</h4>
                                        <div class="text-[9px] font-bold text-ink-secondary/40 uppercase tracking-widest">Tháng {{ $hoadon->thang }}/{{ $hoadon->nam }}</div>
                                    </div>
                                </div>
                                <div class="text-right shrink-0 pl-4">
                                    <div class="font-display text-sm font-black text-ink-primary tabular-nums tracking-tight">{{ number_format($hoadon->tongtien) }}đ</div>
                                    @php
                                        $isPaid = $hoadon->trangthaithanhtoan === \App\Enums\InvoiceStatus::Paid;
                                    @endphp
                                    <span class="inline-flex items-center rounded-full {{ $isPaid ? 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-600/20' : 'bg-rose-50 text-rose-700 ring-1 ring-rose-600/20 animate-pulse' }} px-2 py-0.5 text-[8px] font-black uppercase tracking-widest">
                                        {{ $isPaid ? 'Đã trả' : 'Chưa trả' }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="py-16 flex flex-col items-center justify-center text-ink-secondary/20">
                                <svg class="h-10 w-10 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                <p class="text-[10px] font-black uppercase tracking-[0.2em]">Không có dữ liệu tài chính</p>
                            </div>
                        @endforelse
                    </div>
                </article>

                {{-- Quick Actions --}}
                <div class="grid grid-cols-3 gap-4">
                    <a href="{{ route('student.hoadoncuaem') }}" class="group flex flex-col items-center gap-2 p-4 rounded-2xl bg-ui-card shadow-sm transition-all hover:border-brand-emerald hover:shadow-md active:scale-[0.98]">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-ui-bg text-ink-secondary group-hover:bg-brand-50 group-hover:text-brand-600 transition-colors">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        </div>
                        <span class="text-[9px] font-black text-ink-secondary uppercase tracking-[0.15em] group-hover:text-ink-primary">Thanh toán</span>
                    </a>
                    <a href="{{ route('student.phongcuatoi') }}" class="group flex flex-col items-center gap-2 p-4 rounded-2xl bg-ui-card shadow-sm transition-all hover:border-brand-emerald hover:shadow-md active:scale-[0.98]">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-ui-bg text-ink-secondary group-hover:bg-brand-50 group-hover:text-brand-600 transition-colors">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <span class="text-[9px] font-black text-ink-secondary uppercase tracking-[0.15em] group-hover:text-ink-primary">Gia hạn</span>
                    </a>
                    <a href="{{ route('student.thongbao') }}" class="group flex flex-col items-center gap-2 p-4 rounded-2xl bg-ui-card shadow-sm transition-all hover:border-brand-emerald hover:shadow-md active:scale-[0.98]">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-ui-bg text-ink-secondary group-hover:bg-brand-50 group-hover:text-brand-600 transition-colors">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.4-1.4a2 2 0 01-.6-1.4V11a6 6 0 1 0-12 0v3.2a2 2 0 01-.6 1.4L4 17h5m6 0a3 3 0 01-6 0"/></svg>
                        </div>
                        <span class="text-[9px] font-black text-ink-secondary uppercase tracking-[0.15em] group-hover:text-ink-primary">Thông báo</span>
                    </a>
                </div>
            </div>

            {{-- RIGHT: Thông báo & Khẩn cấp --}}
            <aside class="lg:col-span-4 space-y-6">
                <article class="rounded-xl bg-ui-card overflow-hidden shadow-sm transition-all hover:border-brand-emerald/10">
                    <div class="px-8 py-6 border-b border-ui-border bg-ui-bg/20">
                        <h2 class="text-[11px] font-black text-ink-primary uppercase tracking-[0.25em]">Thông báo</h2>
                    </div>
                    <div class="divide-y divide-ui-border">
                        @forelse ($thongbao as $item)
                            <a href="{{ route('student.chitietthongbao', $item->id) }}" class="block p-4 transition-colors hover:bg-ui-bg/30">
                                <div class="text-[8px] font-black text-brand-600 uppercase tracking-widest mb-1">{{ $item->ngaydang->format('d/m/Y') }}</div>
                                <h4 class="font-bold text-ink-primary text-xs leading-snug line-clamp-2 tracking-tight">{{ $item->tieude }}</h4>
                            </a>
                        @empty
                            <div class="py-12 text-center text-ink-secondary/20">
                                <p class="text-[9px] font-black uppercase tracking-[0.2em]">Hộp thư trống</p>
                            </div>
                        @endforelse
                    </div>
                </article>

                <article class="rounded-2xl bg-ink-primary p-8 text-slate-100 shadow-sm shadow-slate-900/10 relative overflow-hidden group">
                    <div class="absolute -right-8 -bottom-8 h-32 w-32 rounded-full bg-ui-card opacity-50 transition-transform group-hover:scale-150 duration-700"></div>
                    <div class="relative">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-ui-card/10 text-slate-100 ring-1 ring-white/20">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <h2 class="text-[11px] font-black uppercase tracking-[0.3em] opacity-60">Hỗ trợ khẩn cấp</h2>
                        </div>
                        <div class="space-y-4">
                            @foreach ($lienhekhancap as $contact)
                                <div class="flex items-center justify-between border-b border-white/5 pb-4 last:border-0 last:pb-0 group/line">
                                    <span class="text-xs font-bold text-white/70 transition-colors group-hover/line:text-slate-100">{{ $contact['title'] }}</span>
                                    <a href="tel:{{ $contact['phone'] }}" class="font-display text-sm font-black tabular-nums tracking-tight hover:text-brand-emerald transition-colors">{{ $contact['phone'] }}</a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </article>
            </aside>
        </div>
    </div>
@endsection
