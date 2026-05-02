<x-admin-layout>
    <x-slot:title>Lịch trình bảo trì định kỳ</x-slot:title>

    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold text-ink-primary font-display uppercase tracking-tight">Kế hoạch bảo trì</h1>
            <p class="text-xs font-medium text-ink-secondary/60">Điều phối hoạt động bảo dưỡng hạ tầng.</p>
        </div>

        <div class="flex flex-col gap-2 sm:flex-row sm:items-center">
            <button type="button" data-modal-target="modal-thembaotri" data-modal-toggle="modal-thembaotri" class="rounded-xl bg-ink-primary px-4 py-2 text-[10px] font-bold text-white shadow-sm transition-all hover:bg-ink-primary/90 active:scale-[0.98]">
                Lập lịch mới
            </button>
        </div>
    </div>

    <article class="overflow-hidden rounded-2xl bg-white border border-ui-border shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-ink-primary">
                <thead class="bg-ui-bg/50 border-b border-ui-border text-[10px] font-bold uppercase tracking-widest text-ink-secondary">
                    <tr>
                        <th class="px-6 py-4 font-bold">Đối tượng (Phòng)</th>
                        <th class="px-6 py-4 font-bold">Nội dung công việc</th>
                        <th class="px-6 py-4 font-bold">Ngày thực hiện</th>
                        <th class="px-6 py-4 font-bold">Kỹ thuật viên</th>
                        <th class="px-6 py-4 font-bold text-center">Trạng thái</th>
                        <th class="px-6 py-4 font-bold text-right">Điều phối</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-ui-border">
                    @forelse ($baotri as $item)
                        <tr class="group transition-colors hover:bg-ui-bg/50">
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-2 font-bold text-ink-primary">
                                    <div class="h-8 w-8 flex items-center justify-center rounded-lg bg-ui-bg text-ink-secondary/60 ring-1 ring-ui-border">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                    </div>
                                    {{ $item->phong->tenphong ?? 'Tất cả' }}
                                </div>
                            </td>
                            <td class="px-6 py-5 max-w-xs">
                                <div class="text-sm font-medium leading-relaxed text-ink-secondary line-clamp-2 italic">"{{ $item->noidung }}"</div>
                            </td>
                            <td class="px-6 py-5">
                                <div class="text-sm font-bold text-ink-primary tabular-nums">{{ date('d/m/Y', strtotime($item->ngaybaotri)) }}</div>
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-2">
                                    <div class="h-6 w-6 rounded-full bg-ui-bg border border-ui-border flex items-center justify-center text-[10px]">🛠️</div>
                                    <span class="text-sm font-bold text-ink-primary">{{ $item->nguoithuchien }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-5 text-center">
                                @php
                                    $badgeClass = $item->trangthai === 'Đã hoàn thành' 
                                        ? 'bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-600/20' 
                                        : 'bg-amber-50 text-amber-700 ring-1 ring-inset ring-amber-600/20';
                                @endphp
                                <span class="inline-flex items-center rounded-md px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider {{ $badgeClass }}">
                                    {{ $item->trangthai }}
                                </span>
                            </td>
                            <td class="px-6 py-5 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button type="button" data-modal-target="modal-suabaotri-{{ $item->id }}" data-modal-toggle="modal-suabaotri-{{ $item->id }}" class="flex h-8 w-8 items-center justify-center rounded-lg border border-ui-border bg-white text-ink-secondary shadow-sm transition-colors hover:bg-ui-bg hover:text-ink-primary" title="Chỉnh sửa lịch">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                    </button>

                                    @if ($item->trangthai !== 'Đã hoàn thành')
                                        <form method="POST" action="{{ route('admin.hoanthanhbaotri', $item->id) }}" x-data="{ showConfirm: false }" @confirmed="$el.submit()">
                                            @csrf
                                            <button type="button" @click="$dispatch('open-confirm', { message: 'Xác nhận công tác bảo trì này đã hoàn tất?', action: () => showConfirm = true })" class="flex h-8 items-center justify-center rounded-lg border border-brand-emerald/20 bg-emerald-50 px-3 text-[10px] font-bold uppercase tracking-widest text-emerald-600 shadow-sm transition-colors hover:bg-emerald-600 hover:text-white">Hoàn tất</button>
                                        </form>
                                    @endif

                                    <form method="POST" action="{{ route('admin.xoabaotri', $item->id) }}" x-data="{ showConfirm: false }" @confirmed="$el.submit()">
                                        @csrf
                                        <button type="button" @click="$dispatch('open-confirm', { message: 'Bạn có chắc chắn muốn hủy lịch bảo trì này?', action: () => showConfirm = true })" class="flex h-8 w-8 items-center justify-center rounded-lg border border-rose-100 bg-rose-50 text-rose-600 shadow-sm transition-colors hover:bg-rose-600 hover:text-white" title="Hủy lịch">
                                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-24 text-center">
                                <div class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-ui-bg text-ink-secondary/50 mb-3">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                                <div class="text-sm font-bold text-ink-primary">Trống lịch trình bảo trì</div>
                                <div class="text-[11px] text-ink-secondary mt-1">Chưa có kế hoạch bảo trì nào được thiết lập trong thời gian tới.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(method_exists($baotri, 'links'))
            <div class="border-t border-ui-border px-6 py-4 bg-ui-bg/30">
                {{ $baotri->appends(request()->query())->links() }}
            </div>
        @endif
    </article>

    @push('modals')
        <x-modal id="modal-thembaotri" title="Thiết lập lịch trình" subtitle="Lên kế hoạch bảo trì mới cho hạ tầng hoặc thiết bị.">
            <form method="POST" action="{{ route('admin.thembaotri') }}" class="space-y-6">
                @csrf
                <div>
                    <label class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary/50">Phòng chỉ định (Tùy chọn)</label>
                    <select name="phong_id" class="linear-select mt-1.5 font-bold">
                        <option value="">-- Tất cả các phòng --</option>
                        @foreach ($phongs as $phong)
                            <option value="{{ $phong->id }}">{{ $phong->tenphong }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary/50">Nội dung bảo trì</label>
                    <textarea name="noidung" required rows="3" class="linear-textarea mt-1.5" placeholder="Mô tả công việc cần thực hiện..."></textarea>
                </div>

                <div class="grid grid-cols-2 gap-5">
                    <div>
                        <label class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary/50">Ngày thực hiện</label>
                        <input name="ngaybaotri" required type="date" value="{{ date('Y-m-d') }}" class="linear-input mt-1.5 font-bold tabular-nums" />
                    </div>
                    <div>
                        <label class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary/50">Kỹ thuật viên phụ trách</label>
                        <input name="nguoithuchien" required type="text" class="linear-input mt-1.5 font-bold" placeholder="Tên nhân viên..." />
                    </div>
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="button" data-modal-hide="modal-thembaotri" class="flex-1 rounded-xl bg-ui-bg py-3 text-sm font-bold text-ink-primary ring-1 ring-ui-border transition-colors hover:bg-white">Hủy bỏ</button>
                    <button type="submit" class="flex-[2] rounded-xl bg-ink-primary py-3 text-sm font-bold text-white shadow-lg shadow-ink-primary/20 transition-all hover:bg-brand-emerald">Xác nhận lịch trình</button>
                </div>
            </form>
        </x-modal>

        @foreach ($baotri as $item)
            <x-modal id="modal-suabaotri-{{ $item->id }}" title="Hiệu chỉnh lịch trình" subtitle="Cập nhật thông tin kế hoạch bảo trì #{{ $item->id }}.">
                <form method="POST" action="{{ route('admin.suabaotri', $item->id) }}" class="space-y-6">
                    @csrf
                    <div>
                        <label class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary/50">Vị trí thực hiện</label>
                        <select name="phong_id" class="linear-select mt-1.5 font-bold">
                            <option value="">-- Tất cả các phòng --</option>
                            @foreach ($phongs as $phong)
                                <option value="{{ $phong->id }}" {{ $item->phong_id == $phong->id ? 'selected' : '' }}>{{ $phong->tenphong }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary/50">Nội dung công việc</label>
                        <textarea name="noidung" required rows="3" class="linear-textarea mt-1.5">{{ $item->noidung }}</textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-5">
                        <div>
                            <label class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary/50">Ngày bảo trì</label>
                            <input name="ngaybaotri" required type="date" value="{{ $item->ngaybaotri }}" class="linear-input mt-1.5 font-bold tabular-nums" />
                        </div>
                        <div>
                            <label class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary/50">Người thực hiện</label>
                            <input name="nguoithuchien" required type="text" value="{{ $item->nguoithuchien }}" class="linear-input mt-1.5 font-bold" />
                        </div>
                    </div>

                    <div>
                        <label class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary/50">Trạng thái vận hành</label>
                        <select name="trangthai" class="linear-select mt-1.5 font-bold">
                            <option value="Chưa thực hiện" {{ $item->trangthai === 'Chưa thực hiện' ? 'selected' : '' }}>Chưa thực hiện</option>
                            <option value="Đã hoàn thành" {{ $item->trangthai === 'Đã hoàn thành' ? 'selected' : '' }}>Đã hoàn thành</option>
                        </select>
                    </div>

                    <div class="flex gap-3 pt-4">
                        <button type="button" data-modal-hide="modal-suabaotri-{{ $item->id }}" class="flex-1 rounded-xl bg-ui-bg py-3 text-sm font-bold text-ink-primary ring-1 ring-ui-border transition-colors hover:bg-white">Hủy bỏ</button>
                        <button type="submit" class="flex-[2] rounded-xl bg-ink-primary py-3 text-sm font-bold text-white shadow-lg shadow-ink-primary/20 transition-all hover:bg-brand-emerald">Lưu thay đổi</button>
                    </div>
                </form>
            </x-modal>
        @endforeach
    @endpush
</x-admin-layout>
