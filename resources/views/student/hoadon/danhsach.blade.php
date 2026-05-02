@extends('student.layouts.chinh')

@section('student_page_title', 'Hóa đơn của em')

@section('noidung')
    {{-- Desktop View --}}
    <div class="animate-in fade-in slide-in-from-bottom-4 duration-1000">
        <article class="overflow-hidden rounded-xl border border-ui-border bg-ui-card shadow-sm transition-all hover:border-brand-emerald/10">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-ink-primary">
                    <thead class="bg-ui-bg/50 border-b border-ui-border text-[10px] font-bold uppercase tracking-widest text-ink-secondary">
                        <tr>
                            <th class="px-8 py-5">Kỳ hóa đơn</th>
                            <th class="px-8 py-5">Chỉ số tiêu thụ</th>
                            <th class="px-8 py-5 text-right">Tổng tiền</th>
                            <th class="px-8 py-5 text-center">Trạng thái</th>
                            <th class="px-8 py-5 text-right">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-ui-border">
                        @forelse ($hoadon as $item)
                            <tr class="group transition-colors hover:bg-ui-bg/30">
                                <td class="px-8 py-6">
                                    <div class="font-display text-lg font-black text-ink-primary tabular-nums tracking-tight">Tháng {{ $item->thang }}/{{ $item->nam }}</div>
                                    <div class="text-[9px] font-bold text-ink-secondary/40 uppercase tracking-widest mt-1 flex items-center gap-1.5">
                                        <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                        #INV-{{ str_pad((string)$item->id, 6, '0', STR_PAD_LEFT) }}
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-6">
                                        <div class="flex items-center gap-2.5">
                                            <div class="flex h-7 w-7 items-center justify-center rounded-lg bg-amber-50 text-amber-600 ring-1 ring-amber-500/10">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                            </div>
                                            <div class="text-[10px] font-bold tabular-nums text-ink-secondary/80">Điện: {{ $item->chisodienmoi }}</div>
                                        </div>
                                        <div class="flex items-center gap-2.5">
                                            <div class="flex h-7 w-7 items-center justify-center rounded-lg bg-blue-50 text-blue-600 ring-1 ring-blue-500/10">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                            </div>
                                            <div class="text-[10px] font-bold tabular-nums text-ink-secondary/80">Nước: {{ $item->chisonuocmoi }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <div class="font-display text-xl font-black text-ink-primary tabular-nums tracking-tight">{{ number_format($item->tongtien) }}đ</div>
                                </td>
                                <td class="px-8 py-6 text-center">
                                    @php
                                        $status = $item->trangthaithanhtoan;
                                        $badgeClass = match($status) {
                                            \App\Enums\InvoiceStatus::Paid->value => 'bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-600/20',
                                            \App\Enums\InvoiceStatus::PendingConfirmation->value => 'bg-blue-50 text-blue-700 ring-1 ring-inset ring-blue-700/10',
                                            default => 'bg-rose-50 text-rose-700 ring-1 ring-inset ring-rose-600/20 animate-pulse'
                                        };
                                        $statusText = match($status) {
                                            \App\Enums\InvoiceStatus::Paid->value => 'Đã thanh toán',
                                            \App\Enums\InvoiceStatus::PendingConfirmation->value => 'Chờ xác nhận',
                                            default => 'Chưa thanh toán'
                                        };
                                    @endphp
                                    <span class="inline-flex items-center rounded-full px-3 py-1 text-[9px] font-black uppercase tracking-widest {{ $badgeClass }}">
                                        {{ $statusText }}
                                    </span>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <button
                                        type="button"
                                        data-modal-target="modal-bienlai-{{ $item->id }}"
                                        data-modal-toggle="modal-bienlai-{{ $item->id }}"
                                        class="pdu-btn-primary px-6 py-2.5 text-[9px] font-black uppercase tracking-widest shadow-lg shadow-brand-emerald/10 transition-all hover:-translate-y-0.5"
                                    >
                                        Chi tiết
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-8 py-24 text-center">
                                    <div class="inline-flex h-16 w-16 items-center justify-center rounded-xl bg-ui-bg text-ink-secondary/20 mb-4">
                                        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    </div>
                                    <div class="text-sm font-black text-ink-primary uppercase tracking-tight">Chưa có hóa đơn nào</div>
                                    <p class="text-[11px] text-ink-secondary mt-1">Lịch sử thanh toán sẽ hiển thị sau khi dữ liệu tháng đầu tiên được chốt.</p>
                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>
        </article>
        
        @if(method_exists($hoadon, 'links'))
            <div class="mt-8">
                {{ $hoadon->links() }}
            </div>
        @endif
    </div>

    {{-- Modals Redesign --}}
    @foreach ($hoadon as $item)
        <div id="modal-bienlai-{{ $item->id }}" tabindex="-1" aria-hidden="true" 
             class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/60 p-4  animate-in fade-in duration-300">
            <div class="w-full max-w-2xl rounded-2xl bg-ui-card p-10 shadow-md ring-1 ring-ui-border animate-in zoom-in-95 duration-500">
                <div class="mb-10 flex items-start justify-between">
                    <div>
                        <div class="inline-flex items-center gap-2 rounded-full bg-brand-50 px-3 py-1 text-[8px] font-black uppercase tracking-widest text-brand-emerald ring-1 ring-brand-emerald/20 mb-3">
                            Biên lai điện tử • {{ $item->thang }}/{{ $item->nam }}
                        </div>
                        <h3 class="font-display text-3xl font-black text-ink-primary tracking-tighter uppercase">Thông tin <span class="text-brand-emerald">Thanh toán</span></h3>
                        <p class="text-[10px] font-bold text-ink-secondary/40 uppercase tracking-[0.2em] mt-1.5">Mã tra soát: #INV-{{ str_pad((string)$item->id, 8, '0', STR_PAD_LEFT) }}</p>
                    </div>
                    <button type="button" class="flex h-12 w-12 items-center justify-center rounded-full bg-ui-bg text-ink-secondary hover:bg-ui-border hover:text-ink-primary transition-all" 
                            data-modal-hide="modal-bienlai-{{ $item->id }}">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-12 gap-10 mb-10">
                    <div class="md:col-span-7 space-y-6">
                        <div class="grid grid-cols-2 gap-6">
                            <div class="space-y-1">
                                <span class="text-[9px] font-black uppercase tracking-widest text-ink-secondary/40">Phòng ở</span>
                                <div class="font-bold text-ink-primary text-base">{{ optional($item->phong)->tenphong ?? 'N/A' }}</div>
                            </div>
                            <div class="space-y-1">
                                <span class="text-[9px] font-black uppercase tracking-widest text-ink-secondary/40">Loại phòng</span>
                                <div class="font-bold text-ink-primary text-base">{{ optional($item->phong)->loaiphong ?? 'Tiêu chuẩn' }}</div>
                            </div>
                        </div>

                        <div class="rounded-xl bg-ui-bg/40 border border-ui-border/50 p-6 space-y-4">
                            <div class="flex justify-between items-center text-xs">
                                <span class="font-bold text-ink-secondary/60 uppercase tracking-widest">Cố định phòng</span>
                                <span class="font-black text-ink-primary tabular-nums tracking-tight text-sm">{{ number_format(optional($item->phong)->giaphong ?? 0) }}đ</span>
                            </div>
                            <div class="flex justify-between items-center text-xs">
                                <span class="font-bold text-ink-secondary/60 uppercase tracking-widest">Tiêu thụ Điện</span>
                                <span class="font-black text-ink-primary tabular-nums tracking-tight text-sm">{{ number_format(($item->chisodienmoi - $item->chisodiencu) * 3500) }}đ</span>
                            </div>
                            <div class="flex justify-between items-center text-xs">
                                <span class="font-bold text-ink-secondary/60 uppercase tracking-widest">Tiêu thụ Nước</span>
                                <span class="font-black text-ink-primary tabular-nums tracking-tight text-sm">{{ number_format(($item->chisonuocmoi - $item->chisonuoccu) * 15000) }}đ</span>
                            </div>
                            <div class="pt-4 mt-2 border-t border-ui-border/60 flex justify-between items-end">
                                <span class="text-[10px] font-black text-ink-primary uppercase tracking-[0.2em]">Tổng cộng</span>
                                <span class="font-display text-3xl font-black text-brand-emerald tabular-nums tracking-tighter">{{ number_format($item->tongtien) }}đ</span>
                            </div>
                        </div>
                    </div>

                    <div class="md:col-span-5 flex flex-col items-center justify-center p-6 rounded-xl bg-slate-50 border border-slate-100 ring-4 ring-white shadow-inner">
                        @php
                            $phongTen = optional($item->phong)->tenphong ?? 'N/A';
                            $qrText = 'KTX - ' . $phongTen . ' - ' . $item->thang . '/' . $item->nam . ' - ' . number_format($item->tongtien) . 'd';
                            $qrUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=' . urlencode($qrText);
                        @endphp
                        <div class="relative group cursor-none">
                            <div class="absolute -inset-2 rounded-2xl bg-gradient-to-tr from-brand-emerald/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                            <img src="{{ $qrUrl }}" alt="QR" class="relative h-40 w-40 object-contain rounded-xl mix-blend-multiply" />
                        </div>
                        <div class="mt-4 text-[10px] font-black text-ink-secondary/40 uppercase tracking-[0.25em] text-center">Quét mã chuyển khoản<br/>(QR-Banking)</div>
                    </div>
                </div>

                <div class="flex gap-4">
                    <button class="flex-1 h-14 flex items-center justify-center rounded-2xl bg-ui-bg text-[10px] font-black uppercase tracking-widest text-ink-primary hover:bg-ui-border transition-all">
                        <svg class="h-5 w-5 mr-2.5 opacity-40" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        Tải hóa đơn (PDF)
                    </button>
                    <button class="flex-1 h-14 flex items-center justify-center rounded-2xl bg-brand-emerald text-[10px] font-black uppercase tracking-widest text-white shadow-sm hover:bg-brand-emerald/90 transition-all hover:-translate-y-0.5">
                        Xác nhận đã chuyển
                    </button>
                </div>
            </div>
        </div>
    @endforeach
@endsection
