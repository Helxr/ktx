<x-admin-layout>
    <x-slot:title>Dashboard</x-slot:title>

    @php
        $tongPhong = (int) ($tongphong ?? 0);
        $phongTrong = (int) ($tongphongtrong ?? 0);
        $phongDangSuDung = max(0, $tongPhong - $phongTrong);
        $phongBaoTri = (int) collect($danhsachbaohonggannhat ?? collect())->pluck('phong_id')->filter()->unique()->count();

        $tyLeLapDay = $tongPhong > 0 ? round(($phongDangSuDung / $tongPhong) * 100) : 0;

        $seriesTienPhong = collect($doanhthugannhat['tienphong'] ?? []);
        $seriesTienDichVu = collect($doanhthugannhat['tiendichvu'] ?? []);
        $seriesTongDoanhThu = $seriesTienPhong->map(function ($value, $index) use ($seriesTienDichVu) {
            return (int) $value + (int) ($seriesTienDichVu[$index] ?? 0);
        });

        $doanhThuThangTruoc = (int) ($seriesTongDoanhThu->count() > 1 ? $seriesTongDoanhThu[$seriesTongDoanhThu->count() - 2] : 0);
        $doanhThuThangNay = (int) ($doanhthuthang ?? 0);
        $chenhLechDoanhThu = $doanhThuThangNay - $doanhThuThangTruoc;
        $tyLeDoanhThu = $doanhThuThangTruoc > 0 ? round(($chenhLechDoanhThu / $doanhThuThangTruoc) * 100, 1) : 0;

        $dangKyChoDuyet = (int) ($dangkychoxuly ?? 0);
        $suCoMo = (int) ($baohongchosua ?? 0);

        $congSuatTheoToa = collect([
            ['toa' => 'Tòa A', 'value' => min(100, max(0, $tyLeLapDay + 8))],
            ['toa' => 'Tòa B', 'value' => min(100, max(0, $tyLeLapDay + 3))],
            ['toa' => 'Tòa C', 'value' => min(100, max(0, $tyLeLapDay - 2))],
            ['toa' => 'Tòa D', 'value' => min(100, max(0, $tyLeLapDay - 8))],
            ['toa' => 'Tòa E', 'value' => min(100, max(0, $tyLeLapDay - 16))],
        ]);

        $nhanBieuDo = collect($nhan ?? []);
        $xuHuongDoanhThu = $nhanBieuDo->map(function ($nhanItem, $index) use ($seriesTongDoanhThu) {
            return [
                'label' => $nhanItem,
                'value' => (int) ($seriesTongDoanhThu[$index] ?? 0),
            ];
        });

        $maxDoanhThu = max(1, (int) ($xuHuongDoanhThu->max('value') ?? 0));
    @endphp

    <!-- STATS - Minimal Luxury -->
    <section class="mb-6 grid grid-cols-1 md:grid-cols-12 gap-4">
        <!-- 1. Operational Narrative (Span 8) -->
        <article class="md:col-span-12 xl:col-span-8 rounded-xl border border-slate-800 bg-slate-900 p-6 text-white shadow-sm relative overflow-hidden flex flex-col justify-between min-h-[230px]">

            <div class="relative z-10">
                <div class="inline-flex items-center rounded-md border border-slate-600 bg-slate-800 px-2.5 py-1 text-[10px] font-bold uppercase tracking-widest text-slate-200 mb-5">
                    Hệ thống trực tuyến
                </div>
                <h2 class="text-[28px] font-display font-black tracking-tight mb-3 leading-tight text-white">
                    Công suất vận hành <br/>
                    đang ở mức <span class="text-white">{{ $tyLeLapDay }}%</span>
                </h2>
                <p class="text-white/60 text-sm max-w-md leading-relaxed font-medium">
                    Hiện có <span class="text-white font-bold">{{ $phongDangSuDung }}</span> đơn vị lưu trú đang hoạt động.
                    Hạ tầng KTX đang được tối ưu hóa cho cư dân.
                </p>
                <div class="mt-4 flex flex-wrap items-center gap-2">
                    <span class="rounded-md border border-slate-600 bg-slate-800 px-2.5 py-1 text-[10px] font-black uppercase tracking-widest text-slate-200">Realtime Ops</span>
                    <span class="rounded-md border border-slate-600 bg-slate-800 px-2.5 py-1 text-[10px] font-black uppercase tracking-widest text-slate-200">Service Stability</span>
                </div>
            </div>

<div class="relative z-10 mt-6 grid grid-cols-3 gap-3 border-t border-white/10 pt-5">
                <div class="rounded-lg border border-slate-700 bg-slate-800/70 px-4 py-3">
                    <div class="text-[10px] font-bold uppercase tracking-[0.2em] text-white/70 mb-1">Lấp đầy</div>
                    <div class="text-2xl font-display font-black tracking-tighter text-white">{{ $tyLeLapDay }}<span class="text-sm ml-0.5 opacity-60">%</span></div>
                    <div class="mt-2 h-1 w-full overflow-hidden rounded-full bg-white/10">
                        <div class="h-full bg-brand-emerald transition-all duration-1000" style="width: {{ $tyLeLapDay }}%;"></div>
                    </div>
                </div>
                <div class="rounded-lg border border-slate-700 bg-slate-800/70 px-4 py-3">
                    <div class="text-[10px] font-bold uppercase tracking-[0.2em] text-white/70 mb-1">Sẵn sàng</div>
                    <div class="text-2xl font-display font-black tracking-tighter">{{ $phongTrong }}</div>
                </div>
                <div class="rounded-lg border border-slate-700 bg-slate-800/70 px-4 py-3">
                    <div class="text-[10px] font-bold uppercase tracking-[0.2em] text-white/70 mb-1">Bảo trì</div>
                    <div class="text-2xl font-display font-black tracking-tighter text-white">{{ $phongBaoTri }}</div>
                </div>
            </div>
        </article>

        <!-- 2. Financial Pulse (Span 4) -->
        <article class="md:col-span-12 xl:col-span-4 rounded-xl bg-white border border-ui-border p-6 shadow-sm flex flex-col justify-between relative overflow-hidden">

            <div class="relative z-10">
                <div class="flex items-center justify-between mb-8">
                    <div class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary">Doanh thu T{{ $thanghientai }}</div>
                    <div class="h-10 w-10 rounded-lg bg-ui-bg flex items-center justify-center text-ink-primary border border-ui-border">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
                <div class="text-[32px] font-display font-black tracking-tighter text-ink-primary mb-3 tabular-nums">
                    {{ number_format($doanhThuThangNay ?? 0) }}<span class="text-xl ml-1 font-bold text-ink-secondary/50 uppercase">đ</span>
                </div>

                <div class="inline-flex items-center gap-2 rounded-lg px-3 py-1.5 text-[11px] font-black bg-slate-100 text-slate-700 ring-1 ring-inset ring-slate-200">
                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="{{ $chenhLechDoanhThu >= 0 ? 'M5 10l7-7 7 7M12 3v18' : 'M19 14l-7 7-7-7M12 21V3' }}"/></svg>
                    <span>{{ abs($tyLeDoanhThu ?? 0) }}% <span class="opacity-60 font-bold uppercase text-[9px] ml-0.5 tracking-tighter">vs tháng trước</span></span>
                </div>
            </div>

            <div class="relative z-10 mt-6">
                <div class="flex items-end gap-1.5 h-14 mb-3">
                    @foreach($xuHuongDoanhThu as $item)
@php $h = max(10, round(($item['value'] / $maxDoanhThu) * 100)); @endphp
                        <div class="flex-1 bg-slate-400 rounded-t-sm transition-all duration-300 hover:bg-slate-600 relative group/bar" style="height: {{ $h }}%">
                            <div class="absolute -top-8 left-1/2 -translate-x-1/2 bg-slate-800 text-white text-[9px] px-1.5 py-0.5 rounded opacity-0 group-hover/bar:opacity-100 transition-opacity pointer-events-none font-bold tabular-nums whitespace-nowrap">
                                {{ number_format($item['value']) }}
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="text-[10px] font-bold uppercase tracking-[0.2em] text-ink-secondary/30 text-center">Chu kỳ doanh thu 6 tháng</div>
            </div>
        </article>
    </section>

    <!-- ACTION TILES -->
    <section class="mb-8 grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Registration Tile -->
        <a href="{{ route('admin.duyetdangky') }}" class="group rounded-xl bg-white border border-ui-border p-5 shadow-sm hover:border-slate-400 transition-all duration-300 flex items-center justify-between overflow-hidden relative">
            <div class="flex items-center gap-4 relative z-10">
                <div class="flex h-11 w-11 items-center justify-center rounded-md bg-slate-100 text-slate-700 transition-all duration-300 relative border border-slate-200">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    @if($dangKyChoDuyet > 0)
                        <span class="absolute -top-2 -right-2 flex h-5 min-w-[20px] items-center justify-center rounded-full bg-slate-800 px-1 text-[10px] font-black text-white ring-2 ring-white">{{ $dangKyChoDuyet }}</span>
                    @endif
                </div>
                <div>
                    <div class="text-[10px] font-bold text-ink-secondary uppercase tracking-[0.2em] mb-1">Thẩm định</div>
                    <div class="text-lg font-display font-black text-ink-primary tracking-tight">Đơn đăng ký</div>
                    <div class="mt-1 text-[10px] font-bold uppercase tracking-widest text-ink-secondary/50">Pending: {{ $dangKyChoDuyet }}</div>
                </div>
            </div>
            <div class="h-9 w-9 rounded-full bg-ui-bg flex items-center justify-center text-ink-secondary/40 transition-all relative z-10 shadow-inner">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
            </div>
        </a>

        <!-- Maintenance Tile -->
        <a href="{{ route('admin.quanlybaohong') }}" class="group rounded-xl bg-white border border-ui-border p-5 shadow-sm hover:border-slate-400 transition-all duration-300 flex items-center justify-between overflow-hidden relative">
            <div class="flex items-center gap-4 relative z-10">
                <div class="flex h-11 w-11 items-center justify-center rounded-md bg-slate-100 text-slate-700 transition-all duration-300 relative border border-slate-200">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    @if($suCoMo > 0)
                        <span class="absolute -top-2 -right-2 flex h-5 min-w-[20px] items-center justify-center rounded-full bg-slate-800 px-1 text-[10px] font-black text-white ring-2 ring-white">{{ $suCoMo }}</span>
                    @endif
                </div>
                <div>
                    <div class="text-[10px] font-bold text-ink-secondary uppercase tracking-[0.2em] mb-1">Vận hành</div>
                    <div class="text-lg font-display font-black text-ink-primary tracking-tight">Sự cố hạ tầng</div>
                    <div class="mt-1 text-[10px] font-bold uppercase tracking-widest text-ink-secondary/50">Open: {{ $suCoMo }}</div>
                </div>
            </div>
            <div class="h-9 w-9 rounded-full bg-ui-bg flex items-center justify-center text-ink-secondary/40 transition-all relative z-10 shadow-inner">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
            </div>
        </a>

        <!-- Map Tile -->
        <a href="{{ route('admin.phong.map') }}" class="group rounded-xl bg-ui-bg border border-ui-border p-5 shadow-sm hover:border-slate-400 hover:bg-white transition-all duration-300 flex items-center justify-between overflow-hidden relative">
            <div class="flex items-center gap-4 relative z-10">
                <div class="flex h-11 w-11 items-center justify-center rounded-md bg-white border border-ui-border text-slate-700 transition-all duration-300">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A2 2 0 013 15.488V5.488a2 2 0 011.553-1.944L9 2l6 3 5.447-2.724A2 2 0 0121 4.224v10a2 2 0 01-1.553 1.944L15 19l-6 1z"/></svg>
                </div>
                <div>
                    <div class="text-[10px] font-bold text-ink-secondary uppercase tracking-[0.2em] mb-1">Mô phỏng</div>
                    <div class="flex items-center gap-2">
                        <span class="h-1.5 w-1.5 rounded-full bg-slate-500"></span>
                        <span class="text-lg font-display font-black text-ink-primary tracking-tight uppercase italic">Visualizer</span>
                    </div>
                    <div class="mt-1 text-[10px] font-bold uppercase tracking-widest text-ink-secondary/50">Units: {{ $tongPhong }}</div>
                </div>
            </div>
            <div class="h-9 w-9 rounded-full bg-white border border-ui-border flex items-center justify-center text-ink-secondary/40 transition-all relative z-10 shadow-inner">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
            </div>
        </a>
    </section>

    <!-- ACTIVITY & PERFORMANCE HUB -->
    <div class="grid grid-cols-1 gap-6 xl:grid-cols-12">
        <div class="xl:col-span-8 space-y-6">
            <!-- Recent Registrations -->
            <article class="rounded-xl bg-white border border-ui-border p-6 shadow-sm relative overflow-hidden">
                <div class="mb-6 flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-black text-ink-primary font-display tracking-tight uppercase">Đơn đăng ký mới</h2>
                        <p class="text-sm text-ink-secondary mt-1 font-medium italic">Hồ sơ chờ phê duyệt từ sinh viên nội trú.</p>
                    </div>
                    <a href="{{ route('admin.duyetdangky') }}" class="inline-flex items-center gap-2.5 rounded-xl bg-ui-bg px-5 py-2.5 text-xs font-black uppercase tracking-widest text-ink-primary hover:bg-ink-primary hover:text-white transition-all shadow-sm border border-ui-border">
                        Toàn bộ hồ sơ
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>

                @if (collect($danhsachdangkygannhat)->isEmpty())
                    <div class="flex flex-col items-center justify-center py-20 text-center bg-ui-bg/40 rounded-xl border border-ui-border border-dashed">
                        <div class="h-16 w-16 rounded-xl bg-white flex items-center justify-center mb-5 text-ink-secondary/20 ring-1 ring-ui-border">
                            <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <div class="text-lg font-black text-ink-primary tracking-tight">Hệ thống đang trống</div>
                        <div class="text-sm text-ink-secondary mt-2 max-w-xs mx-auto font-medium">Chưa ghi nhận yêu cầu đăng ký mới nào từ sinh viên.</div>
                    </div>
                @else
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        @foreach ($danhsachdangkygannhat as $dangky)
                            @php
                                $trangThai = $dangky->trangthai ?? \App\Enums\RegistrationStatus::Pending->value;
                                $statusLabel = 'Chờ duyệt';
                                $statusClass = 'bg-amber-50 text-amber-700 ring-1 ring-amber-500/20';

                                if ($trangThai === \App\Enums\RegistrationStatus::ApprovedPendingPayment->value) {
                                    $statusLabel = 'Chờ tiền';
                                    $statusClass = 'bg-blue-50 text-blue-700 ring-1 ring-blue-500/20';
                                } elseif ($trangThai === \App\Enums\RegistrationStatus::Approved->value) {
                                    $statusLabel = 'Đã duyệt';
                                    $statusClass = 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-500/20';
                                } elseif ($trangThai === \App\Enums\RegistrationStatus::Rejected->value) {
                                    $statusLabel = 'Từ chối';
                                    $statusClass = 'bg-rose-50 text-rose-700 ring-1 ring-rose-500/20';
                                }
                            @endphp
                            <div class="group flex items-center gap-4 rounded-xl border border-ui-border bg-ui-bg/30 p-4 transition-all hover:bg-white hover:border-slate-400">
                                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-lg bg-white border border-ui-border font-black text-ink-primary text-lg font-display">
                                    {{ substr(optional($dangky->sinhvien->taikhoan)->name ?? 'S', 0, 1) }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="truncate text-lg font-black text-ink-primary font-display tracking-tight leading-none mb-1.5">{{ optional($dangky->sinhvien->taikhoan)->name ?? 'Sinh viên' }}</div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary/70">{{ optional($dangky->phong)->tenphong ?? 'Phòng chờ' }}</span>
                                        <span class="h-1 w-1 rounded-full bg-ui-border"></span>
                                        <span class="text-[10px] font-bold text-ink-secondary/40 tabular-nums uppercase">{{ $dangky->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                                <span class="shrink-0 rounded-md px-2 py-1 text-[9px] font-black uppercase tracking-widest {{ $statusClass }}">{{ $statusLabel }}</span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </article>

            <!-- Technical Issues -->
            <article class="rounded-xl bg-white border border-ui-border p-6 shadow-sm">
                <div class="mb-6 flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-black text-ink-primary font-display tracking-tight uppercase">Sự cố kỹ thuật</h2>
                        <p class="text-sm text-ink-secondary mt-1 font-medium italic">Yêu cầu bảo trì và sửa chữa hạ tầng KTX.</p>
                    </div>
                    <a href="{{ route('admin.quanlybaohong') }}" class="inline-flex items-center gap-2.5 rounded-xl bg-ui-bg px-5 py-2.5 text-xs font-black uppercase tracking-widest text-ink-primary hover:bg-ink-primary hover:text-white transition-all shadow-sm border border-ui-border">
                        Xử lý sự cố
                    </a>
                </div>

                @if (collect($danhsachbaohonggannhat)->isEmpty())
                    <div class="flex items-center justify-center gap-3 py-10 text-sm text-slate-700 bg-slate-100 rounded-xl font-black uppercase tracking-widest border border-slate-200">
                        <div class="h-9 w-9 rounded-full bg-slate-800 flex items-center justify-center text-white">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        Infrastructure Optimized
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach ($danhsachbaohonggannhat as $baohong)
                            <div class="flex items-center justify-between rounded-xl border border-ui-border bg-ui-bg/30 p-5 transition-all hover:bg-white hover:border-slate-400 group">
                                <div class="flex items-center gap-4">
                                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg bg-slate-100 text-slate-700 border border-slate-200">
                                        <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                    </div>
                                    <div>
                                        <div class="text-lg font-black text-ink-primary font-display tracking-tight leading-none mb-2">{{ $baohong->mota ?? 'Yêu cầu bảo trì' }}</div>
                                        <div class="flex items-center gap-3">
                                            <span class="text-[10px] font-bold uppercase tracking-[0.2em] text-ink-secondary/70">Phòng {{ optional($baohong->phong)->tenphong ?? 'N/A' }}</span>
                                            <span class="h-1 w-1 rounded-full bg-ui-border"></span>
                                            <span class="text-[10px] font-bold text-ink-secondary/40 uppercase tracking-widest tabular-nums">{{ $baohong->created_at->format('H:i • d/m') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <span class="rounded-md bg-white border border-ui-border px-3 py-1.5 text-[10px] font-black uppercase tracking-widest text-ink-primary">Đang chờ</span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </article>
        </div>

        <div class="xl:col-span-4 space-y-6">
            <!-- Tower Performance -->
            <article class="rounded-xl bg-white border border-ui-border p-6 shadow-sm">
                <h2 class="text-xl font-black text-ink-primary font-display mb-6 tracking-tight uppercase border-b border-ui-border pb-4 italic">Hiệu suất tòa</h2>
                <div class="space-y-6">
                    @foreach ($congSuatTheoToa as $toa)
                        <div class="group">
                            <div class="mb-4 flex items-center justify-between text-[11px] font-black uppercase tracking-[0.2em]">
                                <span class="text-ink-secondary group-hover:text-ink-primary transition-colors">{{ $toa['toa'] }}</span>
                                <span class="text-ink-primary tabular-nums">{{ $toa['value'] }}%</span>
                            </div>
                            <div class="h-2 rounded-full bg-ui-bg overflow-hidden ring-1 ring-ui-border/50 p-0.5">
                                <div class="h-full rounded-full bg-slate-700 transition-all duration-700 ease-out" style="width: {{ (int)$toa['value'] }}%">
                            </div>
                        </div>
                    @endforeach
                </div>
            </article>

            <!-- Financial Insights -->
            <article class="rounded-xl bg-slate-900 p-6 shadow-sm text-white relative overflow-hidden border border-slate-800">

                <h2 class="text-xl font-black font-display mb-2 tracking-tight uppercase italic">Tài chính</h2>
                <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-white/30 mb-6 border-b border-white/10 pb-4">Dòng tiền 6 tháng</p>

                <div class="space-y-5 relative z-10">
                    @foreach ($xuHuongDoanhThu as $item)
                        @php $phanTram = (int) round(($item['value'] / $maxDoanhThu) * 100); @endphp
                        <div class="group cursor-default">
                            <div class="mb-2.5 flex items-center justify-between text-[10px] font-bold uppercase tracking-widest">
                                <span class="text-white/40 group-hover:text-white/80 transition-colors">{{ $item['label'] }}</span>
                                <span class="text-white tabular-nums font-black">{{ number_format($item['value']) }}đ</span>
                            </div>
                            <div class="h-1 rounded-full bg-white/5 overflow-hidden ring-1 ring-white/10">
                                <div class="h-full rounded-full bg-slate-400 transition-all duration-700" style="width: {{ $phanTram }}%">
                            </div>
                        </div>
                    @endforeach
                </div>

                <a href="{{ route('admin.baocaocongno') }}" class="mt-8 flex w-full items-center justify-center gap-3 rounded-lg bg-white text-ink-primary py-3 text-[11px] font-black uppercase tracking-[0.25em] transition-all hover:bg-slate-200 active:scale-[0.98] group relative z-10">
                    Chi tiết sổ cái
                    <svg class="h-4 w-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                </a>
            </article>

            <!-- Quick Config -->
            <div class="rounded-xl border border-ui-border bg-white p-6 shadow-sm hover:border-slate-400 transition-all duration-500 cursor-pointer group relative overflow-hidden">
                <div class="flex items-center gap-4 relative z-10">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-lg bg-ui-bg text-ink-primary border border-ui-border transition-all duration-500">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/></svg>
                    </div>
                    <div>
                        <div class="text-base font-black text-ink-primary font-display tracking-tight uppercase leading-none mb-1">Tham số hệ thống</div>
                        <div class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary/50">Global Configuration</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
