<x-admin-layout>
    <x-slot:title>Phát hành thông tin nội khu</x-slot:title>

    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold text-ink-primary font-display uppercase tracking-tight">Bảng tin KTX</h1>
            <p class="text-xs font-medium text-ink-secondary/60">Phát hành và quản lý các thông điệp quan trọng.</p>
        </div>

        <div class="flex flex-col gap-2 sm:flex-row sm:items-center">
            <button type="button" data-modal-target="modal-themthongbao" data-modal-toggle="modal-themthongbao" class="rounded-xl bg-ink-primary px-4 py-2 text-[10px] font-bold text-white shadow-sm transition-all hover:bg-ink-primary/90 active:scale-[0.98]">
                Tạo bài đăng mới
            </button>
        </div>
    </div>

    <article class="overflow-hidden rounded-2xl bg-white border border-ui-border shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-ink-primary">
                <thead class="bg-ui-bg/50 border-b border-ui-border text-[10px] font-bold uppercase tracking-widest text-ink-secondary">
                    <tr>
                        <th class="px-6 py-4 font-bold">Chủ đề & Tiêu đề</th>
                        <th class="px-6 py-4 font-bold">Nội dung tóm lược</th>
                        <th class="px-6 py-4 font-bold">Thời điểm đăng</th>
                        <th class="px-6 py-4 font-bold text-right">Điều phối</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-ui-border">
                    @forelse($thongbao as $item)
                        <tr class="group transition-colors hover:bg-ui-bg/50">
                            <td class="px-6 py-5 max-w-xs">
                                <div class="font-bold text-ink-primary font-display text-base leading-tight">{{ $item->tieude }}</div>
                                <div class="flex items-center gap-1.5 mt-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    <span class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary/40">Công khai</span>
                                </div>
                            </td>
                            <td class="px-6 py-5 max-w-md">
                                <div class="text-sm font-medium leading-relaxed text-ink-secondary line-clamp-2 italic">
                                    "{{ $item->noidung }}"
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <div class="text-sm font-bold text-ink-primary tabular-nums">{{ date('d/m/Y', strtotime($item->ngaydang)) }}</div>
                            </td>
                            <td class="px-6 py-5 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button type="button" data-modal-target="modal-suathongbao-{{ $item->id }}" data-modal-toggle="modal-suathongbao-{{ $item->id }}" class="flex h-8 w-8 items-center justify-center rounded-lg border border-ui-border bg-white text-ink-secondary shadow-sm transition-colors hover:bg-ui-bg hover:text-ink-primary" title="Chỉnh sửa nội dung">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                    </button>
                                    
                                    <form method="POST" action="{{ route('admin.xoathongbao', ['id' => $item->id]) }}" x-data="{ showConfirm: false }" @confirmed="$el.submit()">
                                        @csrf
                                        <button type="button" @click="$dispatch('open-confirm', { message: 'Xác nhận gỡ bỏ thông báo này khỏi hệ thống?', action: () => showConfirm = true })" class="flex h-8 w-8 items-center justify-center rounded-lg border border-rose-100 bg-rose-50 text-rose-600 shadow-sm transition-colors hover:bg-rose-600 hover:text-white" title="Gỡ bài">
                                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-24 text-center">
                                <div class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-ui-bg text-ink-secondary/50 mb-3">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1M19 20a2 2 0 002-2V8a2 2 0 00-2-2h-5M19 20l-4-4m1.5-4.5L19 7m-5 8l3 3"/></svg>
                                </div>
                                <div class="text-sm font-bold text-ink-primary">Bảng tin đang trống</div>
                                <div class="text-[11px] text-ink-secondary mt-1">Hệ thống chưa ghi nhận bất kỳ thông báo nào được phát hành.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(method_exists($thongbao, 'links'))
            <div class="border-t border-ui-border px-6 py-4 bg-ui-bg/30">
                {{ $thongbao->appends(request()->query())->links() }}
            </div>
        @endif
    </article>

    @push('modals')
        <x-modal id="modal-themthongbao" title="Soạn thảo thông báo" subtitle="Tạo nội dung mới để phát hành tới toàn thể sinh viên nội trú.">
            <form method="POST" action="{{ route('admin.themthongbao') }}" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-12 gap-5">
                    <div class="md:col-span-8">
                        <label class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary/50">Tiêu đề bài đăng</label>
                        <input name="tieude" type="text" placeholder="Ví dụ: Lịch vệ sinh khu vực chung tháng 05..." value="{{ old('tieude') }}" class="linear-input mt-1.5 font-bold" required>
                    </div>
                    <div class="md:col-span-4">
                        <label class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary/50">Ngày phát hành</label>
                        <input name="ngaydang" type="date" value="{{ old('ngaydang', now()->format('Y-m-d')) }}" class="linear-input mt-1.5 font-bold tabular-nums" required>
                    </div>
                </div>
                <div>
                    <label class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary/50">Nội dung chi tiết</label>
                    <textarea name="noidung" placeholder="Nhập nội dung thông báo đầy đủ tại đây..." rows="6" class="linear-textarea mt-1.5 font-medium leading-relaxed" required>{{ old('noidung') }}</textarea>
                </div>
                
                <div class="flex gap-3 pt-4">
                    <button type="button" data-modal-hide="modal-themthongbao" class="flex-1 rounded-xl bg-ui-bg py-3 text-sm font-bold text-ink-primary ring-1 ring-ui-border transition-colors hover:bg-white">Hủy thảo văn bản</button>
                    <button type="submit" class="flex-[2] rounded-xl bg-ink-primary py-3 text-sm font-bold text-white shadow-lg shadow-ink-primary/20 transition-all hover:bg-brand-emerald">Phát hành ngay</button>
                </div>
            </form>
        </x-modal>

        @foreach($thongbao as $item)
            <x-modal id="modal-suathongbao-{{ $item->id }}" title="Hiệu chỉnh nội dung" subtitle="Cập nhật thông tin bài đăng #{{ $item->id }}.">
                <form method="POST" action="{{ route('admin.capnhatthongbao', ['id' => $item->id]) }}" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-5">
                        <div class="md:col-span-8">
                            <label class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary/50">Tiêu đề bài đăng</label>
                            <input name="tieude" type="text" value="{{ $item->tieude }}" class="linear-input mt-1.5 font-bold" required>
                        </div>
                        <div class="md:col-span-4">
                            <label class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary/50">Ngày phát hành</label>
                            <input name="ngaydang" type="date" value="{{ $item->ngaydang }}" class="linear-input mt-1.5 font-bold tabular-nums" required>
                        </div>
                    </div>
                    
                    <div>
                        <label class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary/50">Nội dung chi tiết</label>
                        <textarea name="noidung" rows="8" class="linear-textarea mt-1.5 font-medium leading-relaxed" required>{{ $item->noidung }}</textarea>
                    </div>
                    
                    <div class="flex gap-3 pt-4">
                        <button type="button" data-modal-hide="modal-suathongbao-{{ $item->id }}" class="flex-1 rounded-xl bg-ui-bg py-3 text-sm font-bold text-ink-primary ring-1 ring-ui-border transition-colors hover:bg-white">Hủy bỏ</button>
                        <button type="submit" class="flex-[2] rounded-xl bg-ink-primary py-3 text-sm font-bold text-white shadow-lg shadow-ink-primary/20 transition-all hover:bg-brand-emerald">Lưu thay đổi</button>
                    </div>
                </form>
            </x-modal>
        @endforeach
    @endpush
</x-admin-layout>

