# Standards & Known Issues

## Naming Conventions

### Nguyên tắc cốt lõi
- **Tiếng Việt** → tất cả class/file gắn với nghiệp vụ domain (Controllers, Models, Services, Requests, Observers, Traits)
- **Tiếng Anh** → chỉ Enums (lý do kỹ thuật: backed value lưu DB/JSON phải an toàn encoding)
- **File name = Class name** (PHP PSR-4 autoloading)

### Bảng quy tắc

| Loại | Quy tắc | Ví dụ |
|------|---------|-------|
| **Controllers** | Tiếng Việt + `Controller` | `SinhvienController`, `HopdongController` |
| **Models** | Tiếng Việt (PascalCase, số ít) | `Sinhvien`, `Phong`, `Hopdong`, `Dangky` |
| **Services** | Tiếng Việt + `Service` | `DangkyService`, `HopdongService` |
| **Interfaces** | Tiếng Việt + `ServiceInterface` | `DangkyServiceInterface`, `HopdongServiceInterface` |
| **Form Requests** | Tiếng Việt + `Request` | `LuuHopdongRequest`, `DuyetDangkyRequest` |
| **Observers** | Tiếng Việt + `Observer` | `SinhvienObserver`, `HopdongObserver` |
| **Traits** | Tiếng Việt PascalCase | `HoTroNghiepVu`, `PhanHoiService` |
| **Enums** | **Tiếng Anh** PascalCase — BẮT BUỘC | `ContractStatus`, `RegistrationType` |
| **Variables/Methods** | Tiếng Việt (camelCase) | `$tuKhoa`, `$danhSachPhong` |
| **Database Tables** | Tiếng Việt (snake_case, số ít) | `sinhvien`, `phong`, `hop_dong` |
| **Views** | kebab-case folders | `admin/sinhvien/danh-sach.blade.php` |

### Cấu trúc thư mục chuẩn

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/
│   │   │   ├── SinhvienController.php
│   │   │   └── HopdongController.php
│   │   └── Guest/
│   │       └── DangkyController.php
│   └── Requests/
│       └── Admin/
│           ├── LuuHopdongRequest.php
│           └── DuyetDangkyRequest.php
├── Models/
│   ├── Sinhvien.php
│   ├── Hopdong.php
│   └── Dangky.php
├── Services/
│   └── Admin/
│       ├── DangkyService.php
│       └── HopdongService.php
├── Contracts/
│   └── Admin/
│       └── DangkyServiceInterface.php
├── Observers/
│   └── SinhvienObserver.php
└── Enums/
    ├── ContractStatus.php
    └── RegistrationType.php
```

---

## Enum Pattern (Bắt buộc)

Dự án dùng **3 tầng** cho mọi Enum — không được bỏ tầng nào:

| Tầng | Quy tắc | Lý do |
|------|---------|-------|
| **Case name** | Tiếng Anh PascalCase | Nhất quán với PHP conventions |
| **Backed value** | English string (snake_case) | Tránh encoding bug khi lưu DB, dùng trong JSON/API |
| **label()** | Tiếng Việt có dấu | Hiển thị giao diện người dùng |

```php
// app/Enums/ContractStatus.php
enum ContractStatus: string
{
    case Active  = 'active';
    case Expired = 'expired';
    case Pending = 'pending';

    public function label(): string
    {
        return match($this) {
            self::Active  => 'Đang hoạt động',
            self::Expired => 'Đã hết hạn',
            self::Pending => 'Chờ xác nhận',
        };
    }
}
```

**Model cast** — bắt buộc khai báo để Laravel tự map:

```php
// Hopdong.php
protected $casts = [
    'trang_thai' => ContractStatus::class,
];
```

**Dùng trong Blade:**

```blade
{{ $hopdong->trang_thai->label() }}
```

**Dùng trong Service/Query — filter bằng Enum, không dùng string thô:**

```php
// ✅ Đúng
$trangThai = ContractStatus::tryFrom($request->query('trangthai', ''));
->when($trangThai, fn($q) => $q->where('trang_thai', $trangThai))

// ❌ Sai — lưu string tiếng Việt vào DB
->where('trang_thai', 'Đang hoạt động')
```

---

## UI & Localization Rules

- **Code DNA:** Models, Variables, DB Tables = Tiếng Việt. Enums = Tiếng Anh (xem Enum Pattern ở trên).
- **Blade templates:** Tiếng Việt có dấu, giọng chuyên nghiệp
- **Styling:** Tailwind utility classes ưu tiên, kết hợp Flowbite components
- **Design tokens:** Xem `.planning/CONTEXT.md` — font Quicksand, màu Indigo

---

## Nếp gấp kiến trúc (Phát hiện từ GitNexus)

> Dành cho AI Agent làm việc

- **Linguistic Strategy:** Dự án dùng mô hình Hybrid có chủ đích — Enums dùng English (lý do kỹ thuật: backed value, encoding), Models/Variables dùng Vietnamese (lý do nghiệp vụ: dễ đọc domain).
- **Duplicate Logic Checks:** Luôn chạy `gitnexus_query("concept")` để tránh tạo Class trùng tên khác ngôn ngữ (vd: `Student` vs `Sinhvien`).

---

## Patterns

- **Validation:** Trong Controller methods hoặc Form Request classes
- **Business Logic:** Dùng Observers — không nhét vào Controller
- **Route Groups:** Nhóm theo middleware role (`admin`, `sinhvien`)
- **Auth Guards:** Middleware `ThanhVienQT` (admin) + `auth` (student)

---

## Known Issues & Technical Debt

| Vấn đề | Mức độ | Ghi chú / Action |
|--------|--------|-----------------|
| Enum naming không nhất quán (`UserRole` vs `LoaiDangKy`) | **Cao** | Audit toàn bộ Enums, chuẩn hóa về English PascalCase + backed value |
| Services/Interfaces tiếng Anh (`RegistrationService`, `ContractService`) | **Cao** | Rename: `DangkyService`, `HopdongService`, `DangkyServiceInterface` |
| Form Requests tiếng Anh (`ApproveRegistrationRequest`, `StoreContractRequest`) | **Cao** | Rename: `DuyetDangkyRequest`, `LuuHopdongRequest` |
| `GuestRegistrationController` không đúng chuẩn | **Trung bình** | Rename thành `DangkyController` trong `Guest/` |
| `Student/Controller.php` không có tên rõ nghĩa | **Trung bình** | Xác định chức năng và đổi tên phù hợp |
| Trùng lặp Observers (`StudentObserver` vs `SinhvienObserver`) | **Cao** | Audit cái nào active, xóa cái còn lại, tránh data loop |
| GitNexus index có thể stale | Thấp | Chạy `npx gitnexus analyze` sau mỗi commit lớn |
| `repomix-output.xml` tracked trong Git | Thấp | Chỉ tạo khi cần, thêm vào `.gitignore` |
| gsd-sdk CLI `MODULE_NOT_FOUND` | Thấp | Agent tự thực thi thủ công GSD protocols |