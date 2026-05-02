@extends('student.layouts.chinh')

@section('student_page_title', 'Phòng của tôi')

@section('noidung')
    @if(!$coPhong)
        {{-- Chưa có phòng --}}
        <div class="rounded-2xl border border-ui-border bg-white p-8 text-center shadow-sm animate-in fade-in zoom-in-95 duration-500">
            <div class="mx-auto mb-5 flex h-20 w-20 items-center justify-center rounded-full bg-ui-bg text-ink-secondary/40 ring-8 ring-ui-bg/50">
                <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-ink-primary mb-2">Bạn chưa có phòng</h3>
            <p class="text-sm font-medium text-ink-secondary/70 mb-8 max-w-md mx-auto">Hiện tại hệ thống chưa ghi nhận thông tin lưu trú của bạn. Vui lòng xem danh sách phòng trống và gửi yêu cầu đăng ký.</p>
            
            @if($danhsachphongtrong->count() > 0)
                <div class="text-left mt-10">
                    <div class="flex items-center gap-2 mb-6">
                        <span class="flex h-6 w-6 items-center justify-center rounded-full bg-brand-50 text-brand-600">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        </span>
                        <h4 class="text-sm font-bold text-ink-primary uppercase tracking-tight">Gợi ý dành cho bạn</h4>
                    </div>
                    
                    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach($danhsachphongtrong as $phong)
                            <div class="group relative overflow-hidden rounded-2xl border border-ui-border bg-white p-5 shadow-sm transition-all hover:border-brand-emerald hover:shadow-md">
                                <div class="absolute -right-6 -top-6 h-20 w-20 rounded-full bg-brand-50 opacity-0 transition-opacity group-hover:opacity-100"></div>
                                <div class="relative">
                                    <div class="flex items-start justify-between mb-4">
                                        <div>
                                            <div class="text-lg font-bold text-ink-primary font-display">{{ $phong->tenphong }}</div>
                                            <div class="text-[10px] font-bold text-ink-secondary/60 uppercase tracking-widest mt-0.5">Tầng {{ $phong->tang }} • Tòa {{ $phong->toa }}</div>
                                        </div>
                                        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-ui-bg text-ink-secondary">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                        </div>
                                    </div>
                                    
                                    <div class="space-y-2 mb-6">
                                        <div class="flex items-center justify-between text-sm">
                                            <span class="font-medium text-ink-secondary/70">Đơn giá</span>
                                            <span class="font-bold text-ink-primary">{{ number_format($phong->giaphong) }}đ<span class="text-[10px] text-ink-secondary/50 font-normal">/tháng</span></span>
                                        </div>
                                        <div class="flex items-center justify-between text-sm">
                                            <span class="font-medium text-ink-secondary/70">Trống</span>
                                            <span class="font-bold text-brand-emerald">{{ $phong->succhuamax - $phong->dango }} giường</span>
                                        </div>
                                    </div>

                                    <form method="POST" action="{{ route('student.dangkyphong') }}">
                                        @csrf
                                        <input type="hidden" name="phong_id" value="{{ $phong->id }}">
                                        <button type="submit" class="w-full flex items-center justify-center rounded-xl bg-ink-primary py-2.5 text-xs font-bold text-white shadow-sm transition-all hover:bg-brand-emerald active:scale-[0.98]">
                                            Đăng ký phòng này
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
            
            <div class="mt-8">
                <a href="{{ route('student.danhsachphong') }}" class="inline-flex items-center gap-2 rounded-xl bg-ui-bg px-5 py-2.5 text-xs font-bold text-ink-primary transition-colors hover:bg-ui-border">
                    Xem tất cả phòng trống
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>
        </div>
    @else
        {{-- Có phòng --}}
        <div class="grid gap-8 lg:grid-cols-12 animate-in fade-in slide-in-from-bottom-4 duration-700">
            {{-- MAIN COLUMN: Room Info & Contracts --}}
            <div class="lg:col-span-8 space-y-8">
                
                {{-- Room Header Card --}}
                <article class="relative overflow-hidden rounded-3xl border border-ui-border bg-white shadow-sm">
                    <div class="absolute top-0 left-0 w-full h-32 bg-gradient-to-b from-brand-50 to-transparent"></div>
                    <div class="relative p-8">
                        <div class="flex flex-col md:flex-row md:items-start justify-between gap-6">
                            <div class="flex items-center gap-5">
                                <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl bg-white shadow-sm ring-1 ring-ui-border text-brand-600">
                                    <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                </div>
                                <div>
                                    <div class="flex items-center gap-2 mb-1">
                                        <h2 class="text-3xl font-black text-ink-primary font-display tracking-tight">{{ $phong->tenphong }}</h2>
                                        <span class="inline-flex items-center rounded-md bg-ui-bg px-2 py-0.5 text-[10px] font-bold uppercase tracking-widest text-ink-secondary">Tầng {{ $phong->tang }}</span>
                                    </div>
                                    <p class="text-sm font-medium text-ink-secondary/70 flex items-center gap-2">
                                        Khu vực dành cho <span class="font-bold text-ink-primary">{{ $phong->gioitinh }}</span>
                                    </p>
                                </div>
                            </div>
                            <div class="text-left md:text-right bg-white/60 backdrop-blur-md p-4 rounded-2xl border border-ui-border/50 shadow-sm">
                                <div class="text-[10px] font-bold uppercase tracking-[0.15em] text-ink-secondary/60 mb-1">Đơn giá niêm yết</div>
                                <div class="text-2xl font-black text-ink-primary tracking-tight">{{ number_format($phong->giaphong) }}đ<span class="text-xs font-medium text-ink-secondary/50">/tháng</span></div>
                            </div>
                        </div>

                        {{-- Room Stats --}}
                        <div class="mt-8 grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div class="rounded-2xl bg-ui-bg/50 p-4 border border-ui-border/50">
                                <div class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary/60 mb-1">Sức chứa</div>
                                <div class="text-lg font-bold text-ink-primary"><span class="text-brand-600">{{ $banCungPhong->count() + 1 }}</span>/{{ $phong->succhuamax }} <span class="text-xs font-medium text-ink-secondary/50">giường</span></div>
                            </div>
                            <div class="rounded-2xl bg-ui-bg/50 p-4 border border-ui-border/50">
                                <div class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary/60 mb-1">Bạn cùng phòng</div>
                                <div class="text-lg font-bold text-ink-primary">{{ $banCungPhong->count() }} <span class="text-xs font-medium text-ink-secondary/50">người</span></div>
                            </div>
                            <div class="rounded-2xl bg-ui-bg/50 p-4 border border-ui-border/50 md:col-span-2">
                                <div class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary/60 mb-1">Đánh giá không gian</div>
                                <div class="flex items-center gap-2">
                                    <div class="flex gap-0.5">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="h-5 w-5 {{ $i <= round((float)$diemTrungBinh) ? 'text-amber-400' : 'text-ui-border' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        @endfor
                                    </div>
                                    <span class="text-lg font-bold text-ink-primary">{{ number_format((float)$diemTrungBinh, 1) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>

                {{-- Contract Warning & Info --}}
                @if($canhBaoHetHan)
                    @php
                        $alertColor = match($canhBaoHetHan['muc_do']) {
                            'nguy_hiểm' => 'rose',
                            'cảnh_báo' => 'amber',
                            default => 'blue'
                        };
                    @endphp
                    <div class="rounded-2xl border border-{{ $alertColor }}-200 bg-{{ $alertColor }}-50/50 p-6 shadow-sm relative overflow-hidden">
                        <div class="absolute -right-8 -top-8 h-24 w-24 rounded-full bg-{{ $alertColor }}-200/30 blur-2xl"></div>
                        <div class="relative flex items-start gap-4">
                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-white shadow-sm ring-1 ring-{{ $alertColor }}-200 text-{{ $alertColor }}-600">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-{{ $alertColor }}-800 mb-1">Hợp đồng sắp hết hạn (còn {{ $canhBaoHetHan['so_ngay_con_lai'] }} ngày)</h3>
                                <p class="text-xs font-medium text-{{ $alertColor }}-700/80 leading-relaxed mb-3">Thời gian lưu trú của bạn sẽ kết thúc vào ngày <span class="font-bold">{{ $canhBaoHetHan['ngay_het_han'] }}</span>. Vui lòng làm thủ tục gia hạn hoặc trả phòng.</p>
                                <div class="flex items-center gap-3">
                                    <button data-modal-target="modal-giahan" data-modal-toggle="modal-giahan" class="h-8 rounded-lg bg-{{ $alertColor }}-600 px-4 text-[10px] font-bold uppercase tracking-widest text-white shadow-sm hover:bg-{{ $alertColor }}-700 transition-colors">Gia hạn ngay</button>
                                    <button data-modal-target="modal-traphong" data-modal-toggle="modal-traphong" class="h-8 rounded-lg border border-{{ $alertColor }}-200 bg-white px-4 text-[10px] font-bold uppercase tracking-widest text-{{ $alertColor }}-700 shadow-sm hover:bg-{{ $alertColor }}-50 transition-colors">Yêu cầu trả phòng</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if($hopdongHienTai)
                    <article class="rounded-2xl border border-ui-border bg-white p-6 shadow-sm">
                        <div class="flex items-center justify-between mb-6 pb-4 border-b border-ui-border">
                            <h3 class="text-sm font-bold text-ink-primary uppercase tracking-tight">Hồ sơ lưu trú</h3>
                            <span class="inline-flex items-center rounded-md bg-emerald-50 px-2.5 py-1 text-[10px] font-bold uppercase tracking-widest text-emerald-700 ring-1 ring-inset ring-emerald-600/20">
                                {{ $hopdongHienTai->trang_thai }}
                            </span>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                            <div>
                                <div class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary/50 mb-1">Ngày bắt đầu</div>
                                <div class="text-sm font-bold text-ink-primary tabular-nums">{{ date('d/m/Y', strtotime($hopdongHienTai->ngay_bat_dau)) }}</div>
                            </div>
                            <div>
                                <div class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary/50 mb-1">Ngày kết thúc</div>
                                <div class="text-sm font-bold text-ink-primary tabular-nums">{{ date('d/m/Y', strtotime($hopdongHienTai->ngay_ket_thuc)) }}</div>
                            </div>
                            <div>
                                <div class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary/50 mb-1">Giá phòng lúc ký</div>
                                <div class="text-sm font-bold text-ink-primary tabular-nums">{{ number_format($hopdongHienTai->giaphong_luc_ky) }}đ</div>
                            </div>
                        </div>
                    </article>
                @endif

                {{-- Roommates List --}}
                @if($banCungPhong->count() > 0)
                    <article class="rounded-2xl border border-ui-border bg-white overflow-hidden shadow-sm">
                        <div class="p-6 border-b border-ui-border bg-ui-bg/30">
                            <h3 class="text-sm font-bold text-ink-primary uppercase tracking-tight">Thành viên cùng phòng</h3>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-px bg-ui-border">
                            @foreach($banCungPhong as $ban)
                                <div class="flex items-center gap-4 bg-white p-5 transition-colors hover:bg-ui-bg/30">
                                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-brand-50 font-black text-brand-600 ring-2 ring-white shadow-sm font-display text-lg">
                                        {{ strtoupper(substr($ban->taikhoan->name ?? 'U', 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-ink-primary text-sm tracking-tight mb-0.5">{{ $ban->taikhoan->name ?? 'Không xác định' }}</div>
                                        <div class="flex items-center gap-2 text-[10px] font-bold uppercase tracking-widest text-ink-secondary/60">
                                            <span>SV</span>
                                            <span class="h-1 w-1 rounded-full bg-ui-border"></span>
                                            <span>{{ $ban->mssv ?? 'N/A' }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </article>
                @endif
            </div>

            {{-- SIDEBAR: Invoices & Assets --}}
            <aside class="lg:col-span-4 space-y-8">
                
                {{-- Unpaid Invoices Alert --}}
                @if($hoadonChuaThanhToan->count() > 0)
                    <article class="rounded-2xl border border-rose-200 bg-white p-6 shadow-sm shadow-rose-100">
                        <div class="flex items-center gap-3 mb-6 pb-4 border-b border-ui-border">
                            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-rose-50 text-rose-600">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <h3 class="text-sm font-bold text-rose-700 uppercase tracking-tight">Cần thanh toán</h3>
                        </div>
                        
                        <div class="mb-6 text-center">
                            <div class="text-[10px] font-bold uppercase tracking-[0.15em] text-ink-secondary/50 mb-1">Tổng nợ phòng</div>
                            <div class="text-3xl font-black text-rose-600 tabular-nums tracking-tight">{{ number_format($tongNo) }}đ</div>
                        </div>

                        <div class="space-y-3">
                            @foreach($hoadonChuaThanhToan as $hoadon)
                                <div class="flex items-center justify-between rounded-xl bg-ui-bg p-4 border border-ui-border/50">
                                    <div>
                                        <div class="text-xs font-bold text-ink-primary mb-0.5">Tháng {{ $hoadon->thang }}/{{ $hoadon->nam }}</div>
                                        <div class="text-[9px] font-bold text-rose-500 uppercase tracking-widest">Hạn: {{ date('d/m', strtotime($hoadon->ngayxuat . ' +5 days')) }}</div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-sm font-bold text-ink-primary tabular-nums">{{ number_format($hoadon->tongtien) }}đ</div>
                                        <a href="{{ route('student.phongcuatoi.hoadon.chitiet', $hoadon->id) }}" class="inline-block mt-1 text-[10px] font-bold uppercase tracking-widest text-brand-600 hover:text-brand-700">Chi tiết</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </article>
                @endif

                {{-- Room Review Status --}}
                <article class="rounded-2xl border border-ui-border bg-white p-6 shadow-sm">
                    <h3 class="text-sm font-bold text-ink-primary uppercase tracking-tight mb-4">Đánh giá hàng tháng</h3>
                    @if($daDanhGia)
                        <div class="flex flex-col items-center justify-center rounded-xl bg-emerald-50 border border-emerald-100 p-6 text-center">
                            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-white shadow-sm text-emerald-500 mb-3">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <h4 class="text-xs font-bold text-emerald-800 mb-1">Cảm ơn bạn!</h4>
                            <p class="text-[10px] font-medium text-emerald-700/70 uppercase tracking-widest">Đã gửi đánh giá tháng này</p>
                        </div>
                    @else
                        <div class="flex flex-col items-center justify-center rounded-xl bg-ui-bg p-6 text-center border border-ui-border border-dashed">
                            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-white shadow-sm text-ink-secondary/40 mb-3">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </div>
                            <h4 class="text-xs font-bold text-ink-primary mb-3">Đóng góp ý kiến</h4>
                            <button data-modal-target="modal-danhgia" data-modal-toggle="modal-danhgia" class="h-8 w-full flex items-center justify-center rounded-lg bg-ink-primary px-4 text-[10px] font-bold uppercase tracking-widest text-white shadow-sm hover:bg-brand-emerald transition-colors">Đánh giá ngay</button>
                        </div>
                    @endif
                </article>

                {{-- Room Assets & Inventory --}}
                @if($taisan->count() > 0 || $vattu->count() > 0)
                    <article class="rounded-2xl border border-ui-border bg-white overflow-hidden shadow-sm">
                        <div class="flex items-center justify-between p-6 border-b border-ui-border bg-ui-bg/30">
                            <h3 class="text-sm font-bold text-ink-primary uppercase tracking-tight">Tài sản & Vật tư</h3>
                            <span class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary/50">{{ $taisan->count() + $vattu->count() }} mục</span>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-2 gap-3">
                                @foreach($taisan as $item)
                                    <div class="rounded-xl bg-ui-bg p-3 border border-ui-border/50">
                                        <div class="text-xs font-bold text-ink-primary mb-1 truncate" title="{{ $item->tentaisan }}">{{ $item->tentaisan }}</div>
                                        <div class="text-[10px] font-bold text-ink-secondary/60 uppercase tracking-widest">SL: {{ $item->soluong }}</div>
                                    </div>
                                @endforeach
                                @foreach($vattu as $item)
                                    <div class="rounded-xl bg-ui-bg p-3 border border-ui-border/50">
                                        <div class="text-xs font-bold text-ink-primary mb-1 truncate" title="{{ $item->tenvattu }}">{{ $item->tenvattu }}</div>
                                        <div class="text-[10px] font-bold text-ink-secondary/60 uppercase tracking-widest">SL: {{ $item->soluong }}</div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="mt-4 pt-4 border-t border-ui-border/50 text-center">
                                <a href="{{ route('student.danhsachbaohong') }}" class="text-[10px] font-bold text-brand-600 uppercase tracking-widest hover:text-brand-700">Yêu cầu bảo trì/sửa chữa &rarr;</a>
                            </div>
                        </div>
                    </article>
                @endif
            </aside>
        </div>
    @endif

    {{-- Modal Gia hạn --}}
    @if($coPhong && $canhBaoHetHan)
        <div id="modal-giahan" tabindex="-1" aria-hidden="true" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/40 p-4 backdrop-blur-sm">
            <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-xl ring-1 ring-ui-border">
                <div class="mb-6 flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-ink-primary">Gia hạn hợp đồng</h3>
                        <p class="text-xs font-medium text-ink-secondary/70 mt-1">Làm thủ tục gia hạn lưu trú</p>
                    </div>
                    <button type="button" class="flex h-8 w-8 items-center justify-center rounded-full bg-ui-bg text-ink-secondary hover:bg-ui-border hover:text-ink-primary transition-colors" data-modal-hide="modal-giahan">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <div class="rounded-xl bg-brand-50 border border-brand-100 p-4 mb-6">
                    <div class="flex items-start gap-3">
                        <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-brand-100 text-brand-600">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-brand-800 mb-1">Tính năng đang phát triển</h4>
                            <p class="text-[10px] font-medium text-brand-700/70 leading-relaxed">Chức năng gia hạn hợp đồng đang được hoàn thiện. Vui lòng liên hệ Ban quản lý KTX trực tiếp để được hỗ trợ.</p>
                        </div>
                    </div>
                </div>
                <button type="button" data-modal-hide="modal-giahan" class="w-full flex h-11 items-center justify-center rounded-xl bg-ink-primary px-4 text-xs font-bold uppercase tracking-widest text-white shadow-sm hover:bg-brand-emerald active:scale-[0.98] transition-all">
                    Đã hiểu
                </button>
            </div>
        </div>
    @endif

    {{-- Modal Trả phòng --}}
    @if($coPhong)
        <div id="modal-traphong" tabindex="-1" aria-hidden="true" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/40 p-4 backdrop-blur-sm">
            <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-xl ring-1 ring-ui-border">
                <div class="mb-6 flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-ink-primary">Yêu cầu trả phòng</h3>
                        <p class="text-xs font-medium text-ink-secondary/70 mt-1">Làm thủ tục trả phòng và thanh toán</p>
                    </div>
                    <button type="button" class="flex h-8 w-8 items-center justify-center rounded-full bg-ui-bg text-ink-secondary hover:bg-ui-border hover:text-ink-primary transition-colors" data-modal-hide="modal-traphong">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <div class="rounded-xl bg-brand-50 border border-brand-100 p-4 mb-6">
                    <div class="flex items-start gap-3">
                        <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-brand-100 text-brand-600">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-brand-800 mb-1">Tính năng đang phát triển</h4>
                            <p class="text-[10px] font-medium text-brand-700/70 leading-relaxed">Chức năng yêu cầu trả phòng đang được hoàn thiện. Vui lòng liên hệ Ban quản lý KTX trực tiếp để được hỗ trợ.</p>
                        </div>
                    </div>
                </div>
                <button type="button" data-modal-hide="modal-traphong" class="w-full flex h-11 items-center justify-center rounded-xl bg-ink-primary px-4 text-xs font-bold uppercase tracking-widest text-white shadow-sm hover:bg-brand-emerald active:scale-[0.98] transition-all">
                    Đã hiểu
                </button>
            </div>
        </div>
    @endif

    {{-- Modal Đánh giá --}}
    @if($coPhong && !$daDanhGia)
        <div id="modal-danhgia" tabindex="-1" aria-hidden="true" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/40 p-4 backdrop-blur-sm">
            <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-xl ring-1 ring-ui-border">
                <div class="mb-6 flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-ink-primary">Đánh giá phòng tháng {{ date('m/Y') }}</h3>
                        <p class="text-xs font-medium text-ink-secondary/70 mt-1">Giúp KTX nâng cao chất lượng dịch vụ</p>
                    </div>
                    <button type="button" class="flex h-8 w-8 items-center justify-center rounded-full bg-ui-bg text-ink-secondary hover:bg-ui-border hover:text-ink-primary transition-colors" data-modal-hide="modal-danhgia">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                
                <form method="POST" action="{{ route('student.themdanhgia') }}" class="space-y-6">
                    @csrf
                    <input type="hidden" name="phong_id" value="{{ $phong->id }}">
                    
                    <div>
                        <label class="block text-[10px] font-bold uppercase tracking-widest text-ink-secondary mb-3">Mức độ hài lòng (1-5 sao)</label>
                        <div class="flex items-center gap-2 justify-center py-4 bg-ui-bg/50 rounded-xl border border-ui-border/50">
                            @for($i = 5; $i >= 1; $i--)
                                <input type="radio" name="diem" id="star{{ $i }}" value="{{ $i }}" class="peer hidden" {{ $i === 5 ? 'checked' : '' }}>
                                <label for="star{{ $i }}" class="cursor-pointer text-ui-border hover:text-amber-400 peer-checked:text-amber-400 transition-colors">
                                    <svg class="h-8 w-8" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                </label>
                            @endfor
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-[10px] font-bold uppercase tracking-widest text-ink-secondary mb-2">Góp ý thêm (Tùy chọn)</label>
                        <textarea name="nhanxet" rows="3" class="w-full rounded-xl border-ui-border bg-white px-4 py-3 text-sm text-ink-primary shadow-sm focus:border-brand-500 focus:ring-brand-500 placeholder:text-ink-secondary/40" placeholder="Chia sẻ trải nghiệm của bạn về vệ sinh, an ninh, tiện ích..."></textarea>
                    </div>
                    
                    <button type="submit" class="w-full flex h-11 items-center justify-center rounded-xl bg-ink-primary px-4 text-xs font-bold uppercase tracking-widest text-white shadow-sm hover:bg-brand-emerald active:scale-[0.98] transition-all">
                        Gửi đánh giá
                    </button>
                </form>
            </div>
        </div>
    @endif
@endsection
