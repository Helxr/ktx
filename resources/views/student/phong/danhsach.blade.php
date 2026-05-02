@extends('student.layouts.chinh')

@section('student_page_title', 'Danh sách phòng trống')

@section('noidung')
    <div class="mb-6 flex justify-end">
        <form method="GET" action="{{ route('student.danhsachphong') }}" class="relative group w-full md:w-72">
            <input name="q" value="{{ request('q') }}" type="text" placeholder="Tìm theo tên phòng..."
                   class="pdu-input pl-10 py-2.5 text-sm shadow-sm" />
            <div class="absolute left-3 top-1/2 -translate-y-1/2 text-ink-secondary/30">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <button type="submit" class="hidden">Tìm</button>
        </form>
    </div>

    <div class="animate-in fade-in slide-in-from-bottom-4 duration-1000">
        <article class="overflow-hidden rounded-[2rem] border border-ui-border bg-ui-card/50 backdrop-blur-xl shadow-sm transition-all hover:border-brand-emerald/10">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-ink-primary">
                    <thead class="bg-ui-bg/50 border-b border-ui-border text-[10px] font-bold uppercase tracking-widest text-ink-secondary">
                        <tr>
                            <th class="px-8 py-5">Thông tin phòng</th>
                            <th class="px-8 py-5">Khu vực / Tòa</th>
                            <th class="px-8 py-5 text-right">Đơn giá</th>
                            <th class="px-8 py-5 text-center">Tình trạng</th>
                            <th class="px-8 py-5 text-right">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-ui-border">
                        @forelse ($danhsachphong as $phong)
                            @php
                                $soNguoiDangO = $soluongdango_theophong[$phong->id] ?? 0;
                                $soChoConLai = $phong->succhuamax - $soNguoiDangO;
                            @endphp
                            <tr class="group transition-colors hover:bg-ui-bg/30">
                                <td class="px-8 py-6">
                                    <div class="font-display text-lg font-black text-ink-primary tracking-tight uppercase">{{ $phong->tenphong }}</div>
                                    <div class="text-[9px] font-bold text-ink-secondary/40 uppercase tracking-widest mt-1 flex items-center gap-1.5">
                                        <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                        {{ $phong->gioitinh === 'Nam' ? 'Dành cho Nam' : 'Dành cho Nữ' }}
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-ui-bg text-ink-secondary group-hover:bg-brand-50 group-hover:text-brand-600 transition-colors">
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                        </div>
                                        <div>
                                            <div class="font-bold text-ink-primary text-sm uppercase tracking-tight">Tòa {{ $phong->toa }}</div>
                                            <div class="text-[9px] font-bold text-ink-secondary/40 uppercase tracking-widest mt-0.5">Tầng {{ $phong->tang }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <div class="font-display text-lg font-black text-ink-primary tabular-nums tracking-tight">{{ number_format($phong->giaphong) }}đ</div>
                                    <div class="text-[9px] font-bold text-ink-secondary/40 uppercase tracking-widest">/ tháng</div>
                                </td>
                                <td class="px-8 py-6 text-center">
                                    @php
                                        $badgeClass = $soChoConLai <= 1 ? 'bg-rose-50 text-rose-700 ring-1 ring-inset ring-rose-600/20' : ($soChoConLai <= 2 ? 'bg-amber-50 text-amber-700 ring-1 ring-inset ring-amber-600/20' : 'bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-600/20');
                                    @endphp
                                    <span class="inline-flex items-center rounded-full px-3 py-1 text-[9px] font-black uppercase tracking-widest {{ $badgeClass }}">
                                        {{ $soChoConLai }} giường trống
                                    </span>
                                    <div class="text-[8px] font-bold text-ink-secondary/30 uppercase tracking-[0.2em] mt-1.5 tabular-nums">{{ $soNguoiDangO }}/{{ $phong->succhuamax }} Đang ở</div>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <form method="POST" action="{{ route('student.dangkyphong') }}">
                                        @csrf
                                        <input type="hidden" name="phong_id" value="{{ $phong->id }}">
                                        <button type="submit"
                                                class="pdu-btn-primary px-6 py-2.5 text-[9px] font-black uppercase tracking-widest shadow-lg shadow-brand-emerald/10 transition-all hover:-translate-y-0.5 active:translate-y-0">
                                            Gửi đăng ký
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-8 py-24 text-center">
                                    <div class="inline-flex h-20 w-20 items-center justify-center rounded-3xl bg-ui-bg text-ink-secondary/20 mb-6">
                                        <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                    </div>
                                    <h3 class="font-display text-xl font-black text-ink-primary uppercase tracking-tight">Không tìm thấy phòng</h3>
                                    <p class="mt-2 text-xs font-medium text-ink-secondary/60 max-w-sm mx-auto">Hiện tại không có phòng nào trống phù hợp với yêu cầu của bạn.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </article>
        
        @if(method_exists($danhsachphong, 'links'))
            <div class="mt-8">
                {{ $danhsachphong->links() }}
            </div>
        @endif
    </div>
@endsection
