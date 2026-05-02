<x-admin-layout>
    <x-slot:title>Giám sát kỷ luật nội trú</x-slot:title>

    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold text-ink-primary font-display uppercase tracking-tight">Vi phạm kỷ luật</h1>
            <p class="text-xs font-medium text-ink-secondary/60">Theo dõi và quản lý các hành vi vi phạm nội quy.</p>
        </div>

        <div class="flex flex-col gap-2 sm:flex-row sm:items-center">
            <button type="button" data-modal-target="modal-themkyluat" data-modal-toggle="modal-themkyluat" class="rounded-xl bg-ink-primary px-4 py-2 text-[10px] font-bold text-white shadow-sm transition-all hover:bg-ink-primary/90 active:scale-[0.98]">
                Ghi nhận vi phạm
            </button>
        </div>
    </div>

    <form method="GET" action="{{ route('admin.quanlykyluat') }}" class="mb-8 rounded-3xl bg-white p-6 border border-ui-border shadow-sm">
        <div class="grid gap-6 md:grid-cols-3">
            <div>
                <label class="block text-[10px] font-bold text-ink-secondary uppercase tracking-widest mb-1.5 ml-1">Lọc theo sinh viên</label>
                <select name="sinhvien_id" class="linear-select w-full font-bold" onchange="this.form.submit()">
                    <option value="">Tất cả đối tượng</option>
                    @foreach($sinhviens as $s)
                        <option value="{{ $s->id }}" {{ $selectedSinhvien == $s->id ? 'selected' : '' }}>
                            {{ $s->masinhvien }} - {{ $s->taikhoan->name ?? 'N/A' }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-[10px] font-bold text-ink-secondary uppercase tracking-widest mb-1.5 ml-1">Mức độ nghiêm trọng</label>
                <select name="mucdo" class="linear-select w-full font-bold" onchange="this.form.submit()">
                    <option value="">Tất cả mức độ</option>
                    @foreach(\App\Enums\DisciplineLevel::cases() as $m)
                        <option value="{{ $m->value }}" {{ $selectedMucDo == $m->value ? 'selected' : '' }}>{{ $m->label() }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full rounded-xl bg-ui-bg py-2.5 text-sm font-bold text-ink-primary ring-1 ring-ui-border transition-colors hover:bg-white">
                    Áp dụng bộ lọc
                </button>
            </div>
        </div>
    </form>

    <article class="overflow-hidden rounded-2xl bg-white border border-ui-border shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-ink-primary">
                <thead class="bg-ui-bg/50 border-b border-ui-border text-[10px] font-bold uppercase tracking-widest text-ink-secondary">
                    <tr>
                        <th class="px-6 py-4 font-bold">Mã định danh</th>
                        <th class="px-6 py-4 font-bold">Sinh viên vi phạm</th>
                        <th class="px-6 py-4 font-bold">Nội dung sự việc</th>
                        <th class="px-6 py-4 font-bold">Ngày ghi nhận</th>
                        <th class="px-6 py-4 font-bold text-center">Mức độ</th>
                        <th class="px-6 py-4 font-bold text-right">Điều phối</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-ui-border">
                    @forelse($kyluat as $item)
                        <tr class="group transition-colors hover:bg-ui-bg/50">
                            <td class="px-6 py-5">
                                <span class="font-mono font-bold text-ink-secondary/60 tabular-nums">{{ $item->sinhvien->masinhvien ?? 'N/A' }}</span>
                            </td>
                            <td class="px-6 py-5">
                                <div class="font-bold text-ink-primary font-display text-base">{{ $item->sinhvien->taikhoan->name ?? 'N/A' }}</div>
                                <div class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary mt-0.5">Phòng: {{ $item->sinhvien->phong->tenphong ?? 'Chưa xếp' }}</div>
                            </td>
                            <td class="px-6 py-5 max-w-xs">
                                <div class="text-sm font-medium leading-relaxed text-ink-secondary line-clamp-2 italic">"{{ $item->noidung }}"</div>
                            </td>
                            <td class="px-6 py-5">
                                <div class="text-sm font-bold text-ink-primary tabular-nums">{{ date('d/m/Y', strtotime($item->ngayvipham)) }}</div>
                            </td>
                            <td class="px-6 py-5 text-center">
                                @php
                                    $colorClass = match($item->mucdo) {
                                        \App\Enums\DisciplineLevel::Low->value => 'bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-600/20',
                                        \App\Enums\DisciplineLevel::Medium->value => 'bg-amber-50 text-amber-700 ring-1 ring-inset ring-amber-600/20',
                                        \App\Enums\DisciplineLevel::High->value => 'bg-rose-50 text-rose-700 ring-1 ring-inset ring-rose-700/10',
                                        default => 'bg-ui-bg text-ink-secondary ring-1 ring-inset ring-ui-border',
                                    };
                                @endphp
                                <span class="inline-flex items-center rounded-md px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider {{ $colorClass }}">
                                    {{ $item->mucdo->label() }}
                                </span>
                            </td>
                            <td class="px-6 py-5 text-right">
                                <button type="button" 
                                        data-modal-target="modal-suakyluat-{{ $item->id }}" 
                                        data-modal-toggle="modal-suakyluat-{{ $item->id }}" 
                                        class="flex h-8 w-8 ml-auto items-center justify-center rounded-lg border border-ui-border bg-white text-ink-secondary shadow-sm transition-colors hover:bg-ui-bg hover:text-ink-primary" title="Chi tiết vi phạm">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-24 text-center">
                                <div class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-ui-bg text-ink-secondary/50 mb-3">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                </div>
                                <div class="text-sm font-bold text-ink-primary">Không có bản ghi kỷ luật</div>
                                <div class="text-[11px] text-ink-secondary mt-1">Hệ thống chưa ghi nhận hành vi vi phạm nào phù hợp với bộ lọc.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(method_exists($kyluat, 'links'))
            <div class="border-t border-ui-border px-6 py-4 bg-ui-bg/30">
                {{ $kyluat->appends(request()->query())->links() }}
            </div>
        @endif
    </article>

    @push('modals')
        <x-modal id="modal-themkyluat" title="Ghi nhận vi phạm" subtitle="Kê khai thông tin vi phạm mới cho sinh viên nội trú.">
            <form method="POST" action="{{ route('admin.themkyluat') }}" class="space-y-6">
                @csrf
                <div>
                    <label class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary/50">Sinh viên vi phạm</label>
                    <select name="sinhvien_id" required class="linear-select mt-1.5 font-bold">
                        <option value="">-- Chọn sinh viên --</option>
                        @foreach($sinhviens as $s)
                            <option value="{{ $s->id }}">{{ $s->masinhvien }} - {{ $s->taikhoan->name ?? 'N/A' }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary/50">Nội dung sự việc</label>
                    <textarea name="noidung" required rows="3" class="linear-textarea mt-1.5" placeholder="Mô tả chi tiết hành vi vi phạm..."></textarea>
                </div>

                <div class="grid grid-cols-2 gap-5">
                    <div>
                        <label class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary/50">Ngày xảy ra</label>
                        <input name="ngayvipham" required type="date" value="{{ date('Y-m-d') }}" class="linear-input mt-1.5 font-bold tabular-nums" />
                    </div>
                    <div>
                        <label class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary/50">Mức độ xử lý</label>
                        <select name="mucdo" required class="linear-select mt-1.5 font-bold">
                            <option value="{{ \App\Enums\DisciplineLevel::Low->value }}">{{ \App\Enums\DisciplineLevel::Low->label() }}</option>
                            <option value="{{ \App\Enums\DisciplineLevel::Medium->value }}" selected>{{ \App\Enums\DisciplineLevel::Medium->label() }}</option>
                            <option value="{{ \App\Enums\DisciplineLevel::High->value }}">{{ \App\Enums\DisciplineLevel::High->label() }}</option>
                        </select>
                    </div>
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="button" data-modal-hide="modal-themkyluat" class="flex-1 rounded-xl bg-ui-bg py-3 text-sm font-bold text-ink-primary ring-1 ring-ui-border transition-colors hover:bg-white">Hủy bỏ</button>
                    <button type="submit" class="flex-[2] rounded-xl bg-ink-primary py-3 text-sm font-bold text-white shadow-lg shadow-ink-primary/20 transition-all hover:bg-brand-emerald">Ghi nhận vi phạm</button>
                </div>
            </form>
        </x-modal>

        @foreach($kyluat as $item)
            <x-modal id="modal-suakyluat-{{ $item->id }}" title="Hiệu chỉnh bản ghi" subtitle="Cập nhật thông tin hoặc mức độ vi phạm cho sinh viên {{ $item->sinhvien->taikhoan->name ?? 'N/A' }}.">
                <form method="POST" action="{{ route('admin.capnhatkyluat', ['id' => $item->id]) }}" class="space-y-6">
                    @csrf
                    <div class="rounded-2xl bg-ui-bg/50 p-4 flex items-center gap-4 ring-1 ring-inset ring-ui-border">
                        <div class="w-12 h-12 rounded-xl bg-white flex items-center justify-center text-xl shadow-sm border border-ui-border">👤</div>
                        <div>
                            <div class="font-bold text-ink-primary font-display text-base">{{ $item->sinhvien->taikhoan->name ?? 'N/A' }}</div>
                            <div class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary">{{ $item->sinhvien->masinhvien ?? 'N/A' }}</div>
                        </div>
                    </div>

                    <div>
                        <label class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary/50">Nội dung vi phạm</label>
                        <textarea name="noidung" required rows="3" class="linear-textarea mt-1.5">{{ $item->noidung }}</textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-5">
                        <div>
                            <label class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary/50">Ngày ghi nhận</label>
                            <input class="linear-input mt-1.5 font-bold tabular-nums" type="date" name="ngayvipham" value="{{ $item->ngayvipham }}" required />
                        </div>
                        <div>
                            <label class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary/50">Mức độ xử lý</label>
                            <select name="mucdo" required class="linear-select mt-1.5 font-bold">
                                @foreach(\App\Enums\DisciplineLevel::cases() as $m)
                                    <option value="{{ $m->value }}" {{ $item->mucdo == $m->value ? 'selected' : '' }}>{{ $m->label() }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="flex gap-3 pt-4">
                        <button type="button" data-modal-hide="modal-suakyluat-{{ $item->id }}" class="flex-1 rounded-xl bg-ui-bg py-3 text-sm font-bold text-ink-primary ring-1 ring-ui-border transition-colors hover:bg-white">Hủy bỏ</button>
                        <button type="submit" class="flex-[2] rounded-xl bg-ink-primary py-3 text-sm font-bold text-white shadow-lg shadow-ink-primary/20 transition-all hover:bg-brand-emerald">Cập nhật bản ghi</button>
                    </div>
                </form>
            </x-modal>
        @endforeach
    @endpush
</x-admin-layout>

