<x-admin-layout>
    <x-slot:title>Quản lý báo hỏng & sửa chữa</x-slot:title>

    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold text-ink-primary font-display uppercase tracking-tight">Hệ thống báo hỏng</h1>
            <p class="text-xs font-medium text-ink-secondary/60">Giám sát và điều phối công tác bảo trì.</p>
        </div>

        <div class="flex flex-col gap-2 sm:flex-row sm:items-center">
            <nav class="flex items-center gap-1 rounded-xl bg-ui-bg p-1 ring-1 ring-ui-border shadow-sm">
                @foreach (['Tất cả', 'Chờ sửa', 'Da hen', 'Dang sua', 'Đã xong'] as $loai)
                    @php
                        $isActive = (isset($status) && $status === $loai) || (!isset($status) && $loai === 'Tất cả');
                    @endphp
                    <a href="{{ route('admin.quanlybaohong', ['status' => $loai]) }}"
                       class="rounded-lg px-4 py-2 text-[9px] font-bold uppercase tracking-widest transition-all {{ $isActive ? 'bg-white text-ink-primary shadow-sm ring-1 ring-ui-border' : 'text-ink-secondary hover:text-ink-primary' }}">
                        {{ $loai === 'Da hen' ? 'Đã hẹn' : ($loai === 'Dang sua' ? 'Đang sửa' : $loai) }}
                    </a>
                @endforeach
            </nav>
        </div>
    </div>

    @php
        $mapsinhvien = $danhsachsinhvien->keyBy('id');
        $mapphong = $danhsachphong->keyBy('id');
    @endphp

    <article class="overflow-hidden rounded-2xl bg-white border border-ui-border shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-ink-primary">
                <thead class="bg-ui-bg/50 border-b border-ui-border text-[10px] font-bold uppercase tracking-widest text-ink-secondary">
                    <tr>
                        <th class="px-6 py-4 font-bold">Sinh viên báo cáo</th>
                        <th class="px-6 py-4 font-bold">Vị trí (Phòng)</th>
                        <th class="px-6 py-4 font-bold">Nội dung sự cố</th>
                        <th class="px-6 py-4 font-bold">Tư liệu</th>
                        <th class="px-6 py-4 font-bold text-center">Trạng thái</th>
                        <th class="px-6 py-4 font-bold text-right">Điều phối</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-ui-border">
                    @forelse ($danhsachbaohong as $baohong)
                        <tr class="group transition-colors hover:bg-ui-bg/50">
                            <td class="px-6 py-5">
                                <div class="font-bold text-ink-primary font-display text-base">{{ $mapsinhvien[$baohong->sinhvien_id]->ho_ten ?? 'N/A' }}</div>
                                <div class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary mt-0.5">{{ $mapsinhvien[$baohong->sinhvien_id]->masinhvien ?? 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-2 font-bold text-ink-primary">
                                    <div class="h-8 w-8 flex items-center justify-center rounded-lg bg-ui-bg text-ink-secondary/60 ring-1 ring-ui-border">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                    </div>
                                    {{ $mapphong[$baohong->phong_id]->tenphong ?? 'N/A' }}
                                </div>
                            </td>
                            <td class="px-6 py-5 max-w-sm">
                                <div class="text-sm font-medium leading-relaxed text-ink-secondary line-clamp-2 italic">
                                    "{{ $baohong->mota }}"
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                @if ($baohong->anhminhhoa)
                                    <a href="{{ asset($baohong->anhminhhoa) }}" target="_blank" class="inline-flex items-center gap-2 rounded-xl border border-ui-border bg-ui-bg px-3 py-1.5 text-[10px] font-bold uppercase tracking-widest text-ink-secondary shadow-sm transition-colors hover:bg-white hover:text-ink-primary">
                                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        Tư liệu
                                    </a>
                                @else
                                    <span class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary/30">Không có</span>
                                @endif
                            </td>
                            <td class="px-6 py-5 text-center">
                                @php
                                    $badgeType = match ($baohong->trangthai) {
                                        'Đã xong' => 'success',
                                        'Da hen' => 'warning',
                                        'Dang sua' => 'info',
                                        default => 'warning',
                                    };
                                    
                                    $badgeClass = match ($badgeType) {
                                        'success' => 'bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-600/20',
                                        'warning' => 'bg-amber-50 text-amber-700 ring-1 ring-inset ring-amber-600/20',
                                        'info' => 'bg-blue-50 text-blue-700 ring-1 ring-inset ring-blue-700/10',
                                        default => 'bg-ui-bg text-ink-secondary ring-1 ring-inset ring-ui-border'
                                    };
                                @endphp
                                <span class="inline-flex items-center rounded-md px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider {{ $badgeClass }}">
                                    {{ $baohong->trangthai }}
                                </span>
                            </td>
                            <td class="px-6 py-5 text-right">
                                <form method="POST" action="{{ route('admin.capnhatbaohong', ['id' => $baohong->id]) }}" class="inline-flex items-center gap-2 rounded-xl bg-ui-bg p-1 border border-ui-border">
                                    @csrf
                                    <select name="trangthai" class="h-8 rounded-lg border-none bg-transparent py-0 pl-3 pr-8 text-[11px] font-bold uppercase tracking-wider text-ink-primary focus:ring-0">
                                        <option value="Chờ sửa" {{ $baohong->trangthai === 'Chờ sửa' ? 'selected' : '' }}>Chờ</option>
                                        <option value="Da hen" {{ $baohong->trangthai === 'Da hen' ? 'selected' : '' }}>Hẹn</option>
                                        <option value="Dang sua" {{ $baohong->trangthai === 'Dang sua' ? 'selected' : '' }}>Sửa</option>
                                        <option value="Đã xong" {{ $baohong->trangthai === 'Đã xong' ? 'selected' : '' }}>Xong</option>
                                    </select>
                                    <button type="submit" class="flex h-8 w-8 items-center justify-center rounded-lg bg-white text-brand-emerald shadow-sm border border-ui-border transition-colors hover:bg-brand-emerald hover:text-white" title="Cập nhật trạng thái">
                                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-24 text-center">
                                <div class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-ui-bg text-ink-secondary/50 mb-3">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                </div>
                                <div class="text-sm font-bold text-ink-primary">Hiện trạng vận hành ổn định</div>
                                <div class="text-[11px] text-ink-secondary mt-1">Không có báo cáo hư hỏng thiết bị nào được ghi nhận trong thời gian này.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(method_exists($danhsachbaohong, 'links'))
            <div class="border-t border-ui-border px-6 py-4 bg-ui-bg/30">
                {{ $danhsachbaohong->appends(request()->query())->links() }}
            </div>
        @endif
    </article>
</x-admin-layout>
