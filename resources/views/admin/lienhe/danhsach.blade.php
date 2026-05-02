<x-admin-layout>
    <x-slot:title>Phản hồi & Kiến nghị sinh viên</x-slot:title>

    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold text-ink-primary font-display uppercase tracking-tight">Hộp thư góp ý</h1>
            <p class="text-xs font-medium text-ink-secondary/60">Tiếp nhận và xử lý các ý kiến từ cộng đồng.</p>
        </div>

        <div class="flex flex-col gap-2 sm:flex-row sm:items-center">
            <nav class="flex items-center gap-1 rounded-xl bg-ui-bg p-1 ring-1 ring-ui-border shadow-sm">
                @foreach (['Tất cả', 'Chờ xử lý', 'Đã xử lý'] as $loai)
                    @php
                        $isActive = (isset($status) && $status === $loai) || (!isset($status) && $loai === 'Tất cả');
                    @endphp
                    <a href="{{ route('admin.quanlylienhe', ['status' => $loai]) }}"
                       class="rounded-lg px-5 py-2 text-[10px] font-bold uppercase tracking-widest transition-all {{ $isActive ? 'bg-white text-ink-primary shadow-sm ring-1 ring-ui-border' : 'text-ink-secondary hover:text-ink-primary' }}">
                        {{ $loai }}
                    </a>
                @endforeach
            </nav>
        </div>
    </div>

    <article class="overflow-hidden rounded-2xl bg-white border border-ui-border shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-ink-primary">
                <thead class="bg-ui-bg/50 border-b border-ui-border text-[10px] font-bold uppercase tracking-widest text-ink-secondary">
                    <tr>
                        <th class="px-6 py-4 font-bold">Người gửi</th>
                        <th class="px-6 py-4 font-bold">Thông tin liên hệ</th>
                        <th class="px-6 py-4 font-bold">Nội dung phản hồi</th>
                        <th class="px-6 py-4 font-bold">Thời gian</th>
                        <th class="px-6 py-4 font-bold text-center">Trạng thái</th>
                        <th class="px-6 py-4 font-bold text-right">Điều phối</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-ui-border">
                    @forelse ($danhsachlienhe as $lienhe)
                        <tr class="group transition-colors hover:bg-ui-bg/50">
                            <td class="px-6 py-5">
                                <div class="font-bold text-ink-primary font-display text-base">{{ $lienhe->ho_ten }}</div>
                                <div class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary mt-0.5">Sinh viên KTX</div>
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex flex-col gap-1">
                                    <div class="flex items-center gap-2 text-xs font-bold text-ink-primary">
                                        <svg class="h-3 w-3 text-ink-secondary/40" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                        {{ $lienhe->email }}
                                    </div>
                                    <div class="flex items-center gap-2 text-xs font-bold text-ink-secondary">
                                        <svg class="h-3 w-3 text-ink-secondary/40" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                        {{ $lienhe->so_dien_thoai }}
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5 max-w-sm">
                                <div class="text-sm font-medium leading-relaxed text-ink-secondary line-clamp-2 italic">
                                    "{{ $lienhe->noi_dung }}"
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <div class="text-sm font-bold text-ink-primary tabular-nums">{{ $lienhe->created_at->format('d/m/Y') }}</div>
                                <div class="text-[10px] font-bold text-ink-secondary/40 tabular-nums">{{ $lienhe->created_at->format('H:i') }}</div>
                            </td>
                            <td class="px-6 py-5 text-center">
                                @php
                                    $isProcessed = $lienhe->trang_thai === 'Đã xử lý';
                                    $badgeClass = $isProcessed ? 'bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-600/20' : 'bg-amber-50 text-amber-700 ring-1 ring-inset ring-amber-600/20';
                                @endphp
                                <span class="inline-flex items-center rounded-md px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider {{ $badgeClass }}">
                                    {{ $lienhe->trang_thai }}
                                </span>
                            </td>
                            <td class="px-6 py-5 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    @if (!$isProcessed)
                                        <form method="POST" action="{{ route('admin.capnhattrangthailienhe', ['id' => $lienhe->id]) }}" x-data="{ showConfirm: false }" @confirmed="$el.submit()">
                                            @csrf
                                            <input type="hidden" name="trang_thai" value="Đã xử lý">
                                            <button type="button" @click="$dispatch('open-confirm', { message: 'Xác nhận phản hồi này đã được giải quyết?', action: () => showConfirm = true })" class="flex h-8 items-center justify-center rounded-lg border border-ui-border bg-white px-3 text-[10px] font-bold uppercase tracking-widest text-ink-primary shadow-sm transition-colors hover:bg-ui-bg">Xác nhận xong</button>
                                        </form>
                                    @else
                                        <div class="h-8 flex items-center px-3 text-[10px] font-bold uppercase tracking-widest text-ink-secondary/40 italic">Đã lưu trữ</div>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-24 text-center">
                                <div class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-ui-bg text-ink-secondary/50 mb-3">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                                </div>
                                <div class="text-sm font-bold text-ink-primary">Hộp thư trống</div>
                                <div class="text-[11px] text-ink-secondary mt-1">Chưa có ý kiến đóng góp nào được ghi nhận trong thời gian này.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(method_exists($danhsachlienhe, 'links'))
            <div class="border-t border-ui-border px-6 py-4 bg-ui-bg/30">
                {{ $danhsachlienhe->appends(request()->query())->links() }}
            </div>
        @endif
    </article>
</x-admin-layout>

