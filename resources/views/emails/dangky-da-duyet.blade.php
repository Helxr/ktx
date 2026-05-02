<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Dang ky phong da duoc duyet</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #0f172a;">
    <h2>Thong bao duyet dang ky phong</h2>

    <p>Chao {{ $sinhvien->taikhoan?->name ?? 'ban' }},</p>
    <p>Don dang ky phong cua ban da duoc duyet.</p>

    <p><strong>Thong tin hop dong</strong></p>
    <ul>
        <li>Phong: {{ $phong->tenphong }}</li>
        <li>Ngay bat dau: {{ $hopdong->ngay_bat_dau }}</li>
        <li>Ngay ket thuc: {{ $hopdong->ngay_ket_thuc }}</li>
        <li>Gia phong luc ky: {{ number_format($hopdong->giaphong_luc_ky, 0, ',', '.') }} VND</li>
    </ul>

    <p><strong>Hoa don dau tien</strong></p>
    <ul>
        <li>Ky thanh toan: thang {{ $hoadon->thang }}/{{ $hoadon->nam }}</li>
        <li>Tong tien: {{ number_format($hoadon->tongtien, 0, ',', '.') }} VND</li>
        <li>Trang thai: {{ $hoadon->trangthaithanhtoan }}</li>
    </ul>

    <p>Ban vui long dang nhap he thong de xem chi tiet hop dong va hoa don.</p>
</body>
</html>
