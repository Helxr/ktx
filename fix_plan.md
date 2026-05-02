# KẾ HOẠCH FIX ĐƯA DỰ ÁN KTX LÊN 100/100

> **PHP 8.1.10 · Laravel 10.50.2**
> Phân loại: 🔴 CRITICAL (gây lỗi runtime) · 🟠 HIGH (lỗi logic/vi phạm TIER 1) · 🟡 MEDIUM (cải thiện chất lượng) · 🟢 LOW (polish)
> Tuân thủ: `WORKFLOW.md` (9 bước) · `HIERARCHY.md` · `STANDARDS.md` · `IMPECCABLE Design System`

---

## PHẦN A — BACKEND (Vi phạm TIER 1: STANDARDS.md + AGENTS.md)

---

### 🔴 A1. BUG: `Hoadon.ALLOWED_TRANSITIONS` dùng TV nhưng `InvoiceStatus` Enum dùng EN

**File:** `app/Models/Hoadon.php:40-51` + `app/Services/Admin/BangDieuKhienService.php:28-30,84-85`

**Vi phạm:** STANDARDS.md §Enum Pattern — *"backed value English string (snake_case)"*, *"filter bằng Enum, không dùng string thô"*

**Lỗi:** `ALLOWED_TRANSITIONS` map bằng `'Chưa thanh toán'`, `'Đã thanh toán'`. Nhưng `InvoiceStatus::Pending->value` = `'pending'`. `transitionTo('paid')` không match → **thanh toán không chuyển trạng thái được**.

Đồng thời `BangDieuKhienService.php` có 6 chỗ dùng string TV thô:
```php
// Dòng 29-30, 84-85:
->where('trangthaithanhtoan', 'Đã thanh toán')   // ❌ String TV
->where('trangthaithanhtoan', 'Chưa thanh toán')  // ❌ String TV
```

**Fix:**
```php
// Hoadon.php — Thống nhất dùng InvoiceStatus Enum values
private const ALLOWED_TRANSITIONS = [
    'pending_confirmation' => ['pending'],
    'pending' => ['paid', 'overdue'],
    'overdue' => ['paid'],
    'paid' => [],
];

// Xóa normalizeState(), trangThaiChuaThanhToan(), trangThaiDaThanhToan()
// — vi phạm STANDARDS.md "không khai báo Enum property trong constant declarations (dùng static methods)"
// Thay bằng:
public function canTransitionTo(string $targetState): bool
{
    $currentState = $this->trangthaithanhtoan;
    return in_array($targetState, self::ALLOWED_TRANSITIONS[$currentState] ?? [], true);
}

// BangDieuKhienService.php — 6 chỗ cần fix:
->where('trangthaithanhtoan', InvoiceStatus::Paid->value)
->where('trangthaithanhtoan', InvoiceStatus::Pending->value)
->where('trangthai', MaintenanceStatus::Pending->value)
```

---

### 🔴 A2. BUG: `MaintenanceStatus` Enum dùng TV làm backed value

**File:** `app/Enums/MaintenanceStatus.php`

**Vi phạm:** STANDARDS.md §Enum Pattern — *"Backed value English string (snake_case). Tránh encoding bug khi lưu DB"*

**Lỗi:** `case PENDING = 'Chờ sửa'` — Tiếng Việt có dấu làm backed value → encoding risk, vi phạm Tier 1.

**Fix:**
```php
enum MaintenanceStatus: string
{
    case Pending    = 'pending';       // was 'Chờ sửa'
    case Scheduled  = 'scheduled';     // was 'Đã hẹn'
    case InProgress = 'in_progress';   // was 'Đang sửa'
    case Completed  = 'completed';     // was 'Đã xong'

    public function label(): string
    {
        return match($this) {
            self::Pending    => 'Chờ sửa',
            self::Scheduled  => 'Đã hẹn',
            self::InProgress => 'Đang sửa',
            self::Completed  => 'Đã xong',
        };
    }
}
```

Kèm migration data update:
```php
DB::table('baohong')->where('trangthai', 'Chờ sửa')->update(['trangthai' => 'pending']);
DB::table('baohong')->where('trangthai', 'Đã hẹn')->update(['trangthai' => 'scheduled']);
DB::table('baohong')->where('trangthai', 'Đang sửa')->update(['trangthai' => 'in_progress']);
DB::table('baohong')->where('trangthai', 'Đã xong')->update(['trangthai' => 'completed']);
```

Cập nhật tất cả references: `BangDieuKhienService.php:28,32`, `TrangThaiBaohongNotification.php:34-36`.

---

### 🔴 A3. BUG: Property không tồn tại `$phong->dang_o` / `$phong->succhua`

**File:** `app/Services/Admin/DangkyService.php:294`

**Lỗi:** `$phong->dang_o >= $phong->succhua` — không phải column/accessor. Column đúng: `dango` + `succhuamax`.

**Fix:**
```php
if ($phong->dango >= $phong->succhuamax) {
    return $this->traVeLoi('Phòng đã đầy.');
}
```

---

### 🟠 A4. Thiếu Enum Cast — vi phạm STANDARDS.md §Model cast

**Files:** `Hopdong.php`, `Hoadon.php`, `Dangky.php`, `Baohong.php`, `Kyluat.php`

**Vi phạm:** STANDARDS.md — *"Model cast — bắt buộc khai báo để Laravel tự map"*

**Lỗi:** Không cast Enum → `$hopdong->trang_thai` trả string thô thay vì Enum object → không gọi được `->label()` trong Blade, mất type safety.

**Fix:**
```php
// Hopdong.php
protected $casts = ['trang_thai' => ContractStatus::class];

// Hoadon.php  
protected $casts = ['trangthaithanhtoan' => InvoiceStatus::class, 'calculation_details' => 'array'];

// Dangky.php
protected $casts = ['trangthai' => RegistrationStatus::class, 'loaidangky' => RegistrationType::class, 'expires_at' => 'datetime'];

// Baohong.php
protected $casts = ['trangthai' => MaintenanceStatus::class, 'do_sinh_vien_gay_ra' => 'boolean'];

// Kyluat.php
protected $casts = ['muc_do' => DisciplineLevel::class];
```

**Lưu ý:** Sau khi cast, các comparisons cần đổi:
```php
// TRƯỚC: $model->trang_thai === ContractStatus::Active->value
// SAU:   $model->trang_thai === ContractStatus::Active
```

---

### 🟠 A5. `UserRole` Enum lỗi thời — 3 roles vs thực tế 6 roles

**File:** `app/Enums/UserRole.php` + `app/Models/User.php`

**Vi phạm:** STANDARDS.md §Enum Pattern — Enum tồn tại nhưng KHÔNG BAO GIỜ được import.

**Fix:** Cập nhật Enum cho khớp thực tế, xóa `ROLE_*` constants trong `User.php`:
```php
enum UserRole: string
{
    case Admin       = 'admin';
    case AdminTruong = 'admin_truong';
    case AdminToaNha = 'admin_toanha';
    case LeTan       = 'le_tan';
    case SinhVien    = 'sinhvien';
    case CuuSinhVien = 'cuu_sinhvien';

    public function label(): string { return match($this) { ... }; }
    
    public function isAdminGroup(): bool
    {
        return in_array($this, [self::Admin, self::AdminTruong, self::AdminToaNha, self::LeTan]);
    }
}
```

Và cast trong `User.php`:
```php
protected $casts = ['vaitro' => UserRole::class];
```

---

### 🟠 A6. `soluongtoida` vs `succhuamax` — 2 columns cùng ý nghĩa

**File:** `app/Http/Requests/Admin/LuuPhongRequest.php:20-21`

**Lỗi:** `'succhuamax' => ['same:soluongtoida']` — validate 2 fields giống nhau = redundant.

**Fix:** Tạo migration xóa `soluongtoida`, giữ `succhuamax` (dùng khắp nơi trong Services).

---

### 🟠 A7. `SinhvienService` method names English — vi phạm STANDARDS.md

**File:** `app/Services/Shared/SinhvienService.php`

**Vi phạm:** STANDARDS.md — *"Variables/Methods: Tiếng Việt (camelCase)"*

**Fix:**
```
listStudents()             → lietKeSinhVien()
updateStudent()            → capNhatSinhVien()
assignRoom()               → xepPhong()
removeFromRoom()           → choRoiPhong()
terminateActiveContracts() → chamDutHopDongHienTai()
```
Cập nhật Interface + Controller tương ứng.

---

### 🟠 A8. `DangkyService` 450 dòng — vi phạm SRP

**Vi phạm:** AGENTS.md §Check-Gate — *"Controller có vượt quá 8 methods? → DỪNG, chuyển logic sang Service"* — tương tự Service quá lớn.

**Fix:** Tách thành 3 Services < 200 dòng mỗi cái:
```
DangkyService         → luuDangKySinhVien(), yeuCauTraPhong(), yeuCauDoiPhong()
DangkyKhachService    → luuDangkyKhach(), layDuLieuFormDangKyKhach(), layDuLieuTraCuuKhach()
DuyetDangkyService    → duyetDangKy(), tuChoiDangKy(), duyetHoSo(), xacNhanThanhToan()
```

---

### 🟠 A9. N+1 Query: `BangDieuKhienService.demPhongConTrong()`

**File:** `app/Services/Admin/BangDieuKhienService.php:76`

**Vi phạm:** AGENTS.md §Check-Gate Check 4 — *"Có N+1 Query? → DỪNG. Dùng eager loading"*

**Lỗi:** `Phong::all()->filter(fn($p) => Sinhvien::where('phong_id', $p->id)->count() < ...)` — 100 phòng = 101 queries.

**Fix:**
```php
private function demPhongConTrong(): int
{
    return Phong::whereColumn('dango', '<', 'succhuamax')->count();
}
```

---

### 🟠 A10. N+1 Queries: `layXuHuongDoanhThu()` — 18 queries trong loop

**File:** `app/Services/Admin/BangDieuKhienService.php:79-88`

**Fix:** 1 query duy nhất:
```php
$doanhThu = Hoadon::where('trangthaithanhtoan', InvoiceStatus::Paid->value)
    ->where('created_at', '>=', now()->subMonths(5)->startOfMonth())
    ->selectRaw('thang, nam, SUM(tienphong) as tienphong, SUM(tiendien + tiennuoc) as tiendichvu')
    ->groupBy('thang', 'nam')
    ->orderBy('nam')->orderBy('thang')
    ->get();
```

---

### 🟠 A11. Tạo User random password mà KHÔNG gửi cho sinh viên

**File:** `app/Services/Admin/DangkyService.php:374`

**Lỗi:** `bcrypt(Str::random(12))` — tạo mật khẩu random, user không thể đăng nhập.

**Fix:** Gửi email welcome kèm magic link đổi mật khẩu (đã có `MagicLinkController`):
```php
$matKhauTam = Str::random(12);
$user = User::create([... 'password' => bcrypt($matKhauTam) ...]);
Mail::to($user->email)->queue(new WelcomeMail($user, $matKhauTam));
```

---

### 🟡 A12. `HoadonService.xuLyHoaDon()` — thiếu validate chỉ số mới >= cũ

**File:** `app/Services/Admin/HoadonService.php:92-122`

**Vi phạm:** CLAUDE.md Lessons Learned 2026-04-24 — *"Refactor InvoiceService với defensive checks (kiểm tra chỉ số mới >= cũ)"* (nhưng chưa áp dụng).

**Fix:**
```php
'chisodienmoi' => ['required', 'numeric', 'min:0', 'gte:chisodiencu'],
'chisonuocmoi' => ['required', 'numeric', 'min:0', 'gte:chisonuoccu'],
```

---

### 🟡 A13. `HoadonController@downloadInvoicePDF` — method trống

**File:** `app/Http/Controllers/Admin/HoadonController.php:43-48`

**Lỗi:** Method body chỉ có comment → route gọi sẽ lỗi 500.

**Fix:** Implement bằng `laravel-dompdf` hoặc xóa route nếu chưa cần.

---

### 🟡 A14. Expose exception message cho end-user

**Vi phạm:** VIBE_SYSTEM.md §Security — defensive programming.

**Fix:**
```php
catch (\Throwable $e) {
    Log::error("Lỗi duyệt đăng ký", ['error' => $e->getMessage()]);
    return $this->traVeLoi('Có lỗi xảy ra. Vui lòng thử lại sau.');
}
```

---

### 🟡 A15. Thiếu Database Indexes cho các cột thường query

```php
Schema::table('hoadon', fn(Blueprint $t) => $t->index(['phong_id', 'thang', 'nam']));
Schema::table('hoadon', fn(Blueprint $t) => $t->index('trangthaithanhtoan'));
Schema::table('hopdong', fn(Blueprint $t) => $t->index(['sinhvien_id', 'trang_thai']));
Schema::table('dangky', fn(Blueprint $t) => $t->index('lookup_token'));
Schema::table('sinhvien', fn(Blueprint $t) => $t->index('phong_id'));
```

---

### 🟡 A16. 47 migration files → nên squash

```bash
php artisan schema:dump --prune
```

---

### 🟢 A17. DB column naming không nhất quán (thiếu underscore)

| Hiện tại | Đề xuất |
|----------|---------|
| `trangthaithanhtoan` | `trang_thai_thanh_toan` |
| `chisodiencu` | `chi_so_dien_cu` |
| `tongtien` | `tong_tien` |
| `ngayxuat` | `ngay_xuat` |

Đòi hỏi migration rename + update fillable/queries toàn bộ. Ưu tiên thấp.

---

### 🟢 A18. `soluongtoida` vs `succhuamax` vs `dango` — thiếu document

Giữ `succhuamax` + `dango`, xóa `soluongtoida` bằng migration.

---

## PHẦN B — FRONTEND & UI (Vi phạm IMPECCABLE Design System)

---

### 🔴 B1. `border-left: 4px solid` — IMPECCABLE BAN #1 (AI Slop Tell)

**Files:**
- `resources/views/emails/dangky-khach-thanh-cong.blade.php:19,25` → `border-left: 4px solid #00A86B`
- `resources/views/admin/congno/danhsach.blade.php:20,24` → `border-l-4 border-l-amber-500` / `border-l-4 border-l-rose-500`

**Vi phạm:** IMPECCABLE SKILL.md §absolute_bans — *"BAN 1: Side-stripe borders... NEVER acceptable. The single most overused AI design tell."*

**Fix:** Thay bằng background tint hoặc full border:
```blade
{{-- TRƯỚC (AI slop): --}}
<article class="border-l-4 border-l-amber-500 ...">

{{-- SAU (IMPECCABLE): --}}
<article class="bg-status-warning/5 ring-1 ring-status-warning/20 ...">
```

---

### 🟠 B2. Font DM Sans trong admin layout — reflex font (IMPECCABLE ban)

**File:** `resources/views/layouts/admin.blade.php:10` + `resources/css/app.css:50`

**Vi phạm:** IMPECCABLE SKILL.md §reflex_fonts_to_reject — *"DM Sans... Reject every font that appears in the reflex_fonts_to_reject list."*

**Hiện tại:**
```html
<!-- admin.blade.php -->
<link href="...family=Geist+Sans:wght@100..900&family=DM+Sans:wght@100..900&display=swap">
```
```css
/* app.css */
body { font-family: 'DM Sans', system-ui, sans-serif; }
```

**Mâu thuẫn:** `tailwind.config.js` khai báo font `Onest` (sans) + `Bricolage Grotesque` (display), nhưng `app.css` override bằng DM Sans và Quicksand. → 4 font families xung đột.

**Fix:** Thống nhất theo 1 stack duy nhất:
```
Body: Quicksand (đã dùng cho headings, landing, student layout — nhất quán)
Display: Quicksand weight 800 (đã có trong app.css)
Fallback: system-ui
```
Hoặc nếu muốn phân biệt body vs display:
```
Body: Geist Sans (product app)
Display: Quicksand (brand/headings)
```
**Bắt buộc:** Xóa DM Sans khỏi imports và CSS. Cập nhật `tailwind.config.js` cho khớp.

---

### 🟠 B3. Logic nặng trong Blade — vi phạm MVC + VIBE_SYSTEM.md

**Files:**
- `admin/trangchu.blade.php:4-43` → 43 dòng PHP (tính KPI, chart, tower data)
- `student/trangchu.blade.php:6-29` → 28 dòng PHP (tính ngày còn lại, thành viên)

**Vi phạm:** VIBE_SYSTEM.md §2 — *"MVC Strictness: No DB queries in Blade. Business logic in Services/Observers"*

**Fix:** Chuyển vào `BangDieuKhienService`:
```php
// Service trả về data đã tính sẵn
return [
    'tyLeLapDay' => $this->tinhTyLeLapDay(),
    'congSuatTheoToa' => $this->layCongSuatTheoToa(),
    'xuHuongDoanhThu' => $this->layXuHuongDoanhThuFormatted(),
];
```

---

### 🟠 B4. Hardcode dữ liệu giả trong Dashboard

**File:** `resources/views/admin/trangchu.blade.php:26-29`

**Lỗi:**
```php
$congSuatTheoToa = collect([
    ['toa' => 'Tòa A', 'value' => min(100, max(0, $tyLeLapDay + 8))],
    ['toa' => 'Tòa B', 'value' => min(100, max(0, $tyLeLapDay + 3))],
]);
```
Dữ liệu tòa nhà fake (offset ±8, ±3, ±2...).

**Fix:** Query từ DB:
```php
Phong::selectRaw("toa, SUM(dango) as tong_sv, SUM(succhuamax) as tong_cho")
    ->groupBy('toa')
    ->get()
    ->map(fn($r) => ['toa' => $r->toa, 'value' => round(($r->tong_sv / max(1, $r->tong_cho)) * 100)]);
```

---

### 🟠 B5. `tailwind.config.js` font ≠ CSS font ≠ Google Fonts import

**Mâu thuẫn hiện tại:**
| Source | Sans | Display |
|--------|------|---------|
| `tailwind.config.js` | Onest | Bricolage Grotesque |
| `app.css` body | DM Sans ❌ banned | — |
| `app.css` headings | Quicksand | Quicksand |
| `admin.blade.php` import | Geist Sans + DM Sans ❌ | — |
| `student/chinh.blade.php` import | Geist Sans + Quicksand | — |
| `landing.blade.php` import | Quicksand | — |

**Fix:** Pick ONE consistent stack, update all 4 sources to match:
1. `tailwind.config.js` — set actual fonts used
2. `app.css` — remove DM Sans, align with config
3. Layout Blade files — import matching Google Fonts
4. `.impeccable.md` — document chosen fonts as design context

---

### 🟡 B6. `#fff` trong email templates

**Files:** `emails/magic-link.blade.php:8`, `emails/payment-request.blade.php:9`

**Vi phạm:** IMPECCABLE §color_rules — *"DO NOT use pure black (#000) or pure white (#fff)"*

**Lỗi:** `color: #fff` trong inline styles. Email templates là đặc biệt (OKLCH không được support trong email clients), nên đây là LOW priority. Thay bằng `color: #fafaf9` (warm white).

---

### 🟡 B7. Landing page 598 dòng — thiếu partials

**File:** `resources/views/landing/index.blade.php`

**Fix:** Tách:
```
landing/partials/hero.blade.php
landing/partials/features.blade.php
landing/partials/rooms.blade.php
landing/partials/contact.blade.php
landing/partials/faq.blade.php
```

---

### 🟡 B8. `student/phongcuatoi/index.blade.php` — 401 dòng

**Fix:** Tách partials tương tự B7.

---

### 🟡 B9. Mobile bottom nav labels English

**File:** `resources/views/layouts/admin.blade.php:75-82`

**Vi phạm:** STANDARDS.md §UI — *"Blade templates: Tiếng Việt có dấu, giọng chuyên nghiệp"*

**Fix:** "Home" → "Trang chủ", "Bills" → "Hóa đơn", etc.

---

### 🟡 B10. Tầng phòng hardcode (1-3)

**File:** `resources/views/admin/phong/danhsach.blade.php:21`

**Fix:** Lấy danh sách tầng từ DB: `Phong::select('tang')->distinct()->orderBy('tang')->pluck('tang')`

---

### 🟡 B11. Thiếu `.impeccable.md` — Design Context chưa tồn tại

**Vi phạm:** IMPECCABLE SKILL.md §Context Gathering Protocol — *"CRITICAL: You cannot infer this context by reading the codebase."*

**Fix:** Tạo `.impeccable.md` tại project root:
```markdown
# Design Context — KTX Management System

## Target Audience
- Admin: Nhân viên quản lý KTX (20-40 tuổi), sử dụng trên desktop
- Sinh viên: 18-25 tuổi, sử dụng trên mobile lẫn desktop

## Use Cases
- Admin: Quản lý phòng, duyệt đăng ký, xuất hóa đơn, theo dõi báo hỏng
- Sinh viên: Xem thông tin phòng, thanh toán hóa đơn, tra cứu đăng ký

## Brand Personality
- Tone: Chuyên nghiệp, thân thiện, đáng tin cậy
- 3 từ: "structured", "approachable", "trustworthy"
- Theme: Light (product is used during work/school hours)
- Primary color: Brand Emerald (OKLCH)

## Fonts
- Body: [chọn 1 consistent — Quicksand hoặc Geist Sans]
- Display: Quicksand weight 800

## Color System
- OKLCH CSS custom properties
- Brand: Emerald + Jade
- Neutrals: Tinted toward emerald hue
```

---

### 🟢 B12. Toast notification không auto-dismiss

**Fix:** `setTimeout(() => el.remove(), 5000)` + fade-out animation.

---

## PHẦN C — UX / TRẢI NGHIỆM NGƯỜI DÙNG (Vi phạm IMPECCABLE Interaction Design)

---

### 🟠 C1. Guest Registration không có Rate Limiting

**Vi phạm:** VIBE_SYSTEM.md §Security — Defensive Programming.

**Fix:**
```php
Route::post('/dang-ky-ktx', ...)->middleware('throttle:5,1'); // 5 requests/phút
Route::get('/tra-cuu', ...)->middleware('throttle:10,1');
```

---

### 🟠 C2. Không có Confirm Modal cho destructive actions

**Vi phạm:** IMPECCABLE §Interaction Design — *"Make every interactive surface feel intentional and responsive"*

**Lỗi:** "Từ chối đăng ký", "Thanh lý hợp đồng", "Cho rời phòng" thực hiện ngay khi click.

**Fix:** Blade `<x-confirmation-modal>` cho tất cả destructive actions.

---

### 🟠 C3. Không có loading state cho form submissions

**Vi phạm:** IMPECCABLE §Interaction Design — *"Use optimistic UI: update immediately, sync later"*

**Fix:** Disable button + spinner khi submit. Chống double-click.

---

### 🟡 C4. Empty states chưa "teach" — chỉ nói "không có gì"

**Vi phạm:** IMPECCABLE §Interaction Design — *"Design empty states that teach the interface, not just say 'nothing here'"*

**Hiện tại:** `student/phongcuatoi/index.blade.php` có empty state tốt (gợi ý phòng trống) nhưng nhiều list pages khác chưa có.

**Fix:** Mọi danh sách (hóa đơn, báo hỏng, kỷ luật) cần empty state mô tả + CTA.

---

### 🟡 C5. Thiếu Breadcrumb cho Student portal

**Fix:** Thêm `<x-breadcrumbs />` vào `student/layouts/chinh.blade.php`.

---

### 🟡 C6. Thiếu custom Error pages (404, 500, 403)

**Fix:** `resources/views/errors/{404,500,403}.blade.php` theo design system.

---

### 🟡 C7. Thiếu Pagination info ("1-20 / 150")

**Fix:**
```blade
<div class="text-sm text-ink-secondary">
    Hiển thị {{ $ds->firstItem() }}–{{ $ds->lastItem() }} / {{ $ds->total() }} kết quả
</div>
```

---

### 🟢 C8. Contact phone hardcode

**Fix:** Lấy từ bảng `cauhinh`.

---

### 🟢 C9. Accessibility — Missing ARIA labels trên SVG icons

**Vi phạm:** IMPECCABLE Audit §A11y — *"Missing ARIA: Interactive elements without proper roles, labels"*

**Fix:** `<svg aria-hidden="true">` cho decorative, `aria-label` cho interactive.

---

## PHẦN D — SECURITY & PERFORMANCE

---

### 🟠 D1. Authorization quá lỏng cho admin roles

**Lỗi:** Middleware `kiemtravaitro:admin` → TẤT CẢ admin roles (admin, admin_truong, admin_toanha, le_tan) truy cập MỌI admin routes. Lễ tân có thể thanh lý hợp đồng.

**Fix:** Laravel Gate/Policy chi tiết:
```php
Gate::define('hopdong.thanhly', fn(User $u) => in_array($u->vaitro, ['admin', 'admin_truong']));
Gate::define('phong.xoa', fn(User $u) => $u->vaitro === 'admin');
```

---

### 🟠 D2. File upload `nullable` cho ảnh nhạy cảm

**File:** `app/Http/Requests/Guest/LuuDangkyRequest.php:23-24`

**Lỗi:** `'anh_the' => ['nullable', 'image', 'max:4096']` — guest có thể đăng ký mà không upload ảnh.

**Fix:** `'anh_the' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:4096']`

---

### 🟡 D3. `Phong::all()` trong Services — load toàn bộ vào memory

**Fix:** `Phong::select('id', 'tenphong', 'tang', 'toa')->get()` hoặc cache 5 phút.

---

### 🟡 D4. `lookup_token` không có expiry

**Fix:** Thêm `expires_at` khi tạo, check khi tra cứu:
```php
Dangky::where('lookup_token', $token)->where('expires_at', '>', now())->first();
```

---

### 🟡 D5. Dual source of truth cho Room Occupancy

**Lỗi:** Observer sync `dango`, nhưng `DangkyService:55,179`, `SinhvienService:69`, `BangDieuKhienService:76` vẫn dùng `Sinhvien::where('phong_id', ...)->count()`.

**Fix:** Quy tắc cứng: **Luôn dùng `$phong->dango`** (cached column). Xóa tất cả live count ngoài Observer.

---

## PHẦN E — TESTING & DEVOPS

---

### 🔴 E1. Gần như không có Business Logic Tests

**Hiện tại:** Architecture tests (4), 1 contract test, 1 observer test, 1 blind index test, auth defaults.

**Thiếu hoàn toàn tests cho:**
- `DangkyService` (registration flow — critical path)
- `HoadonService` (invoice calculation — financial)
- State Machine transitions (Hoadon, Hopdong, Dangky)
- Guest registration flow
- Room capacity validation
- Authorization (role-based access)

**Fix — Priority order:**
```
P1 — Financial/State:
├── HoadonServiceTest (tính tiền, negative meter reading rejection)
├── HopdongStateMachineTest (all transitions, invalid rejected)
└── DangkyStateMachineTest (pending → approved → completed)

P2 — Critical Business:
├── DangkyServiceTest (student reg, guest reg, approve, reject)
├── RoomCapacityTest (không vượt succhuamax)
└── GenderValidationTest (không xếp sai giới tính)

P3 — Security:
├── AuthorizationTest (role-based route access)
├── EncryptionTest (PII encrypted, decrypted correctly)
└── GuestRateLimitTest (throttle works)
```

---

### 🟠 E2. Thiếu CI/CD Pipeline

**Fix:** `.github/workflows/ci.yml`:
```yaml
name: CI
on: [push, pull_request]
jobs:
  tests:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v4
      - uses: shivammathur/setup-php@v2
        with: { php-version: '8.1' }
      - run: composer install --no-interaction
      - run: php artisan test
      - run: ./vendor/bin/pint --test
```

---

### 🟠 E3. Thiếu Code Formatter

**Fix:**
```bash
composer require laravel/pint --dev
```
Tạo `pint.json` với `"preset": "laravel"`.

---

### 🟡 E4. Thiếu Seeder/Factory cho development

**Fix:** Tạo `DevSeeder.php` (admin account, 50 phòng, 200 SV, hóa đơn mẫu).

---

### 🟡 E5. README.md trống

**Fix:** Viết README project-specific (cài đặt, tính năng, tài khoản test, architecture).

---

### 🟡 E6. Thiếu SoftDeletes cho `Dangky`, `Kyluat`, `Baohong`

**Vi phạm:** CLAUDE.md §Core Coding Philosophy — *"LUÔN dùng SoftDeletes cho các bảng quan trọng"*

**Fix:** Migration + `use SoftDeletes` trong Models.

---

## TÓM TẮT ƯU TIÊN

### 🔴 CRITICAL — Fix ngay (4 items)
| # | Lỗi | Impact |
|---|------|--------|
| A1 | Hoadon transitions TV vs EN | Thanh toán không chuyển trạng thái |
| A2 | MaintenanceStatus backed value TV | Encoding risk + vi phạm Tier 1 |
| A3 | Property `dang_o`/`succhua` không tồn tại | Runtime error |
| B1 | `border-left: 4px solid` AI slop | IMPECCABLE BAN #1 |

### 🟠 HIGH — Sớm (19 items)
A4-A11, B2-B5, C1-C3, D1-D2, D5, E1-E3

### 🟡 MEDIUM — Cải thiện (16 items)
A12-A16, B6-B11, C4-C7, D3-D4, E4-E6

### 🟢 LOW — Polish (5 items)
A17-A18, B12, C8-C9

---

**Tổng: 44 items cần fix để đạt 100/100**

### Thứ tự fix đề xuất (theo WORKFLOW.md 9 bước)

```
Wave 1 — Foundation (Backend consistency):
  A1 + A2 + A3 (BUGs)
  A4 (Enum casts)
  A5 (UserRole sync)
  → Chạy Architecture Test sau mỗi wave

Wave 2 — Backend quality:
  A7 (naming convention)
  A8 (SRP — tách DangkyService)
  A9 + A10 (N+1 queries)
  A11 (user password email)
  A12 (meter validation)

Wave 3 — Security:
  C1 (rate limiting)
  D1 (authorization gates)
  D2 (file upload required)
  D4 (token expiry)
  D5 (occupancy source of truth)

Wave 4 — Frontend IMPECCABLE:
  B1 (ban border-left)
  B2 (font consistency)
  B3 + B4 (logic out of Blade)
  B5 (font stack unification)
  B11 (.impeccable.md)

Wave 5 — UX & Polish:
  C2-C7 (modals, loading, empty states, breadcrumbs)
  B7-B10 (partials, translations)

Wave 6 — Testing & DevOps:
  E1 (business logic tests)
  E2 (CI/CD)
  E3-E6 (tooling)
```
