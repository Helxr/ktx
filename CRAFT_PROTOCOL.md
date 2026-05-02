# CRAFT_PROTOCOL.md
## Tuyên ngôn thực thi Impeccable cho KTX

> **Version**: 1.0  
> **Date**: 2026-04-29  
> **Scope**: Refactor UI toàn bộ resources/views/ theo bộ nhận diện Phương Đông (Emerald & Moonlit)

---

## 1. Kiến trúc Blade Components

### 1.1 Wrapper Pattern cho Impeccable

Mỗi component phải bọc logic trong cấu trúc sau:

```blade
{{-- Component: x-card-room.blade.php --}}
@props(['phong', 'available' => true])

<article 
    class="room-card group relative flex flex-col rounded-2xl bg-ktx-surface p-6 
           border border-ktx-glass-border shadow-sm 
           transition-all duration-300 ease-out
           hover:shadow-lg hover:-translate-y-1"
    data-gender="{{ $phong->gioitinh }}"
    data-available="{{ $available ? 'available' : 'full' }}">
    
    {{-- Header: Typography hierarchy --}}
    <header class="mb-4">
        <h3 class="font-display text-lg font-bold text-ktx-text-primary 
                   tracking-tight leading-tight">
            {{ $phong->tenphong }}
        </h3>
        <p class="text-xs font-medium text-ktx-text-secondary mt-1">
            Tầng {{ $phong->tang }} · {{ $phong->gioitinh }}
        </p>
    </header>
    
    {{-- Content: Semantic structure --}}
    <div class="flex-grow space-y-4">
        {{ $slot }}
    </div>
    
    {{-- Footer: Action zone --}}
    <footer class="mt-4 pt-4 border-t border-ktx-glass-border">
        {{ $footer ?? '' }}
    </footer>
</article>
```

### 1.2 Design Token Mapping trong Blade

| Blade Component | Impeccable Token | CSS Variable |
|-----------------|------------------|--------------|
| `x-card` | Surface elevated | `--ktx-surface-elevated` |
| `x-button-primary` | Primary emerald | `--ktx-primary` |
| `x-badge` | Moonlit accent | `--ktx-moonlit` |
| `x-text-heading` | Ink jade | `--ktx-text-primary` |
| `x-text-body` | Sage muted | `--ktx-text-secondary` |
| `x-glass-panel` | Frosted jade | `--ktx-glass-bg` |

---

## 2. Bảo vệ "Sợi chỉ đỏ" (Red Thread)

### 2.1 Nguyên tắc bất biến

**Sợi chỉ đỏ** = Chuỗi consistency từ Design Tokens → CSS → Blade → Browser

```
DESIGN_TOKENS.md (Source of Truth)
         ↓
   app.css (CSS Variables)
         ↓
   Blade Components (x-*.blade.php)
         ↓
   Browser Render (OKLCH colors)
```

### 2.2 Cách bảo vệ khi thay đổi CSS

#### Không được phép:
```css
/* ❌ Hardcode màu không qua tokens */
.room-card {
    background: #ffffff;
    color: #333333;
}

/* ❌ Purple gradient (AI Slop #1) */
.hero {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

/* ❌ Pure black/white */
.text-primary {
    color: #000000;
}
```

#### Được phép:
```css
/* ✅ Dùng tokens OKLCH */
.room-card {
    background: var(--ktx-surface);
    color: var(--ktx-text-primary);
}

/* ✅ Emerald gradient theo Phương Đông */
.hero {
    background: linear-gradient(
        135deg, 
        oklch(60% 0.18 155) 0%, 
        oklch(45% 0.20 155) 50%, 
        oklch(30% 0.12 250) 100%
    );
}

/* ✅ Tinted neutrals */
.text-primary {
    color: oklch(20% 0.03 155); /* Ink jade */
}
```

### 2.3 Checklist trước khi sửa CSS

- [ ] Màu có phải OKLCH không? (Không phải hex #xxx)
- [ ] Có dùng `--ktx-*` variables không?
- [ ] Text có tinted toward emerald (hue 155) không?
- [ ] Không có purple gradient?
- [ ] Không có pure black (#000) hoặc pure white (#fff)?

---

## 3. Impeccable Commands Workflow

### 3.1 Luồng chuẩn cho mỗi trang

```bash
# Bước 1: Teach (one-time)
/impeccable teach
→ Output: PRODUCT.md, DESIGN.md

# Bước 2: Audit hiện trạng  
/audit resources/views/landing/phong/danhsach.blade.php
→ Output: Anti-patterns report

# Bước 3: Baseline detector
npx impeccable detect resources/views/landing/phong/
→ Output: Detector report (P0/P1/P2 issues)

# Bước 4: Typeset (Typography)
/typeset resources/views/landing/phong/danhsach.blade.php
→ Fix: font-display, text-ink-primary hierarchy

# Bước 5: Colorize (Emerald & Moonlit)
/colorize resources/views/landing/phong/danhsach.blade.php
→ Fix: Apply OKLCH tokens, remove purple/indigo

# Bước 6: Layout  
/layout resources/views/landing/phong/danhsach.blade.php
→ Fix: spacing, grid, visual rhythm

# Bước 7: Normalize
/normalize resources/views/landing/phong/
→ Fix: align với design system

# Bước 8: Polish
/polish resources/views/landing/phong/danhsach.blade.php
→ Final pass, shipping readiness
```

### 3.2 18 Lệnh Impeccable & Khi nào dùng

| Command | KTX Use Case | Priority |
|---------|--------------|----------|
| `/impeccable teach` | Setup dự án KTX lần đầu | P0 |
| `/impeccable craft` | Xây trang mới (landing page) | P0 |
| `/audit` | Kiểm tra trang trước khi sửa | P0 |
| `/typeset` | Fix font Bricolage/Geist | P1 |
| `/colorize` | Chuyển sang Emerald & Moonlit | P0 |
| `/layout` | Fix grid system, spacing | P1 |
| `/normalize` | Apply design tokens | P1 |
| `/polish` | Final trước release | P0 |
| `/critique` | UX review trang phức tạp | P2 |
| `/animate` | Thêm micro-interactions | P2 |
| `/distill` | Simplify over-designed UI | P2 |
| `/harden` | Error handling, edge cases | P2 |
| `/optimize` | Performance pass | P3 |
| `/adapt` | Responsive adjustments | P2 |
| `/bolder/quieter` | Visual weight tuning | P3 |
| `/delight` | Joy moments (optional) | P3 |
| `/clarify` | UX copy improvement | P3 |
| `/overdrive` | Special effects (careful) | P3 |

---

## 4. Anti-patterns Checklist

### 4.1 P0 - KHÔNG BAO GIỜ

| Anti-pattern | File | Fix |
|--------------|------|-----|
| Inter font | All | Quicksand (landing) / Geist Sans (admin) |
| Purple gradient | landing/* | Emerald-to-Moonlit gradient |
| Pure #000/#fff | All | oklch(20% 0.03 155) / oklch(98% 0.01 155) |
| Side-tab borders | navigation.blade.php | Ring utility instead |
| Nested cards | components/card.blade.php | Flatten to single level |
| Bounce easing | app.css | ease-out or custom cubic-bezier |

### 4.2 P1 - Cần Fix

| Anti-pattern | File | Fix |
|--------------|------|-----|
| Inline styles | danhsach.blade.php:37 | class-based visibility |
| Hardcoded animation | danhsach.blade.php:106 | CSS keyframes in tokens |
| Missing semantic HTML | danhsach.blade.php:27 | `<ul>/<li>` for list |

---

## 5. Implementation Tracker

### Phase 1: Setup (Completed ✅)
- [x] Bước 1: Học 18 lệnh Impeccable
- [x] Bước 2: Cài đặt Design Tokens (Emerald & Moonlit)
- [x] Bước 3: Audit landing/phong/danhsach.blade.php
- [x] Bước 4: Xuất CRAFT_PROTOCOL.md

### Phase 2: Layouts (Next)
- [ ] /audit resources/views/layouts/admin.blade.php
- [ ] /audit resources/views/layouts/landing.blade.php
- [ ] /typeset layouts (fix font hierarchy)
- [ ] /colorize layouts (apply OKLCH)

### Phase 3: Components
- [ ] /audit resources/views/components/
- [ ] Extract reusable components
- [ ] Normalize with design tokens

### Phase 4: Views
- [ ] /audit từng view theo danh sách
- [ ] /typeset → /colorize → /layout → /polish

### Phase 5: Verification
- [ ] npx impeccable detect resources/views/ (zero P0/P1)
- [ ] Manual QA: 3 browsers
- [ ] Accessibility check

---

## 6. Emergency Protocols

### Khi "Sợi chỉ đỏ" bị đứt:

1. **Stop** - Không commit thêm
2. **Revert** - `git checkout` về commit trước khi đứt
3. **Audit** - `/audit` để tìm nguyên nhân
4. **Fix** - Chạy lại từ `/typeset` → `/polish`
5. **Verify** - `npx impeccable detect` pass
6. **Resume** - Tiếp tục workflow

### Hotfix cho anti-pattern:

```bash
# Fix nhanh 1 anti-pattern
/impeccable craft --fix "Remove purple gradient from hero" resources/views/landing/index.blade.php
```

---

## 7. Success Criteria

- ✅ Zero P0 anti-patterns detected
- ✅ All colors use OKLCH with hue 155 (emerald) or 250 (moonlit)
- ✅ Typography: Quicksand (landing), Geist Sans (admin)
- ✅ No inline styles in Blade templates
- ✅ Semantic HTML structure
- ✅ Design tokens 100% consistent

---

**Ready to craft. 🎨**
