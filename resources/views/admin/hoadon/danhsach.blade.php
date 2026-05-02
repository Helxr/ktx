<x-admin-layout>
    <x-slot:title>Quản lý hóa đơn tiện ích</x-slot:title>

    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold text-ink-primary font-display uppercase tracking-tight">Sổ cái hóa đơn</h1>
            <p class="text-xs font-medium text-ink-secondary/60">
                Định mức: <span class="font-bold text-ink-primary tabular-nums">{{ number_format($dongiadien) }}đ/kWh</span> điện & <span class="font-bold text-ink-primary tabular-nums">{{ number_format($dongianuoc) }}đ/m³</span> nước.
            </p>
        </div>

        <div class="flex flex-col gap-2 sm:flex-row sm:items-center">
            <button type="button" data-modal-target="modal-xulyhoadon" data-modal-toggle="modal-xulyhoadon" class="rounded-xl bg-ink-primary px-4 py-2 text-[10px] font-bold text-white shadow-sm transition-all hover:bg-ink-primary/90 active:scale-[0.98]">
                Ghi chỉ số mới
            </button>
        </div>
    </div>

    @php
        $mapphong = $danhsachphong->keyBy('id');
    @endphp

    <article class="overflow-hidden rounded-2xl bg-white border border-ui-border shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-ink-primary">
                <thead class="bg-ui-bg/50 border-b border-ui-border text-[10px] font-bold uppercase tracking-widest text-ink-secondary">
                    <tr>
                        <th class="px-6 py-4 font-bold">Định danh phòng</th>
                        <th class="px-6 py-4 font-bold">Kỳ hóa đơn</th>
                        <th class="px-6 py-4 font-bold">Tiêu thụ điện (kWh)</th>
                        <th class="px-6 py-4 font-bold">Lưu lượng nước (m³)</th>
                        <th class="px-6 py-4 font-bold">Tổng quyết toán</th>
                        <th class="px-6 py-4 font-bold">Trạng thái</th>
                        <th class="px-6 py-4 font-bold text-right">Điều phối</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-ui-border">
                    @forelse ($danhsachhoadon as $hoadon)
                        <tr class="group transition-colors hover:bg-ui-bg/50">
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-2 font-bold text-ink-primary">
                                    <div class="h-8 w-8 flex items-center justify-center rounded-lg bg-ui-bg text-ink-secondary/60 ring-1 ring-ui-border">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                    </div>
                                    {{ $mapphong[$hoadon->phong_id]->tenphong ?? 'N/A' }}
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <div class="text-sm font-bold text-ink-primary">Tháng {{ $hoadon->thang }}</div>
                                <div class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary/50 mt-0.5">{{ $hoadon->nam }}</div>
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-2 text-xs font-bold text-ink-secondary tabular-nums">
                                    <span class="text-ink-secondary/40">{{ $hoadon->chisodiencu }}</span>
                                    <svg class="h-3 w-3 text-ink-secondary/20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                    <span class="text-ink-primary">{{ $hoadon->chisodienmoi }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-2 text-xs font-bold text-ink-secondary tabular-nums">
                                    <span class="text-ink-secondary/40">{{ $hoadon->chisonuoccu }}</span>
                                    <svg class="h-3 w-3 text-ink-secondary/20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                    <span class="text-ink-primary">{{ $hoadon->chisonuocmoi }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <div class="text-base font-bold text-ink-primary font-display tabular-nums">{{ number_format($hoadon->tongtien) }}đ</div>
                            </td>
                            <td class="px-6 py-5">
                                @php
                                    $isPaid = $hoadon->trangthaithanhtoan === 'Đã thanh toán';
                                    $badgeClass = $isPaid ? 'bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-600/20' : 'bg-amber-50 text-amber-700 ring-1 ring-inset ring-amber-600/20';
                                @endphp
                                <span class="inline-flex items-center rounded-md px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider {{ $badgeClass }}">
                                    {{ $hoadon->trangthaithanhtoan }}
                                </span>
                            </td>
                            <td class="px-6 py-5 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button type="button" data-modal-target="modal-chitiethoadon-{{ $hoadon->id }}" data-modal-toggle="modal-chitiethoadon-{{ $hoadon->id }}" class="flex h-8 w-8 items-center justify-center rounded-lg border border-ui-border bg-white text-ink-secondary shadow-sm transition-colors hover:bg-ui-bg hover:text-ink-primary" title="Chi tiết quyết toán">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                                    </button>

                                    @if (!$isPaid)
                                        <form method="POST" action="{{ route('admin.xacnhanthanhtoan', $hoadon->id) }}" x-data="{ showConfirm: false }" @confirmed="$el.submit()">
                                            @csrf
                                            <button type="button" @click="$dispatch('open-confirm', { message: 'Xác nhận hóa đơn này đã được thanh toán?', action: () => showConfirm = true })" class="flex h-8 items-center justify-center rounded-lg border border-ui-border bg-white px-3 text-[10px] font-bold uppercase tracking-widest text-ink-primary shadow-sm transition-colors hover:bg-ui-bg">XN Thu tiền</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-24 text-center">
                                <div class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-ui-bg text-ink-secondary/50 mb-3">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17v-6m0 0V9a2 2 0 1 1 4 0v2m0 2v6M5 11h14"/></svg>
                                </div>
                                <div class="text-sm font-bold text-ink-primary">Lịch sử hóa đơn trống</div>
                                <div class="text-[11px] text-ink-secondary mt-1">Chưa có bản ghi nào được khởi tạo cho chu kỳ thanh toán hiện tại.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(method_exists($danhsachhoadon, 'links'))
            <div class="border-t border-ui-border px-6 py-4 bg-ui-bg/30">
                {{ $danhsachhoadon->appends(request()->query())->links() }}
            </div>
        @endif
    </article>

    @push('modals')
        <x-modal id="modal-xulyhoadon" title="Kê khai chỉ số tiện ích" subtitle="Nhập chỉ số điện nước mới nhất để hệ thống tự động kết xuất hóa đơn tháng.">
            <form method="POST" action="{{ route('admin.xulyhoadon') }}" class="space-y-6">
                @csrf
                <div>
                    <label class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary/50">Phòng cư trú chỉ định</label>
                    <select name="phong_id" class="linear-select mt-1.5 font-bold" required>
                        <option value="">-- Chọn phòng kết xuất --</option>
                        @foreach ($danhsachphong as $phong)
                            <option value="{{ $phong->id }}">{{ $phong->tenphong }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-5">
                    <div>
                        <label class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary/50">Kỳ quyết toán (Tháng)</label>
                        <input name="thang" type="number" value="{{ old('thang', now()->format('m')) }}" class="linear-input mt-1.5 font-bold tabular-nums" required />
                    </div>
                    <div>
                        <label class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary/50">Năm vận hành</label>
                        <input name="nam" type="number" value="{{ old('nam', now()->format('Y')) }}" class="linear-input mt-1.5 font-bold tabular-nums" required />
                    </div>
                </div>

                <div class="space-y-4 rounded-2xl bg-ui-bg/50 p-6 ring-1 ring-inset ring-ui-border">
                    <div class="grid grid-cols-2 gap-5">
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary/60">Chỉ số Điện Cũ</label>
                            <input name="chisodiencu" type="number" value="{{ old('chisodiencu', 0) }}" class="linear-input !bg-white tabular-nums" required />
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary/60">Chỉ số Điện Mới</label>
                            <input name="chisodienmoi" type="number" value="{{ old('chisodienmoi', 0) }}" class="linear-input !bg-white font-bold text-ink-primary tabular-nums" required />
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-5">
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary/60">Chỉ số Nước Cũ</label>
                            <input name="chisonuoccu" type="number" value="{{ old('chisonuoccu', 0) }}" class="linear-input !bg-white tabular-nums" required />
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary/60">Chỉ số Nước Mới</label>
                            <input name="chisonuocmoi" type="number" value="{{ old('chisonuocmoi', 0) }}" class="linear-input !bg-white font-bold text-ink-primary tabular-nums" required />
                        </div>
                    </div>
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="button" data-modal-hide="modal-xulyhoadon" class="flex-1 rounded-xl bg-ui-bg py-3 text-sm font-bold text-ink-primary ring-1 ring-ui-border transition-colors hover:bg-white">Hủy bỏ</button>
                    <button type="submit" class="flex-[2] rounded-xl bg-ink-primary py-3 text-sm font-bold text-white shadow-lg shadow-ink-primary/20 transition-all hover:bg-brand-emerald">Khởi tạo hóa đơn</button>
                </div>
            </form>
        </x-modal>

        @foreach ($danhsachhoadon as $hoadon)
            <x-modal id="modal-chitiethoadon-{{ $hoadon->id }}" title="Chi tiết quyết toán" subtitle="Bản tóm tắt các khoản chi phí tiện ích cho phòng {{ $mapphong[$hoadon->phong_id]->tenphong ?? 'N/A' }} kỳ {{ $hoadon->thang }}/{{ $hoadon->nam }}.">
                <div class="space-y-6">
                    <div class="divide-y divide-ui-border rounded-2xl bg-ui-bg/50 p-6 ring-1 ring-inset ring-ui-border">
                        <div class="flex items-center justify-between py-3">
                            <span class="text-sm font-bold text-ink-secondary">Tiền phòng cơ bản</span>
                            <span class="text-sm font-bold text-ink-primary tabular-nums">{{ number_format(optional($mapphong[$hoadon->phong_id])->giaphong ?? 0) }}đ</span>
                        </div>
                        <div class="flex items-center justify-between py-3">
                            <div class="flex flex-col">
                                <span class="text-sm font-bold text-ink-secondary">Tiền điện tiêu thụ</span>
                                <span class="text-[10px] font-medium text-ink-secondary/40 tabular-nums">({{ $hoadon->chisodiencu }} → {{ $hoadon->chisodienmoi }} kWh)</span>
                            </div>
                            <span class="text-sm font-bold text-ink-primary tabular-nums">{{ number_format(($hoadon->chisodienmoi - $hoadon->chisodiencu) * $dongiadien) }}đ</span>
                        </div>
                        <div class="flex items-center justify-between py-3">
                            <div class="flex flex-col">
                                <span class="text-sm font-bold text-ink-secondary">Lưu lượng nước</span>
                                <span class="text-[10px] font-medium text-ink-secondary/40 tabular-nums">({{ $hoadon->chisonuoccu }} → {{ $hoadon->chisonuocmoi }} m³)</span>
                            </div>
                            <span class="text-sm font-bold text-ink-primary tabular-nums">{{ number_format(($hoadon->chisonuocmoi - $hoadon->chisonuoccu) * $dongianuoc) }}đ</span>
                        </div>
                        <div class="flex items-center justify-between py-5">
                            <span class="text-base font-bold text-ink-primary uppercase tracking-tight font-display">Tổng quyết toán</span>
                            <span class="text-2xl font-bold text-ink-primary font-display tabular-nums">{{ number_format($hoadon->tongtien) }}đ</span>
                        </div>
                    </div>

                    <div class="flex gap-3 pt-2">
                        <button type="button" data-modal-hide="modal-chitiethoadon-{{ $hoadon->id }}" class="w-full rounded-xl bg-ui-bg py-3 text-sm font-bold text-ink-primary ring-1 ring-ui-border transition-colors hover:bg-white">Đóng bản tóm tắt</button>
                    </div>
                </div>
            </x-modal>
        @endforeach
    @endpush
</x-admin-layout>
