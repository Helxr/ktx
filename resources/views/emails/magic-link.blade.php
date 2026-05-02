<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #eee; border-radius: 10px; }
        .header { text-align: center; margin-bottom: 30px; }
        .btn { display: inline-block; padding: 12px 24px; background-color: #4f46e5; color: #fff; text-decoration: none; border-radius: 6px; font-weight: bold; }
        .footer { margin-top: 30px; font-size: 12px; color: #777; text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Chào bạn, {{ $dangky->ho_ten }}!</h2>
        </div>
        <p>Cảm ơn bạn đã quan tâm và đăng ký phòng tại KTX Đại học ABC.</p>
        <p>Để tra cứu tiến độ xử lý hồ sơ của mình, bạn có thể sử dụng mã tra cứu sau:</p>
        <div style="background: #f8fafc; padding: 15px; text-align: center; font-size: 24px; font-weight: bold; letter-spacing: 2px; color: #00A86B; border-radius: 8px; margin: 20px 0;">
            {{ $dangky->lookup_token }}
        </div>
        <p>Hoặc bạn có thể nhấn vào nút bên dưới để xem trực tiếp trạng thái đơn:</p>
        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ route('guest.lookup', ['token' => $dangky->lookup_token]) }}" class="btn">Tra cứu ngay</a>
        </div>
        <p>Lưu ý: Đơn đăng ký của bạn có hiệu lực giữ chỗ trong vòng 24 giờ. Vui lòng theo dõi email thường xuyên.</p>
        <div class="footer">
            &copy; {{ date('Y') }} KTX Đại học ABC. Mọi quyền được bảo lưu.
        </div>
    </div>
</body>
</html>
