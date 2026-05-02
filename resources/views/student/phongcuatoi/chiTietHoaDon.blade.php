@extends('student.layouts.chinh')

@section('noidung')
    <div class="mb-6">
        <a href="{{ route('student.hoadoncuaem') }}" class="mb-2 inline-flex items-center text-sm text-[#606060] hover:text-[#121212]">
            <svg class="mr-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Quay lại lịch sử hóa đơn
        </a>
        <div class="text-2xl font-bold text-[#121212]">Chi tiết hóa đơn {{ $hoadon->thang }}/{{ $hoadon->nam }}</div>
        <div class="text-sm text-[#606060]">Phòng {{ $hoadon->phong->tenphong ?? 'N/A' }}</div>
    </div>

    {{-- Trạng thái --}}
    <div class="mb-6">
        @if($hoadon->trangthaithanhtoan === 'Đã thanh toán')
            <div class="rounded-lg bg-green-50 p-4 text-center">
                <div class="mx-auto mb-2 flex h-12 w-12 items-center justify-center rounded-full bg-green-100">
                    <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <p class="font-medium text-green-800">Hóa đơn đã được thanh toán</p>
                <p class="text-sm text-green-600">Ngày thanh toán: {{ $hoadon->ngaythanhtoan ? date('d/m/Y', strtotime($hoadon->ngaythanhtoan)) : 'N/A' }}</p>
            </div>
        @else
            <div class="rounded-lg bg-red-50 p-4 text-center">
                <div class="mx-auto mb-2 flex h-12 w-12 items-center justify-center rounded-full bg-red-100">
                    <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <p class="font-medium text-red-800">Hóa đơn chưa thanh toán</p>
                <p class="text-sm text-red-600">Hạn thanh toán: {{ date('d/m/Y', strtotime($hoadon->ngayxuat . ' +5 days')) }}</p>
            </div>
        @endif
    </div>

    {{-- Chi tiết từng khoản --}}
    <div class="mb-6 rounded-xl border border-gray-200/70 bg-ui-card p-6">
        <h3 class="mb-4 font-semibold text-[#121212]">Chi tiết hóa đơn</h3>
        <div class="space-y-3">
            <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                <div>
                    <div class="font-medium text-[#121212]">Tiền phòng</div>
                    <div class="text-xs text-[#606060]">Phòng {{ $hoadon->phong->tenphong ?? 'N/A' }}</div>
                </div>
                <div class="text-right">
                    <div class="font-medium text-[#121212]">{{ number_format($hoadon->tienphong) }} đ</div>
                    <div class="text-xs text-[#606060]">÷ {{ $soNguoiTrongPhong }} người = {{ number_format($chiTietTien['tien_phong']) }} đ/người</div>
                </div>
            </div>
            <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                <div class="font-medium text-[#121212]">Tiền điện</div>
                <div class="text-right">
                    <div class="font-medium text-[#121212]">{{ number_format($hoadon->tiendien) }} đ</div>
                    <div class="text-xs text-[#606060]">÷ {{ $soNguoiTrongPhong }} người = {{ number_format($chiTietTien['tien_dien']) }} đ/người</div>
                </div>
            </div>
            <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                <div class="font-medium text-[#121212]">Tiền nước</div>
                <div class="text-right">
                    <div class="font-medium text-[#121212]">{{ number_format($hoadon->tiennuoc) }} đ</div>
                    <div class="text-xs text-[#606060]">÷ {{ $soNguoiTrongPhong }} người = {{ number_format($chiTietTien['tien_nuoc']) }} đ/người</div>
                </div>
            </div>
            <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                <div class="font-medium text-[#121212]">Phí dịch vụ</div>
                <div class="text-right">
                    <div class="font-medium text-[#121212]">{{ number_format($hoadon->phidichvu) }} đ</div>
                    <div class="text-xs text-[#606060]">÷ {{ $soNguoiTrongPhong }} người = {{ number_format($chiTietTien['phi_dich_vu']) }} đ/người</div>
                </div>
            </div>
            <div class="flex items-center justify-between pt-2">
                <div class="font-semibold text-[#121212]">Tổng cộng</div>
                <div class="text-right">
                    <div class="text-lg font-bold text-[#121212]">{{ number_format($hoadon->tongtien) }} đ</div>
                    <div class="text-xs text-[#606060]">{{ $soNguoiTrongPhong }} người chia đều = {{ number_format($chiTietTien['tong_tien']) }} đ/người</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Note --}}
    @if($hoadon->ghichu)
        <div class="rounded-lg bg-yellow-50 p-4">
            <div class="flex items-start gap-2">
                <svg class="mt-0.5 h-5 w-5 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                </svg>
                <div>
                    <p class="font-medium text-yellow-800">Ghi chú</p>
                    <p class="text-sm text-yellow-700">{{ $hoadon->ghichu }}</p>
                </div>
            </div>
        </div>
    @endif
@endsection
