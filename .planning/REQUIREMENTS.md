# Business Workflows: Hệ thống Quản lý KTX

Dưới đây là mô tả chi tiết luồng nghiệp vụ cho 3 đối tượng người dùng, hướng tới mục tiêu đạt điểm tuyệt đối về trải nghiệm và logic.

## 1. Persona: Khách (Guest - Landing Page)
- **Mục tiêu:** Tìm hiểu và Đăng ký giữ chỗ (Soft Lock).
- **Workflow:**
    1. **Trang chủ:** Xem giới thiệu KTX, hình ảnh các tòa và tiện ích.
    2. **Tra cứu & Soft Lock:** 
        - Xem danh sách phòng và số lượng giường trống Real-time.
        - **Cơ chế Soft Lock:** Hiển thị cảnh báo "Đang có người đặt" nếu giường đang trong quá trình phê duyệt để tránh đăng ký chồng chéo.
    3. **Đăng ký (Registration Modal):** Nhấn "Đăng ký" trực tiếp tại phòng mong muốn.
        - Điền thông tin cá nhân (Họ tên, Email, SĐT, CCCD).
        - **Bảo mật PII:** Toàn bộ thông tin định danh được mã hóa chuẩn AES-256.
        - Tải lên ảnh thẻ và ảnh CCCD (Lưu trữ an toàn trong phân vùng `private`).
        - Chọn chính xác giường số (Giuong No) trong phòng.
    4. **Theo dõi:** 
        - Nhận **Magic Link** và **Mã tra cứu** qua Email ngay sau khi nộp đơn.
        - Truy cập trang "Tra cứu đơn" để theo dõi trạng thái hồ sơ (Pending -> Approved_Pending_Payment -> Completed).

## 2. Persona: Admin (Management - Admin Panel)
- **Mục tiêu:** Điều hành và Kiểm soát quy trình 2 bước.
- **Workflow:**
    1. **Bước 1 - Phê duyệt Hồ sơ (approveProfile):**
        - Kiểm tra tính xác thực của thông tin PII và ảnh CCCD (Xem qua route bảo mật stream file từ storage private).
        - Chuyển trạng thái sang `APPROVED_PENDING_PAYMENT`.
        - Hệ thống tự động gửi Email **Yêu cầu thanh toán** kèm thông tin chuyển khoản ngân hàng cho Khách.
    2. **Bước 2 - Xác nhận Thanh toán (confirmPayment):**
        - Đối soát giao dịch ngân hàng.
        - Khi Admin bấm "Xác nhận thanh toán", hệ thống thực hiện chuỗi giao dịch nguyên tử (Atomic Transaction):
            - Tạo tài khoản User (Email/Password mặc định).
            - Tạo hồ sơ Sinh viên (`sinhvien`).
            - Tạo Hợp đồng (`hopdong`) có hiệu lực ngay lập tức.
            - Tạo hóa đơn đầu tiên (`hoadon`) với logic **Pro-rata** (tính tiền phòng lẻ ngày theo thời điểm vào ở).
    3. **Quản lý Sinh viên:** Xem danh sách theo Tòa/Tầng/Phòng. Quản lý trạng thái (Đang ở, Đã trả phòng, Nợ phí).
    4. **Quản lý Tài chính:** 
        - Nhập chỉ số điện/nước hàng tháng. Hệ thống tự động chia hóa đơn.
        - Theo dõi công nợ và gửi thông báo nhắc nhở tự động.
    5. **Quản lý Cơ sở vật chất:** Tiếp nhận báo hỏng -> Điều phối sửa chữa -> Cập nhật trạng thái "Đã xong".

## 3. Persona: Sinh viên (Student - Dashboard)
- **Mục tiêu:** Quản lý cuộc sống nội trú.
- **Workflow:**
    1. **Đăng nhập:** Nhận thông tin kích hoạt tài khoản sau khi hoàn tất thanh toán.
    2. **Tổng quan:** Xem số phòng, vị trí giường, và danh sách bạn cùng phòng.
    3. **Tài chính:** 
        - Xem chi tiết các hóa đơn hàng tháng (Tiền phòng, Điện, Nước).
        - Xem lịch sử thanh toán và trạng thái hợp đồng.
    4. **Dịch vụ:** 
        - Gửi yêu cầu "Báo hỏng" kèm ảnh chụp. Theo dõi tiến độ sửa chữa.
        - Đăng ký tạm vắng / Yêu cầu chuyển phòng / Trả phòng.
    5. **Thông tin:** Nhận thông báo từ Ban quản lý qua Dashboard.
