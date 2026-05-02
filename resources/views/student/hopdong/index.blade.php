@extends('student.layouts.chinh')

@section('student_page_title', 'Hợp đồng cư trú')

@section('noidung')
    @if ($hopdong->isEmpty())
        <div class="rounded-[2.5rem] border border-ui-border bg-ui-card/50 backdrop-blur-xl p-16 text-center shadow-sm animate-in fade-in zoom-in-95 duration-700">
            <div class="mx-auto mb-6 flex h-24 w-24 items-center justify-center rounded-3xl bg-ui-bg text-ink-secondary/20 ring-8 ring-ui-bg/30">
                <svg class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <h3 class="font-display text-xl font-black text-ink-primary uppercase tracking-tight">Chưa có hợp đồng</h3>
            <p class="mt-2 text-xs font-medium text-ink-secondary/60 max-w-sm mx-auto">Hợp đồng của bạn sẽ hiển thị tại đây sau khi Ban quản lý xác nhận việc xếp phòng.</p>
            <div class="mt-10">
                <a href="{{ route('student.trangchu') }}" class="pdu-btn-primary px-10 py-4 text-[10px] font-black uppercase tracking-widest shadow-xl shadow-brand-emerald/10">
                    Về trang chủ
                </a>
            </div>
        </div>
    @else
        <div class="animate-in fade-in slide-in-from-bottom-4 duration-1000">
            <article class="overflow-hidden rounded-[2rem] border border-ui-border bg-ui-card/50 backdrop-blur-xl shadow-sm transition-all hover:border-brand-emerald/10">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-ink-primary">
                        <thead class="bg-ui-bg/50 border-b border-ui-border text-[10px] font-bold uppercase tracking-widest text-ink-secondary">
                            <tr>
                                <th class="px-8 py-5">Mã hợp đồng</th>
                                <th class="px-8 py-5">Phòng ở</th>
                                <th class="px-8 py-5">Thời hạn cư trú</th>
                                <th class="px-8 py-5 text-right">Giá ký kết</th>
                                <th class="px-8 py-5 text-center">Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-ui-border">
                            @foreach ($hopdong as $item)
                                <tr class="group transition-colors hover:bg-ui-bg/30">
                                    <td class="px-8 py-6">
                                        <div class="font-display text-lg font-black text-ink-primary tabular-nums tracking-tight">#HD-{{ str_pad((string)$item->id, 6, '0', STR_PAD_LEFT) }}</div>
                                        <div class="text-[9px] font-bold text-ink-secondary/40 uppercase tracking-widest mt-1">Năm học {{ date('Y', strtotime($item->ngay_bat_dau)) }}-{{ date('Y', strtotime($item->ngay_ket_thuc)) }}</div>
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="flex items-center gap-3">
                                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-brand-50 text-brand-emerald ring-1 ring-brand-emerald/10">
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                            </div>
                                            <div>
                                                <div class="font-bold text-ink-primary text-sm">{{ $item->phong->tenphong ?? 'Chưa xác định' }}</div>
                                                <div class="text-[9px] font-bold text-ink-secondary/40 uppercase tracking-widest mt-0.5">{{ $item->phong->toa ?? 'N/A' }} • Tầng {{ $item->phong->tang ?? 'N/A' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="flex items-center gap-4">
                                            <div class="space-y-0.5">
                                                <div class="text-[8px] font-black text-ink-secondary/30 uppercase tracking-widest">Từ ngày</div>
                                                <div class="font-bold text-ink-primary tabular-nums text-xs">{{ date('d/m/Y', strtotime($item->ngay_bat_dau)) }}</div>
                                            </div>
                                            <svg class="h-4 w-4 text-ui-border" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                            <div class="space-y-0.5">
                                                <div class="text-[8px] font-black text-ink-secondary/30 uppercase tracking-widest">Đến ngày</div>
                                                <div class="font-bold text-ink-primary tabular-nums text-xs">{{ date('d/m/Y', strtotime($item->ngay_ket_thuc)) }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6 text-right">
                                        <div class="font-display text-lg font-black text-ink-primary tabular-nums tracking-tight">{{ number_format($item->giaphong_luc_ky) }}đ</div>
                                        <div class="text-[9px] font-bold text-ink-secondary/40 uppercase tracking-widest">/ tháng</div>
                                    </td>
                                    <td class="px-8 py-6 text-center">
                                        @php
                                            $status = $item->trang_thai;
                                            $badgeClass = match ($status) {
                                                \App\Enums\ContractStatus::Active->value => 'bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-600/20',
                                                \App\Enums\ContractStatus::Expired->value => 'bg-amber-50 text-amber-700 ring-1 ring-inset ring-amber-600/20',
                                                \App\Enums\ContractStatus::Terminated->value => 'bg-rose-50 text-rose-700 ring-1 ring-inset ring-rose-600/20',
                                                default => 'bg-ui-bg text-ink-secondary ring-1 ring-inset ring-ui-border',
                                            };
                                        @endphp
                                        <span class="inline-flex items-center rounded-full px-3 py-1 text-[9px] font-black uppercase tracking-widest {{ $badgeClass }}">
                                            {{ $status }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </article>
        </div>
    @endif
@endsection
