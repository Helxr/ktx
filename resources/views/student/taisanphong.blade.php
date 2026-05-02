@extends('student.layouts.chinh')

@section('student_page_title', 'Tài sản phòng')

@section('noidung')
    @if($phong)
        <div class="mb-6 flex justify-end">
            <div class="flex items-center gap-3 rounded-xl bg-brand-emerald/10 border border-brand-emerald/20 px-4 py-3 shadow-sm">
                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-brand-emerald text-slate-100 shadow-sm">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                </div>
                <div>
                    <div class="text-[9px] font-black uppercase tracking-widest text-brand-emerald opacity-60">Phòng hiện tại</div>
                    <div class="text-sm font-black text-ink-primary uppercase tracking-tighter">{{ $phong->tenphong }}</div>
                </div>
            </div>
        </div>
    @endif

    @if (! $phong)
        <div class="rounded-[2.5rem] border border-amber-200 bg-amber-50/50 p-16 text-center shadow-sm animate-in fade-in zoom-in-95 duration-700">
            <div class="mx-auto mb-6 flex h-24 w-24 items-center justify-center rounded-3xl bg-amber-100 text-amber-600 ring-8 ring-amber-50">
                <svg class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
            </div>
            <h3 class="font-display text-xl font-black text-amber-900 uppercase tracking-tight">Chưa có thông tin phòng</h3>
            <p class="mt-2 text-xs font-medium text-amber-700/70 max-w-sm mx-auto">Bạn chưa được xếp phòng hoặc thông tin phòng chưa được cập nhật. Vui lòng liên hệ BQL để biết thêm chi tiết.</p>
        </div>
    @else
        <div class="animate-in fade-in slide-in-from-bottom-4 duration-1000">
            <article class="overflow-hidden rounded-[2rem] border border-ui-border bg-ui-card/50 backdrop-blur-xl shadow-sm transition-all hover:border-brand-emerald/10">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-ink-primary">
                        <thead class="bg-ui-bg/50 border-b border-ui-border text-[10px] font-bold uppercase tracking-widest text-ink-secondary">
                            <tr>
                                <th class="px-8 py-5">Tên tài sản / Vật tư</th>
                                <th class="px-8 py-5 text-center">Số lượng</th>
                                <th class="px-8 py-5">Tình trạng thực tế</th>
                                <th class="px-8 py-5 text-right">Ghi chú</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-ui-border">
                            @forelse($taisan as $item)
                                <tr class="group transition-colors hover:bg-ui-bg/30">
                                    <td class="px-8 py-6">
                                        <div class="flex items-center gap-4">
                                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-ui-bg text-ink-secondary group-hover:bg-brand-50 group-hover:text-brand-600 transition-colors">
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                            </div>
                                            <div>
                                                <div class="font-bold text-ink-primary text-sm uppercase tracking-tight">{{ $item->tentaisan }}</div>
                                                <div class="text-[9px] font-bold text-ink-secondary/40 uppercase tracking-widest mt-0.5">Mã TS: #AS-{{ str_pad((string)$item->id, 4, '0', STR_PAD_LEFT) }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6 text-center">
                                        <div class="font-display text-lg font-black text-ink-primary tabular-nums tracking-tight">{{ $item->soluong }}</div>
                                        <div class="text-[8px] font-bold text-ink-secondary/30 uppercase tracking-widest mt-1">Đơn vị: Cái</div>
                                    </td>
                                    <td class="px-8 py-6">
                                        @php
                                            $tinhtrang = strtolower($item->tinhtrang);
                                            $badgeClass = match(true) {
                                                str_contains($tinhtrang, 'tốt') || str_contains($tinhtrang, 'mới') => 'bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-600/20',
                                                str_contains($tinhtrang, 'hỏng') || str_contains($tinhtrang, 'kém') => 'bg-rose-50 text-rose-700 ring-1 ring-inset ring-rose-600/20',
                                                default => 'bg-blue-50 text-blue-700 ring-1 ring-inset ring-blue-700/10'
                                            };
                                        @endphp
                                        <span class="inline-flex items-center rounded-full px-3 py-1 text-[9px] font-black uppercase tracking-widest {{ $badgeClass }}">
                                            {{ $item->tinhtrang }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-6 text-right">
                                        <a href="{{ route('student.danhsachbaohong') }}" class="text-[10px] font-black text-brand-emerald uppercase tracking-widest hover:text-brand-700 transition-colors">
                                            Báo hỏng &rarr;
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-8 py-24 text-center">
                                        <div class="inline-flex h-20 w-20 items-center justify-center rounded-3xl bg-ui-bg text-ink-secondary/20 mb-6">
                                            <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                                        </div>
                                        <h3 class="font-display text-xl font-black text-ink-primary uppercase tracking-tight">Phòng trống trơn</h3>
                                        <p class="mt-2 text-xs font-medium text-ink-secondary/60 max-w-sm mx-auto">Chưa có thông tin về tài sản trang bị cho phòng này.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </article>

            <div class="mt-8 rounded-2xl bg-ink-primary p-8 text-white shadow-xl shadow-slate-900/10 relative overflow-hidden group">
                <div class="absolute -right-8 -bottom-8 h-32 w-32 rounded-full bg-white/5 blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
                <div class="relative flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div class="max-w-xl">
                        <h4 class="font-display text-xl font-black uppercase tracking-tight mb-2">Trách nhiệm bảo quản tài sản</h4>
                        <p class="text-xs font-medium leading-relaxed text-white/60">Sinh viên có trách nhiệm bảo quản các tài sản được trang bị. Trường hợp hư hỏng do lỗi chủ quan sẽ phải bồi thường theo quy định của KTX.</p>
                    </div>
                    <a href="{{ route('student.danhsachbaohong') }}" class="inline-flex h-12 items-center justify-center rounded-xl bg-white px-6 text-[10px] font-black uppercase tracking-widest text-ink-primary shadow-lg transition-all hover:-translate-y-0.5 active:translate-y-0">
                        Yêu cầu sửa chữa
                    </a>
                </div>
            </div>
        </div>
    @endif
@endsection
