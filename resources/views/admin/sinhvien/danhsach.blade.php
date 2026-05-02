<x-admin-layout>
    <x-slot:title>Hồ sơ sinh viên nội trú</x-slot:title>

    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold text-ink-primary font-display uppercase tracking-tight">Cơ sở dữ liệu sinh viên</h1>
            <p class="text-xs font-medium text-ink-secondary/60">Quản lý hồ sơ nhân khẩu và lịch sử lưu trú cư dân.</p>
        </div>

        <div class="flex flex-col gap-2 sm:flex-row sm:items-center">
            <form action="{{ route('admin.quanlysinhvien') }}" method="GET" class="flex items-center gap-2">
                <div class="relative group">
                    <div class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-ink-secondary/40 group-focus-within:text-ink-primary transition-colors">
                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Mã số hoặc họ tên..." class="w-full sm:w-56 rounded-xl border border-ui-border bg-white py-2 pl-9 pr-4 text-xs font-medium text-ink-primary placeholder:text-ink-secondary/30 focus:border-ink-primary/30 focus:outline-none focus:ring-4 focus:ring-ink-primary/5 transition-all" />
                </div>
                <button type="submit" class="rounded-xl bg-ink-primary px-4 py-2 text-[10px] font-bold text-white shadow-sm transition-all hover:bg-ink-primary/90 active:scale-[0.98]">
                    Truy vấn
                </button>
            </form>
        </div>
    </div>

    <article class="overflow-hidden rounded-2xl bg-white border border-ui-border shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-ink-primary">
                <thead class="bg-ui-bg/50 border-b border-ui-border text-[10px] font-bold uppercase tracking-widest text-ink-secondary">
                    <tr>
                        <th class="px-6 py-4 font-bold">Danh tính cư dân</th>
                        <th class="px-6 py-4 font-bold">Mã số & Lớp</th>
                        <th class="px-6 py-4 font-bold">Vị trí hiện tại</th>
                        <th class="px-6 py-4 font-bold">Liên lạc</th>
                        <th class="px-6 py-4 font-bold">Ngày tham gia</th>
                        <th class="px-6 py-4 font-bold text-right">Điều phối</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-ui-border">
                    @forelse($danhsachsinhvien as $sinhvien)
                        <tr class="group transition-colors hover:bg-ui-bg/50">
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-4">
                                    <div class="h-10 w-10 flex-shrink-0 overflow-hidden rounded-xl bg-ui-bg ring-1 ring-ui-border">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($sinhvien->taikhoan->name ?? 'N/A') }}&background=f8f9fa&color=0f172a&bold=true" alt="Avatar" />
                                    </div>
                                    <div class="font-bold text-ink-primary font-display text-base">{{ $sinhvien->taikhoan->name ?? 'N/A' }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <div class="text-sm font-bold text-ink-primary tabular-nums">{{ $sinhvien->masinhvien }}</div>
                                <div class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary mt-0.5">{{ $sinhvien->lop }}</div>
                            </td>
                            <td class="px-6 py-5">
                                @if($sinhvien->phong)
                                    <div class="flex items-center gap-2 font-bold text-ink-primary">
                                        <div class="h-7 w-7 flex items-center justify-center rounded-lg bg-ui-bg text-ink-secondary/60 ring-1 ring-ui-border">
                                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                        </div>
                                        {{ $sinhvien->phong->tenphong }}
                                    </div>
                                @else
                                    <span class="inline-flex items-center rounded-md px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider bg-ui-bg text-ink-secondary/40 ring-1 ring-inset ring-ui-border">Chưa xếp phòng</span>
                                @endif
                            </td>
                            <td class="px-6 py-5">
                                <div class="text-xs font-bold text-ink-primary tabular-nums">{{ $sinhvien->sodienthoai }}</div>
                                <div class="text-[10px] font-medium text-ink-secondary/40 mt-0.5">{{ $sinhvien->taikhoan->email ?? 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-5">
                                <div class="text-sm font-bold text-ink-primary tabular-nums">{{ $sinhvien->created_at->format('d/m/Y') }}</div>
                            </td>
                            <td class="px-6 py-5 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button type="button" data-modal-target="modal-chitiet-{{ $sinhvien->id }}" data-modal-toggle="modal-chitiet-{{ $sinhvien->id }}" class="flex h-8 w-8 items-center justify-center rounded-lg border border-ui-border bg-white text-ink-secondary shadow-sm transition-colors hover:bg-ui-bg hover:text-ink-primary" title="Hồ sơ chi tiết">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-24 text-center">
                                <div class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-ui-bg text-ink-secondary/50 mb-3">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                                </div>
                                <div class="text-sm font-bold text-ink-primary">Không có dữ liệu sinh viên</div>
                                <div class="text-[11px] text-ink-secondary mt-1">Chưa có sinh viên nào hoặc không tìm thấy kết quả phù hợp.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(method_exists($danhsachsinhvien, 'links'))
            <div class="border-t border-ui-border px-6 py-4 bg-ui-bg/30">
                {{ $danhsachsinhvien->withQueryString()->links() }}
            </div>
        @endif
    </article>

    @push('modals')
        @foreach($danhsachsinhvien as $sinhvien)
            <x-modal id="modal-chitiet-{{ $sinhvien->id }}" title="Hồ sơ nhân khẩu cư dân" subtitle="Thông tin định danh và lịch sử lưu trú của sinh viên.">
                <div class="space-y-6">
                    <div class="flex items-center gap-5 p-4 rounded-2xl bg-ui-bg/50 ring-1 ring-inset ring-ui-border">
                        <div class="h-20 w-20 flex-shrink-0 overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-ui-border">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($sinhvien->taikhoan->name ?? 'N/A') }}&background=ffffff&color=0f172a&bold=true&size=128" alt="Avatar Large" />
                        </div>
                        <div>
                            <div class="font-bold text-ink-primary font-display text-2xl leading-tight">{{ $sinhvien->taikhoan->name ?? 'N/A' }}</div>
                            <div class="text-xs font-bold text-ink-secondary/60 uppercase tracking-widest mt-1">{{ $sinhvien->masinhvien }} • {{ $sinhvien->lop }}</div>
                        </div>
                    </div>

                    <div class="divide-y divide-ui-border rounded-2xl bg-white p-6 ring-1 ring-inset ring-ui-border">
                        <div class="flex items-center justify-between py-3">
                            <span class="text-xs font-bold text-ink-secondary uppercase tracking-widest">Email học thuật</span>
                            <span class="text-sm font-bold text-ink-primary">{{ $sinhvien->taikhoan->email ?? 'N/A' }}</span>
                        </div>
                        <div class="flex items-center justify-between py-3">
                            <span class="text-xs font-bold text-ink-secondary uppercase tracking-widest">Số điện thoại</span>
                            <span class="text-sm font-bold text-ink-primary tabular-nums">{{ $sinhvien->sodienthoai }}</span>
                        </div>
                        <div class="flex items-center justify-between py-3">
                            <span class="text-xs font-bold text-ink-secondary uppercase tracking-widest">Giới tính</span>
                            <span class="text-sm font-bold text-ink-primary">{{ $sinhvien->gioitinh }}</span>
                        </div>
                        <div class="flex items-center justify-between py-3">
                            <span class="text-xs font-bold text-ink-secondary uppercase tracking-widest">Vị trí phòng</span>
                            <span class="text-sm font-bold text-ink-primary">{{ $sinhvien->phong->tenphong ?? 'Chưa xếp' }}</span>
                        </div>
                    </div>

                    <div class="flex gap-3 pt-2">
                        <button type="button" data-modal-hide="modal-chitiet-{{ $sinhvien->id }}" class="w-full rounded-xl bg-ui-bg py-3 text-sm font-bold text-ink-primary ring-1 ring-ui-border transition-colors hover:bg-white">Đóng hồ sơ</button>
                    </div>
                </div>
            </x-modal>
        @endforeach
    @endpush
</x-admin-layout>

