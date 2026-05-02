<x-admin-layout>
    <x-slot:title>Báo cáo truy thu & Công nợ</x-slot:title>

    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold text-ink-primary font-display uppercase tracking-tight">Sổ nợ hệ thống</h1>
            <p class="text-xs font-medium text-ink-secondary/60">Hóa đơn quá hạn trên {{ $ngayQuaHan }} ngày.</p>
        </div>
    </div>

    <section class="mb-8 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <article class="rounded-2xl border border-ui-border bg-white p-6 shadow-sm ring-1 ring-inset ring-ui-border">
            <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-ink-secondary">Đơn vị nợ</p>
            <p class="mt-2 text-3xl font-black tabular-nums text-ink-primary font-display">{{ $thongke['tong_phong_no'] ?? 0 }} <span class="text-sm font-bold text-ink-secondary/40">PHÒNG</span></p>
        </article>
        <article class="rounded-2xl border border-ui-border bg-white p-6 shadow-sm ring-1 ring-inset ring-ui-border">
            <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-ink-secondary">Sinh viên nợ</p>
            <p class="mt-2 text-3xl font-black tabular-nums text-ink-primary font-display">{{ $thongke['tong_sinh_vien_no'] ?? 0 }} <span class="text-sm font-bold text-ink-secondary/40">NGƯỜI</span></p>
        </article>
        <article class="rounded-2xl border border-ui-border bg-white p-6 shadow-sm ring-1 ring-inset ring-ui-border border-l-4 border-l-amber-500">
            <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-ink-secondary">Chứng từ quá hạn</p>
            <p class="mt-2 text-3xl font-black tabular-nums text-ink-primary font-display">{{ $thongke['so_hoa_don_qua_han'] ?? 0 }} <span class="text-sm font-bold text-ink-secondary/40">HĐ</span></p>
        </article>
        <article class="rounded-2xl border border-ui-border bg-white p-6 shadow-sm ring-1 ring-inset ring-ui-border border-l-4 border-l-rose-500">
            <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-ink-secondary">Tổng quỹ nợ</p>
            <p class="mt-2 text-3xl font-black tabular-nums text-rose-600 font-display">{{ number_format($thongke['tong_tien_no'] ?? 0) }}đ</p>
        </article>
    </section>

    <article class="overflow-hidden rounded-2xl bg-white border border-ui-border shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-ink-primary">
                <thead class="bg-ui-bg/50 border-b border-ui-border text-[10px] font-bold uppercase tracking-widest text-ink-secondary">
                    <tr>
                        <th class="px-6 py-4 font-bold">Vị trí phòng</th>
                        <th class="px-6 py-4 font-bold">Nhân khẩu liên quan</th>
                        <th class="px-6 py-4 font-bold">Kỳ nợ chi tiết</th>
                        <th class="px-6 py-4 font-bold">Tổng quyết toán nợ</th>
                        <th class="px-6 py-4 font-bold text-right">Điều phối</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-ui-border">
                    @forelse($congnoTheoPhong as $phongId => $dong)
                        @php
                            $phong = $dong['phong'] ?? null;
                            $danhsachSinhvien = $dong['sinhvien'] ?? collect();
                            $danhsachHoadon = collect($dong['hoadon'] ?? []);
                            $tongTien = (int) ($dong['tongtien'] ?? 0);
                        @endphp
                        <tr class="align-top group transition-colors hover:bg-ui-bg/50">
                            <td class="px-6 py-6">
                                <div class="inline-flex items-center gap-2 font-black text-ink-primary font-display text-lg">
                                    <div class="h-8 w-8 flex items-center justify-center rounded-lg bg-ui-bg text-ink-secondary/60 ring-1 ring-ui-border">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                    </div>
                                    {{ $phong->tenphong ?? 'N/A' }}
                                </div>
                            </td>
                            <td class="px-6 py-6">
                                @if($danhsachSinhvien->isEmpty())
                                    <span class="text-xs font-bold text-ink-secondary/30 uppercase tracking-widest italic">Vô chủ</span>
                                @else
                                    <div class="space-y-3">
                                        @foreach($danhsachSinhvien as $sv)
                                            <div class="flex items-center gap-2">
                                                <div class="h-6 w-6 rounded-full bg-ui-bg flex items-center justify-center text-[10px]">👤</div>
                                                <div class="flex flex-col">
                                                    <span class="text-xs font-bold text-ink-primary leading-none">{{ $sv->taikhoan->name ?? 'N/A' }}</span>
                                                    <span class="text-[9px] font-bold text-ink-secondary/60 uppercase tabular-nums mt-0.5">{{ $sv->masinhvien }}</span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-6">
                                <div class="space-y-2">
                                    @foreach($danhsachHoadon as $hoadon)
                                        <div class="flex items-center gap-3">
                                            <span class="text-[10px] font-bold text-ink-secondary uppercase tracking-wider tabular-nums">Kỳ {{ $hoadon->thang }}/{{ $hoadon->nam }}</span>
                                            <div class="h-px flex-1 bg-ui-border/50"></div>
                                            <span class="text-xs font-bold text-ink-primary tabular-nums">{{ number_format($hoadon->tongtien) }}đ</span>
                                        </div>
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-6 py-6">
                                <span class="text-xl font-black tabular-nums text-rose-600 font-display">{{ number_format($tongTien) }}đ</span>
                            </td>
                            <td class="px-6 py-6 text-right">
                                <form method="POST" action="{{ route('admin.guinhacnho', $phongId) }}" x-data="{ showConfirm: false }" @confirmed="$el.submit()">
                                    @csrf
                                    <button type="button" @click="$dispatch('open-confirm', { message: 'Gửi thông báo nhắc nợ chính thức cho toàn bộ sinh viên phòng này?', action: () => showConfirm = true })" class="flex items-center justify-center gap-2 rounded-xl bg-ink-primary px-5 py-2 text-xs font-bold text-white shadow-sm transition-all hover:bg-brand-emerald hover:shadow-md active:scale-[0.98]">
                                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                                        Gửi nhắc nợ
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-24 text-center">
                                <div class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-ui-bg text-ink-secondary/50 mb-3">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <div class="text-sm font-bold text-ink-primary">Không có công nợ tồn đọng</div>
                                <div class="text-[11px] text-ink-secondary mt-1">Tất cả các đơn vị phòng đang duy trì trạng thái tài chính minh bạch.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </article>
</x-admin-layout>
