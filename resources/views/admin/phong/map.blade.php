<x-admin-layout>
    <x-slot:title>Dormitory Visualizer — PDU KTX</x-slot:title>

    <div class="space-y-10">
        {{-- CAMPUS KPI --}}
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-4">
            <article class="relative overflow-hidden rounded-2xl border border-ui-border bg-white p-6 shadow-sm transition-all hover:shadow-md">
                <div class="text-[10px] font-bold uppercase tracking-[0.15em] text-ink-secondary/50">Tổng quy mô</div>
                <div class="mt-2 flex items-baseline gap-2">
                    <span class="text-3xl font-bold text-ink-primary font-display tabular-nums">384</span>
                    <span class="text-[10px] font-bold text-ink-secondary/40 uppercase">Giường</span>
                </div>
                <div class="mt-4 flex items-center gap-1.5 text-[9px] font-bold text-ink-secondary/40 uppercase tracking-wider">
                    <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m4 0h1m-4 12h1m4 0h1m-4-4h1m4 0h1m-4-4h1m4 0h1"/></svg>
                    48 Phòng • 2 Tòa • 3 Tầng
                </div>
            </article>

            <article class="relative overflow-hidden rounded-2xl border border-ui-border bg-white p-6 shadow-sm transition-all hover:shadow-md">
                <div class="text-[10px] font-bold uppercase tracking-[0.15em] text-ink-secondary/50 text-emerald-600/70">Sẵn sàng</div>
                <div class="mt-2 flex items-baseline gap-2">
                    <span class="text-3xl font-bold text-emerald-600 font-display tabular-nums">{{ number_format($campusStats['available']) }}</span>
                    <span class="text-[10px] font-bold text-emerald-600/40 uppercase italic">Trống</span>
                </div>
                <div class="mt-4 h-1 w-full overflow-hidden rounded-full bg-ui-bg">
                    <div class="h-full bg-emerald-500" style="width: {{ ($campusStats['available']/384)*100 }}%"></div>
                </div>
            </article>

            <article class="relative overflow-hidden rounded-2xl border border-ui-border bg-white p-6 shadow-sm transition-all hover:shadow-md">
                <div class="text-[10px] font-bold uppercase tracking-[0.15em] text-ink-secondary/50 text-ink-primary">Đã lưu trú</div>
                <div class="mt-2 flex items-baseline gap-2">
                    <span class="text-3xl font-bold text-ink-primary font-display tabular-nums">{{ number_format($campusStats['occupied']) }}</span>
                    <span class="text-[10px] font-bold text-ink-primary/40 uppercase italic">Người</span>
                </div>
                <div class="mt-4 h-1 w-full overflow-hidden rounded-full bg-ui-bg">
                    <div class="h-full bg-ink-primary" style="width: {{ ($campusStats['occupied']/384)*100 }}%"></div>
                </div>
            </article>

            <article class="relative overflow-hidden rounded-2xl border border-ui-border bg-white p-6 shadow-sm transition-all hover:shadow-md">
                <div class="text-[10px] font-bold uppercase tracking-[0.15em] text-ink-secondary/50 text-amber-600/70">Đang chờ</div>
                <div class="mt-2 flex items-baseline gap-2">
                    <span class="text-3xl font-bold text-amber-600 font-display tabular-nums">{{ number_format($campusStats['pending']) }}</span>
                    <span class="text-[10px] font-bold text-amber-600/40 uppercase italic">Hồ sơ</span>
                </div>
                <div class="mt-4 h-1 w-full overflow-hidden rounded-full bg-ui-bg">
                    <div class="h-full bg-amber-500" style="width: {{ ($campusStats['pending']/384)*100 }}%"></div>
                </div>
            </article>
        </div>

        {{-- FILTERS --}}
        <header class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-ink-primary font-display tracking-tight uppercase">Sơ đồ thực địa</h1>
                <p class="text-xs font-medium text-ink-secondary/60">Giám sát vị trí Tòa {{ $toa }} — Tầng {{ $tang }}</p>
            </div>

            <div class="flex items-center gap-4">
                <div class="flex items-center gap-1 rounded-xl bg-ui-bg p-1 ring-1 ring-ui-border shadow-sm">
                    @foreach($allToa as $t)
                        <a href="{{ request()->fullUrlWithQuery(['toa' => $t]) }}" 
                           class="rounded-lg px-5 py-2 text-[10px] font-bold uppercase tracking-widest transition-all {{ $toa === $t ? 'bg-white text-ink-primary shadow-sm ring-1 ring-ui-border' : 'text-ink-secondary hover:text-ink-primary' }}">
                            Tòa {{ $t }}
                        </a>
                    @endforeach
                </div>

                <div class="flex items-center gap-1 rounded-xl bg-ui-bg p-1 ring-1 ring-ui-border shadow-sm">
                    @foreach($allTang as $tg)
                        <a href="{{ request()->fullUrlWithQuery(['tang' => $tg]) }}" 
                           class="rounded-lg px-5 py-2 text-[10px] font-bold uppercase tracking-widest transition-all {{ $tang === $tg ? 'bg-white text-ink-primary shadow-sm ring-1 ring-ui-border' : 'text-ink-secondary hover:text-ink-primary' }}">
                            Tầng {{ $tg }}
                        </a>
                    @endforeach
                </div>
            </div>
        </header>

        {{-- ROOM GRID --}}
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @forelse($mapData as $data)
                @php 
                    $phong = $data['phong']; 
                    $soluongdango = $phong->so_nguoi_dang_o ?? 0;
                @endphp
                <article class="group relative rounded-2xl border border-ui-border bg-white p-5 shadow-sm transition-all hover:border-ink-primary/20 hover:shadow-md">
                    {{-- Gender Indicator --}}
                    <div class="absolute right-4 top-4">
                        <span class="inline-flex items-center rounded-full px-2 py-0.5 text-[8px] font-bold uppercase tracking-widest ring-1 ring-inset {{ $phong->gioitinh === 'Nữ' ? 'bg-rose-50 text-rose-600 ring-rose-500/20' : 'bg-blue-50 text-blue-600 ring-blue-500/20' }}">
                            {{ $phong->gioitinh }}
                        </span>
                    </div>

                    <header class="mb-5">
                        <h3 class="text-lg font-bold text-ink-primary font-display">{{ $phong->tenphong }}</h3>
                        <div class="mt-1 flex items-center gap-2">
                            <span class="text-[9px] font-bold uppercase tracking-widest text-ink-secondary/40">{{ $soluongdango }}/{{ $phong->soluongtoida }} Giường đã ở</span>
                        </div>
                    </header>

                    {{-- BED GRID --}}
                    <div class="grid grid-cols-4 gap-2">
                        @foreach($data['beds'] as $bed)
                            <div class="relative group/bed">
                                <div class="flex aspect-square flex-col items-center justify-center rounded-xl border-2 transition-all cursor-help
                                    @if($bed['status'] === 'AVAILABLE') border-emerald-50 bg-emerald-50/10 text-emerald-500 hover:border-emerald-200
                                    @elseif($bed['status'] === 'PENDING') border-amber-50 bg-amber-50/10 text-amber-500 hover:border-amber-200
                                    @else border-ui-bg bg-ui-bg/50 text-ink-primary hover:border-ink-primary/20 @endif">
                                    
                                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M7 13V11H21V13H7M7 19V17H21V19H7M2 4V22H4V19H20V22H22V4H20V7H4V4H2Z"/>
                                    </svg>
                                    <span class="mt-0.5 text-[8px] font-bold tabular-nums">{{ $bed['no'] }}</span>
                                    
                                    @if($bed['status'] === 'OCCUPIED')
                                        <div class="absolute -right-0.5 -top-0.5 h-1.5 w-1.5 rounded-full bg-ink-primary ring-2 ring-white"></div>
                                    @endif
                                </div>

                                {{-- MINIMAL TOOLTIP --}}
                                <div class="invisible absolute bottom-full left-1/2 mb-3 w-48 -translate-x-1/2 scale-95 opacity-0 transition-all group-hover/bed:visible group-hover/bed:scale-100 group-hover/bed:opacity-100 z-50">
                                    <div class="rounded-xl bg-ink-primary p-3 shadow-xl ring-1 ring-white/10">
                                        <div class="mb-2 flex items-center justify-between border-b border-white/10 pb-2">
                                            <span class="text-[8px] font-bold uppercase tracking-widest text-white/50">G.{{ $bed['no'] }}</span>
                                            <span class="text-[8px] font-bold uppercase tracking-widest {{ $bed['status'] === 'AVAILABLE' ? 'text-emerald-400' : ($bed['status'] === 'PENDING' ? 'text-amber-400' : 'text-white') }}">{{ $bed['status'] }}</span>
                                        </div>
                                        @if($bed['status'] === 'OCCUPIED')
                                            <div class="flex items-center gap-2">
                                                <img src="https://ui-avatars.com/api/?name={{ urlencode($bed['student']['name']) }}&background=ffffff&color=0f172a&bold=true" class="h-8 w-8 rounded-lg" />
                                                <div class="min-w-0">
                                                    <div class="truncate text-[10px] font-bold text-white">{{ $bed['student']['name'] }}</div>
                                                    <div class="text-[9px] text-white/40">{{ $bed['student']['mssv'] }}</div>
                                                </div>
                                            </div>
                                        @elseif($bed['status'] === 'PENDING')
                                            <div class="text-[10px] font-bold text-amber-400">{{ $bed['registration']['name'] }}</div>
                                            <div class="mt-1 text-[8px] text-white/40 italic">Đang chờ phê duyệt</div>
                                        @else
                                            <div class="text-[10px] font-bold text-emerald-400">Giường trống</div>
                                        @endif
                                    </div>
                                    <div class="absolute -bottom-1 left-1/2 h-2 w-2 -translate-x-1/2 rotate-45 bg-ink-primary"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <footer class="mt-5 border-t border-ui-border pt-4">
                        <a href="{{ route('admin.chitietphong', $phong->id) }}" class="flex items-center justify-between text-[10px] font-bold uppercase tracking-widest text-ink-secondary/60 transition-colors hover:text-ink-primary">
                            Hồ sơ vận hành
                            <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </footer>
                </article>
            @empty
                <div class="col-span-full py-20 text-center">
                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-ui-bg text-ink-secondary/20">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m4 0h1m-4 12h1m4 0h1"/></svg>
                    </div>
                    <p class="mt-4 text-[10px] font-bold uppercase tracking-widest text-ink-secondary/40">Không tìm thấy dữ liệu phòng</p>
                </div>
            @endforelse
        </div>

        {{-- LEGEND --}}
        <div class="flex items-center justify-center gap-8 border-t border-ui-border pt-10 text-[9px] font-bold uppercase tracking-[0.2em] text-ink-secondary/40">
            <div class="flex items-center gap-2">
                <span class="h-2 w-2 rounded-full bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.3)]"></span> Trống
            </div>
            <div class="flex items-center gap-2">
                <span class="h-2 w-2 rounded-full bg-amber-500 shadow-[0_0_8px_rgba(245,158,11,0.3)]"></span> Đang chờ
            </div>
            <div class="flex items-center gap-2">
                <span class="h-2 w-2 rounded-full bg-ink-primary shadow-[0_0_8px_rgba(15,23,42,0.1)]"></span> Đã ở
            </div>
        </div>
    </div>
</x-admin-layout>
