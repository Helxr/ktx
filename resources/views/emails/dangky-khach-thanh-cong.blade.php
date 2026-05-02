<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký KTX thành công</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <div style="background: #00A86B; padding: 30px; border-radius: 10px 10px 0 0; text-align: center;">
            <h1 style="color: white; margin: 0; font-size: 24px;">Đăng ký KTX thành công</h1>
        </div>
        
        <div style="background: #f9f9f9; padding: 30px; border-radius: 0 0 10px 10px; border: 1px solid #e0e0e0;">
            <p style="font-size: 16px; margin-bottom: 20px;">Chào <strong>{{ $hoTen }}</strong>,</p>
            
            <p style="font-size: 16px; margin-bottom: 20px;">Cảm ơn bạn đã đăng ký cư trú tại Ký túc xá của chúng tôi. Đơn đăng ký của bạn đã được ghi nhận thành công.</p>
            
            <div style="background: white; padding: 20px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #00A86B;">
                <h3 style="margin-top: 0; color: #00A86B;">Thông tin đăng ký:</h3>
                <p style="margin: 10px 0;"><strong>Phòng đã chọn:</strong> {{ $phongTen }}</p>
                <p style="margin: 10px 0;"><strong>Trạng thái:</strong> Chờ xử lý</p>
            </div>
            
            <div style="background: #e8f4f8; padding: 20px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #00A86B;">
                <h3 style="margin-top: 0; color: #00A86B;">Mã tra cứu của bạn:</h3>
                <p style="font-size: 18px; font-weight: bold; color: #00A86B; margin: 10px 0; letter-spacing: 2px;">{{ $token }}</p>
                <p style="margin: 10px 0; font-size: 14px;">Bạn có thể dùng mã này để tra cứu trạng thái đăng ký tại bất kỳ lúc nào.</p>
                <a href="{{ $lookupUrl }}" style="display: inline-block; background: #00A86B; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; font-weight: bold; margin-top: 10px;">Tra cứu ngay</a>
            </div>
            
            <p style="font-size: 14px; color: #666; margin-top: 30px; padding-top: 20px; border-top: 1px solid #e0e0e0;">
                Nếu bạn có bất kỳ câu hỏi nào, vui lòng liên hệ với bộ phận quản lý KTX.<br><br>
                Trân trọng,<br>
                Bộ phận Quản lý KTX
            </p>
        </div>
    </div>
</body>
</html>
