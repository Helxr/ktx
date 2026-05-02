<x-admin-layout>
    <x-slot:title>Quản lý hợp đồng lưu trú</x-slot:title>

    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold text-ink-primary font-display uppercase tracking-tight">Cơ sở dữ liệu hợp đồng</h1>
            <p class="text-xs font-medium text-ink-secondary/60">Quản lý vòng đời lưu trú và thỏa thuận cư trú.</p>
        </div>

        <div class="flex flex-col gap-2 sm:flex-row sm:items-center">
            <form x-data action="{{ route('admin.quanlyhopdong') }}" method="get" class="flex flex-wrap items-center gap-2">
                <div class="relative group">
                    <div class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-ink-secondary/40 group-focus-within:text-ink-primary transition-colors">
                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <input type="text" name="timkiem" value="{{ old('timkiem', $tuKhoa) }}" placeholder="Mã sinh viên..." class="w-full sm:w-44 rounded-xl border border-ui-border bg-white py-2 pl-9 pr-4 text-xs font-medium text-ink-primary placeholder:text-ink-secondary/30 focus:border-ink-primary/30 focus:outline-none focus:ring-4 focus:ring-ink-primary/5 transition-all" />
                </div>
                
                <select name="trangthai" class="rounded-xl border border-ui-border bg-white py-2 pl-3 pr-8 text-[10px] font-bold text-ink-primary focus:border-ink-primary/30 focus:outline-none focus:ring-4 focus:ring-ink-primary/5 transition-all" @change="$el.form.submit()">
                    <option value="Tất cả" {{ $trangThai == 'Tất cả' ? 'selected' : '' }}>Tất cả</option>
                    @foreach([\App\Enums\ContractStatus::Active, \App\Enums\ContractStatus::Expired, \App\Enums\ContractStatus::Terminated] as $status)
                        <option value="{{ $status->value }}" {{ $trangThai == $status->value ? 'selected' : '' }}>{{ $status->label() }}</option>
                    @endforeach
                </select>
                
                <button type="submit" class="rounded-xl bg-ink-primary px-4 py-2 text-[10px] font-bold text-white shadow-sm transition-all hover:bg-ink-primary/90 active:scale-[0.98]">
                    Lọc dữ liệu
                </button>
            </form>
        </div>
    </div>

    <article class="overflow-hidden rounded-2xl bg-white border border-ui-border shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-ink-primary">
                <thead class="bg-ui-bg/50 border-b border-ui-border text-[10px] font-bold uppercase tracking-widest text-ink-secondary">
                    <tr>
                        <th class="px-6 py-4 font-bold">Mã HĐ</th>
                        <th class="px-6 py-4 font-bold">Sinh viên cư trú</th>
                        <th class="px-6 py-4 font-bold">Vị trí phòng</th>
                        <th class="px-6 py-4 font-bold">Thời hạn lưu trú</th>
                        <th class="px-6 py-4 font-bold">Giá trị ký kết</th>
                        <th class="px-6 py-4 font-bold">Trạng thái</th>
                        <th class="px-6 py-4 font-bold text-right">Điều phối</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-ui-border">
                    @forelse ($hopdong as $item)
                        <tr class="group transition-colors hover:bg-ui-bg/50">
                            <td class="px-6 py-5">
                                <span class="text-xs font-bold text-ink-secondary/60 tabular-nums">#{{ $item->id }}</span>
                            </td>
                            <td class="px-6 py-5">
                                <div class="font-bold text-ink-primary font-display text-base">{{ $item->sinhvien->taikhoan->name ?? '-' }}</div>
                                <div class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary mt-0.5">{{ $item->sinhvien->masinhvien ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-2 font-bold text-ink-primary">
                                    <div class="h-8 w-8 flex items-center justify-center rounded-lg bg-ui-bg text-ink-secondary/60 ring-1 ring-ui-border">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                    </div>
                                    {{ $item->phong->tenphong ?? '-' }}
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-2 text-xs font-bold text-ink-secondary">
                                    <span class="text-ink-primary">{{ $item->ngay_bat_dau }}</span>
                                    <svg class="h-3 w-3 text-ink-secondary/30" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                    <span class="text-brand-emerald">{{ $item->ngay_ket_thuc }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <div class="text-sm font-bold text-ink-primary font-display tabular-nums">{{ number_format($item->giaphong_luc_ky) }}đ</div>
                            </td>
                            <td class="px-6 py-5">
                                @php
                                    $badgeType = match ($item->trang_thai) {
                                        \App\Enums\ContractStatus::Active => 'success',
                                        \App\Enums\ContractStatus::Expired => 'warning',
                                        \App\Enums\ContractStatus::Terminated => 'danger',
                                        default => 'info',
                                    };
                                    
                                    $badgeClass = match ($badgeType) {
                                        'success' => 'bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-600/20',
                                        'warning' => 'bg-amber-50 text-amber-700 ring-1 ring-inset ring-amber-600/20',
                                        'danger' => 'bg-rose-50 text-rose-700 ring-1 ring-inset ring-rose-700/10',
                                        default => 'bg-ui-bg text-ink-secondary ring-1 ring-inset ring-ui-border'
                                    };
                                @endphp
                                <span class="inline-flex items-center rounded-md px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider {{ $badgeClass }}">
                                    {{ $item->trang_thai->label() }}
                                </span>
                            </td>
                            <td class="px-6 py-5 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button type="button" data-modal-target="modal-chi-tiet-{{ $item->id }}" data-modal-toggle="modal-chi-tiet-{{ $item->id }}" class="flex h-8 w-8 items-center justify-center rounded-lg border border-ui-border bg-white text-ink-secondary shadow-sm transition-colors hover:bg-ui-bg hover:text-ink-primary" title="Chi tiết">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </button>

                                    @if ($item->trang_thai === \App\Enums\ContractStatus::Active)
                                        <button type="button" data-modal-target="modal-gia-han-{{ $item->id }}" data-modal-toggle="modal-gia-han-{{ $item->id }}" class="flex h-8 items-center justify-center rounded-lg border border-ui-border bg-white px-3 text-[10px] font-bold uppercase tracking-widest text-ink-primary shadow-sm transition-colors hover:bg-ui-bg">Gia hạn</button>
                                    @endif

                                    @if ($item->trang_thai !== \App\Enums\ContractStatus::Terminated)
                                        <form action="{{ route('admin.hopdong.thanhly', $item->id) }}" method="post" class="inline" x-data="{ showConfirm: false }" @confirmed="$el.submit()">
                                            @csrf
                                            <button type="button" @click="$dispatch('open-confirm', { message: 'Xác nhận thanh lý hợp đồng này?', action: () => showConfirm = true })" class="flex h-8 items-center justify-center rounded-lg border border-rose-100 bg-rose-50 px-3 text-[10px] font-bold uppercase tracking-widest text-rose-600 shadow-sm transition-colors hover:bg-rose-600 hover:text-white">Thanh lý</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-24 text-center">
                                <div class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-ui-bg text-ink-secondary/50 mb-3">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01m-.01 4h.01"/></svg>
                                </div>
                                <div class="text-sm font-bold text-ink-primary">Không tìm thấy hợp đồng</div>
                                <div class="text-[11px] text-ink-secondary mt-1">Dữ liệu sẽ hiển thị sau khi sinh viên hoàn tất thủ tục đăng ký.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(method_exists($hopdong, 'links'))
            <div class="border-t border-ui-border px-6 py-4 bg-ui-bg/30">
                {{ $hopdong->appends(request()->query())->links() }}
            </div>
        @endif
    </article>

    @push('modals')
        @foreach ($hopdong as $item)
            <x-modal id="modal-chi-tiet-{{ $item->id }}" title="Chi tiết thỏa thuận" subtitle="Bản tóm tắt thỏa thuận cư trú và các điều khoản pháp lý liên quan.">
                <div class="space-y-6">
                    <div class="divide-y divide-ui-border rounded-2xl bg-ui-bg/50 p-6 ring-1 ring-inset ring-ui-border">
                        <div class="flex items-center justify-between py-3">
                            <span class="text-sm font-bold text-ink-secondary">Sinh viên cư trú</span>
                            <span class="text-sm font-bold text-ink-primary font-display">{{ $item->sinhvien->taikhoan->name ?? '-' }}</span>
                        </div>
                        <div class="flex items-center justify-between py-3">
                            <span class="text-sm font-bold text-ink-secondary">Mã định danh</span>
                            <span class="text-sm font-bold text-ink-primary tabular-nums">{{ $item->sinhvien->masinhvien ?? '-' }}</span>
                        </div>
                        <div class="flex items-center justify-between py-3">
                            <span class="text-sm font-bold text-ink-secondary">Vị trí phòng</span>
                            <span class="text-sm font-bold text-ink-primary">{{ $item->phong->tenphong ?? '-' }}</span>
                        </div>
                        <div class="grid grid-cols-2 gap-4 py-3">
                            <div>
                                <span class="block text-[10px] font-bold uppercase tracking-widest text-ink-secondary/50">Khởi tạo</span>
                                <span class="text-sm font-bold text-ink-primary tabular-nums">{{ $item->ngay_bat_dau }}</span>
                            </div>
                            <div>
                                <span class="block text-[10px] font-bold uppercase tracking-widest text-ink-secondary/50">Đáo hạn</span>
                                <span class="text-sm font-bold text-ink-primary tabular-nums">{{ $item->ngay_ket_thuc }}</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between py-3">
                            <span class="text-sm font-bold text-ink-secondary">Giá trị ký kết</span>
                            <span class="text-sm font-bold text-ink-primary font-display tabular-nums">{{ number_format($item->giaphong_luc_ky) }}đ</span>
                        </div>
                        <div class="flex items-center justify-between py-3">
                            <span class="text-sm font-bold text-ink-secondary">Trạng thái</span>
                            <span class="inline-flex items-center rounded-md px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider {{ $badgeClass }}">
                                {{ $item->trang_thai->label() }}
                            </span>
                        </div>
                        <div class="py-3">
                            <span class="block text-[10px] font-bold uppercase tracking-widest text-ink-secondary/50 mb-1">Ghi chú quản trị</span>
                            <p class="text-sm font-medium italic text-ink-secondary">{{ $item->ghichu ?? 'Không có ghi chú bổ sung.' }}</p>
                        </div>
                    </div>

                    <div class="flex gap-3 pt-2">
                        <button type="button" data-modal-hide="modal-chi-tiet-{{ $item->id }}" class="w-full rounded-xl bg-ui-bg py-3 text-sm font-bold text-ink-primary ring-1 ring-ui-border transition-colors hover:bg-white">Đóng cửa sổ</button>
                    </div>
                </div>
            </x-modal>

            <x-modal id="modal-gia-han-{{ $item->id }}" title="Gia hạn cư trú" subtitle="Thiết lập ngày đáo hạn mới cho hợp đồng #{{ $item->id }}.">
                <form action="{{ route('admin.hopdong.giahan', $item->id) }}" method="post" class="space-y-6">
                    @csrf
                    <div>
                        <label class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary/50">Ngày kết thúc mới</label>
                        <input name="ngay_ket_thuc" type="date" value="{{ old('ngay_ket_thuc', $item->ngay_ket_thuc) }}" class="linear-input mt-1.5 font-bold" required />
                        <x-input-error :messages="$errors->get('ngay_ket_thuc')" class="mt-2" />
                    </div>

                    <div class="flex gap-3 pt-4">
                        <button type="button" data-modal-hide="modal-gia-han-{{ $item->id }}" class="flex-1 rounded-xl bg-ui-bg py-3 text-sm font-bold text-ink-primary ring-1 ring-ui-border transition-colors hover:bg-white">Hủy bỏ</button>
                        <button type="submit" class="flex-[2] rounded-xl bg-ink-primary py-3 text-sm font-bold text-white shadow-lg shadow-ink-primary/20 transition-all hover:bg-brand-emerald">Xác nhận gia hạn</button>
                    </div>
                </form>
            </x-modal>
        @endforeach
    @endpush
</x-admin-layout>
