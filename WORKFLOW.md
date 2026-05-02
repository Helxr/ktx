# WORKFLOW.md v2.1 — Đường Ray Bắt Buộc
> **Phân cấp:** TIER 1 — Mọi AI Agent BẮT BUỘC tuân thủ tuyệt đối.
> **Compatible:** Antigravity CLI · Windsurf · VS Code Codex · Claude Code
> **Nguồn tích hợp:** HIERARCHY.md · AGENTS.md · CLAUDE.md · VIBE_SYSTEM.md · .cursorrules · Karpathy Guidelines · GitNexus Skills · GSD Framework · **IMPECCABLE Design System**

---

## ⚠️ QUY TẮC SỐ 0 — KHÔNG CÓ ĐƯỜNG TẮT

```
TUYỆT ĐỐI CẤM nhảy thẳng từ Prompt → Code.
Mọi thay đổi, dù 1 dòng, đều phải đi qua đủ 9 bước.
Không có ngoại lệ trừ [EMERGENCY BYPASS] có lý do rõ ràng.
```

---

## 🔄 KHỞI ĐỘNG PHIÊN LÀM VIỆC (Cross-CLI Init)
> Áp dụng khi: Bắt đầu session mới HOẶC switch giữa Anti / Windsurf / Codex
> Nguồn: `VIBE_SYSTEM.md` Section 7

```
[CROSS-CLI INIT]
1. Đọc VIBE_SYSTEM.md   → Nạp cấu hình hệ thống & Vault Protocol
2. Đọc STANDARDS.md     → Nạp quy tắc naming Việt/Anh
3. Đọc STATE.md         → Hiểu phase hiện tại của dự án
4. Check GitNexus index → gitnexus://repo/hethongquanlyktx/context
   → Nếu index stale: chạy `npx gitnexus analyze` trước khi làm bất cứ điều gì
```

---

## BƯỚC 1 — XÁC ĐỊNH QUYỀN LỰC
> 🔍 Đọc: `HIERARCHY.md`

**AI BẮT BUỘC in ra:**
```
[TIER CHECK]
Tier áp dụng: [1 / 2 / 3]
Xung đột phát hiện: [Có → mô tả / Không]
Phán quyết: Tier 1 thắng. Code cũ vi phạm = Technical Debt.
→ TUYỆT ĐỐI KHÔNG copy pattern từ legacy code chưa qua Tier Check.
```

---

## BƯỚC 2 — GENERATOR (α): PHÂN TÍCH YÊU CẦU
> 🧠 Nguồn: `VIBE_SYSTEM.md` Recursive Self-Optimization + Karpathy "Think Before Coding"

**AI BẮT BUỘC in ra trước khi làm bất cứ điều gì:**
```
[GENERATOR α]
Yêu cầu gốc: "[nguyên văn prompt của user]"

Assumptions (giả định tường minh):
  - [assumption 1]
  - [assumption 2]

Interpretations (nếu có nhiều cách hiểu):
  - Cách A: [mô tả]
  - Cách B: [mô tả]
  → Tôi chọn: [A/B] vì [lý do]

Loại tác vụ: [Backend / Frontend / Full-stack / Refactor / Fix bug]
  → Nếu có Frontend: BẮT BUỘC chạy IMPECCABLE UI CHECK-GATE tại Bước 6.

Nếu KHÔNG chắc → DỪNG và hỏi user. Không đoán mò.
```

---

## BƯỚC 3 — IMPECCABLE CHECK-GATE (Backend Architecture)
> 🛡️ Đọc: `AGENTS.md`, `STANDARDS.md`
> Nguồn: `.cursorrules` Section 4.5 + CLAUDE.md Lessons Learned

**AI BẮT BUỘC in ra bảng đầy đủ. KHÔNG được bỏ qua:**

```
════════════════════════════════════════════
[IMPECCABLE CHECK-GATE — BACKEND]
════════════════════════════════════════════
□ 1. Controller có vượt 8 methods không?
     → CÓ: DỪNG. Tách sang Service.

□ 2. Logic có Interface để DI chưa?
     → CHƯA: DỪNG. Tạo Interface trước.

□ 3. Có gọi Model trực tiếp trong Controller?
     → CÓ: DỪNG. Phải qua Service layer.

□ 4. Có N+1 Query không?
     → CÓ: DỪNG. Dùng eager loading.

□ 5. Có vi phạm naming convention (STANDARDS.md)?
     → CÓ: DỪNG. Sửa tên theo chuẩn Việt/Anh.

□ 6. Có đụng đến PII / APP_KEY không?
     → CÓ: DỪNG. Áp dụng Vault Protocol (VIBE_SYSTEM.md Sec.4 & 6).

□ 7. Có thiếu Try-Catch ở critical operation không?
     → CÓ: DỪNG. Thêm defensive programming.

□ 8. Model mới có cần Observer + SoftDeletes không?
     → CÓ mà chưa có: DỪNG. Tạo Observer + đăng ký AppServiceProvider.
════════════════════════════════════════════
Kết quả: [PASS ✅ / FAIL ❌ + lý do + tên file cụ thể]
════════════════════════════════════════════
```

**Nếu FAIL → KHÔNG tiếp tục. Phản hồi bắt buộc:**
> "Vi phạm kiến trúc tại [Class::method]. Đề xuất: tạo [TênInterface] + [TênService] theo pattern hiện tại của dự án."

---

## BƯỚC 4 — PHÂN TÍCH BLAST RADIUS
> 🧠 Tool: `gitnexus_impact` + `gitnexus_context`
> Skill: `.claude/skills/gitnexus/gitnexus-impact-analysis/SKILL.md`

**AI BẮT BUỘC chạy:**
```javascript
gitnexus_impact({ target: "TênSymbol", direction: "upstream" })
gitnexus_detect_changes()
```

**AI BẮT BUỘC in ra:**
```
[BLAST RADIUS REPORT]
Symbol bị ảnh hưởng: [danh sách]
Risk level: [LOW / MEDIUM / HIGH / CRITICAL]
Số file liên quan: [N]
Index freshness: [timestamp]

→ Nếu HIGH/CRITICAL: CẢNH BÁO user, đợi xác nhận trước khi tiếp tục.
→ Nếu index > 24h: DỪNG, chạy `npx gitnexus analyze` trước.
```

**TUYỆT ĐỐI KHÔNG:**
- Sửa symbol mà không chạy `gitnexus_impact` trước
- Bỏ qua cảnh báo HIGH/CRITICAL
- Rename bằng find-and-replace — phải dùng `gitnexus_rename`
- Commit mà không chạy `gitnexus_detect_changes()`

---

## BƯỚC 5 — LẬP KẾ HOẠCH PHẪU THUẬT
> 📝 Đọc: `PROJECT.md`, `STATE.md`, `.planning/REQUIREMENTS.md`
> Nguồn: Karpathy "Goal-Driven Execution" + GSD Framework + VIBE_SYSTEM.md "Structure First"

**AI BẮT BUỘC trình bày và ĐỢI USER DUYỆT:**
```
[SURGICAL PLAN]
Tính năng / Fix: [tên]
─────────────────────────────────────────
Files SẼ bị chạm:
  - [file 1] → [lý do cụ thể]
  - [file 2] → [lý do cụ thể]

Files KHÔNG được chạm:
  - [file X] → [lý do]

Thứ tự thực thi (Structure First — không code trước khi có architecture):
  1. [Bước] → verify: [check cụ thể]
  2. [Bước] → verify: [check cụ thể]
  3. [Bước] → verify: [check cụ thể]

Architectural Compliance:
  □ Controller chỉ route, không business logic
  □ Business logic trong Service
  □ Service implement Interface
  □ Interface bind trong ServiceProvider
  □ Không gọi Model trực tiếp trong Controller
  □ FormRequest validate input
  □ Try-Catch cho critical operations
  □ Observer tạo nếu Model mới + đăng ký AppServiceProvider
  □ SoftDeletes nếu Model quan trọng (Sinhvien/Hopdong/Hoadon/Phong)

UI Compliance (chỉ khi có Frontend):
  □ Đã xác định register: Brand hoặc Product
  □ BẮT BUỘC đọc và tuân thủ `tools/impeccable/CLAUDE.md` và các quy tắc tại `tools/impeccable/source/skills/impeccable/SKILL.md`
  □ BẮT BUỘC đọc các tài liệu design chuyên biệt nếu cần thiết (ví dụ: color-and-contrast.md, typography.md trong source/skills/impeccable/reference/)
  □ Sẽ chạy IMPECCABLE UI CHECK-GATE tại Bước 6
  □ Sẽ chạy `npx impeccable detect` sau khi render
─────────────────────────────────────────
⏳ ĐANG ĐỢI USER PHÊ DUYỆT...
Gõ "ok" / "duyệt" / "approved" để tiếp tục.
```

**Kế hoạch thiếu mục Architectural Compliance = FAIL, không được execute.**
**Kế hoạch có Frontend mà thiếu UI Compliance = FAIL, không được execute.**

---

## BƯỚC 6 — THỰC THI (SURGICAL EDITS ONLY)
> 🛠️ Đọc liên tục: `STANDARDS.md` (và `tools/impeccable/source/skills/impeccable/SKILL.md` nếu có frontend)
> Nguồn: Karpathy "Surgical Changes" + "Simplicity First"

**Quy tắc backend:**
```
✅ Chỉ chạm đúng file đã khai báo ở Bước 5.
✅ Mỗi dòng thay đổi phải trace về yêu cầu gốc của user.
✅ Naming: Model/Variable = Tiếng Việt camelCase/PascalCase, Enum = English.
✅ Luôn define $table và foreign keys tường minh trong Model.
✅ Dùng Eloquent, không raw query.
✅ DB::transaction + lockForUpdate() cho shared resources (Phong/giường).
✅ updateOrCreate với composite unique key cho bulk operations.

❌ Không thêm logic ngoài phạm vi đã duyệt.
❌ Không "improve" code lân cận không liên quan.
❌ Không xóa Try-Catch đang có.
❌ Không đụng .env hoặc APP_KEY — vi phạm Vault Protocol.
❌ Không dùng LIKE trên PII — phải dùng Blind Index.
❌ Không viết 200 dòng nếu có thể làm trong 50.
❌ Không khai báo Enum property trong constant declarations (dùng static methods).
```

---

### 🎨 IMPECCABLE UI CHECK-GATE (BẮT BUỘC khi chạm Blade/CSS/Tailwind)
> Đọc: `tools/impeccable/CLAUDE.md` TRƯỚC KHI viết bất kỳ dòng HTML nào.
> Tool: `npx impeccable detect` sau khi render.

**BƯỚC 6A — Xác định register trước khi thiết kế:**

```
[UI REGISTER DETECTION]
Surface đang làm việc: [tên file / route]
Register: [ ] Brand (landing, marketing, campaign)
           [ ] Product (dashboard, admin, app UI, form)

→ Brand  : Load .windsurf/skills/impeccable/impeccable/reference/brand.md
→ Product: Load .windsurf/skills/impeccable/impeccable/reference/product.md
→ Shared : Load .windsurf/skills/impeccable/impeccable/SKILL.md (design laws áp dụng cho cả hai)
```

**BƯỚC 6B — In bảng check TRƯỚC khi viết HTML:**

```
════════════════════════════════════════════
[IMPECCABLE UI CHECK-GATE]
════════════════════════════════════════════
□ 1. Đã đọc tools/impeccable/CLAUDE.md?
     → CHƯA: ĐỌC NGAY. Không tiếp tục.

□ 2. Font có dùng Inter không?
     → CÓ: DỪNG. Brand = Quicksand. Product = Geist Sans / DM Sans.

□ 3. Có purple gradient hoặc gradient text không?
     → CÓ: DỪNG. AI slop tell #1. Xóa hoàn toàn.

□ 4. Có nested cards (card trong card trong card) không?
     → CÓ: DỪNG. Flatten. Dùng Bento Grid layout thay thế.

□ 5. Màu có dùng #000 hoặc #fff thuần không?
     → CÓ: DỪNG. Chuyển sang OKLCH. Tint neutral về brand hue
       (chroma 0.005–0.01 là đủ). Giảm chroma khi lightness → 0 hoặc → 100.

□ 6. Animation có bounce easing không?
     → CÓ: DỪNG. Xóa. Dùng ease-out hoặc cubic-bezier tùy chỉnh.

□ 7. Có dark glow / neon shadow trên dark background không?
     → CÓ: DỪNG. AI slop. Xóa hoặc giảm opacity xuống ≤ 15%.

□ 8. Touch targets có đủ ≥ 44×44px không? (mobile)
     → CHƯA: DỪNG. Tăng padding/min-height.

□ 9. Text block có vượt 75 chars/dòng không?
     → CÓ: Thêm max-w-prose hoặc max-w-[65ch].

□ 10. Có side-tab border decoration (border chỉ bên trái như divider)?
      → CÓ: DỪNG. AI slop tell. Dùng background hoặc shadow thay thế.

□ 11. Hero layout có dùng "metric grid" (3-4 big numbers hàng ngang)?
      → CÓ: DỪNG. Generic AI pattern. Thiết kế lại với narrative rõ ràng hơn.

□ 12. Có gray text (#6b7280 hoặc tương đương) trên colored background?
      → CÓ: DỪNG. Kiểm tra contrast ratio ≥ 4.5:1 (WCAG AA).
════════════════════════════════════════════
Kết quả: [PASS ✅ / FAIL ❌ + anti-pattern + file:dòng]
════════════════════════════════════════════
```

**BƯỚC 6C — Sau khi render xong, chạy detector:**

```bash
# Bắt buộc sau mỗi lần render Blade mới hoặc sửa CSS đáng kể
npx impeccable detect resources/views/[tên-view].blade.php

# Hoặc scan toàn bộ thư mục views
npx impeccable detect resources/views/
```

```
[IMPECCABLE DETECTOR REPORT]
File: [path]
Issues found: [N]
  - [issue 1] tại [dòng X] → Fix: [cụ thể]
  - [issue 2] tại [dòng Y] → Fix: [cụ thể]

→ Nếu có P0/P1 issue: DỪNG. Fix trước khi commit.
→ Nếu sạch: PASS ✅ → Được phép tiếp tục.
```

**BƯỚC 6D — Các lệnh IMPECCABLE có sẵn (dùng khi cần review sâu):**

| Lệnh | Mục đích |
|---|---|
| `/impeccable audit [view]` | Audit kỹ theo 5 chiều, severity P0–P3 |
| `/impeccable critique [view]` | UX review theo Nielsen + persona archetypes |
| `/impeccable polish [view]` | Final pass trước khi ship |
| `/impeccable typeset [view]` | Fix typography system |
| `/impeccable colorize [view]` | Áp dụng OKLCH color system |
| `/impeccable harden [view]` | Tăng cường accessibility (a11y) |
| `/impeccable distill [view]` | Giảm visual noise, tăng whitespace |
| `/impeccable overdrive [view]` | Mode WOW — thiết kế đẳng cấp cao nhất |

---

**Sau mỗi file sửa xong:**
```
[EDIT LOG] path/to/File.php (hoặc .blade.php) ✅
- Thêm/Sửa: [mô tả ngắn]
- Không đụng: [file nào]
- Trace về yêu cầu: [yêu cầu gốc]
- IMPECCABLE detector: [PASS ✅ / N issues found]
```

---

## BƯỚC 7 — OPTIMIZER (Ω): TỰ REVIEW
> 🔍 Nguồn: `VIBE_SYSTEM.md` Recursive Self-Optimization + Karpathy "Simplicity First"

**AI tự kiểm tra trước khi chạy test:**
```
[OPTIMIZER Ω]
□ Có dòng code không trace về yêu cầu gốc? → Xóa.
□ Có abstraction không cần thiết? → Xóa.
□ Có thể đơn giản hơn không? → Đơn giản hóa.
□ AI đọc code này có hiểu trong 5 giây không? → Nếu không: thêm comment.
□ Có orphaned import/variable do thay đổi của TÔI? → Xóa.
□ Có pattern nào giống code cũ bị CLAUDE.md đánh dấu lỗi? → Sửa ngay.
□ (Nếu Frontend) IMPECCABLE detector đã PASS chưa? → Nếu chưa: Fix trước.
```

---

## BƯỚC 8 — MÁY CHÉM PRE-COMMIT
> ⚔️ Tool: Pest Architecture Test

**Chạy bắt buộc:**
```bash
php artisan test --filter=Architecture
```

**Nếu PASS:**
```
[ARCH GUARD] ✅ All architecture tests passed. → Được phép commit.
```

**Nếu FAIL → Self-Healing Protocol:**
```
[SELF-HEALING]
Vi phạm: [mô tả cụ thể]
Root cause: [phân tích nguyên nhân gốc]
Fix: [phương án cụ thể]
→ KHÔNG commit.
→ Quay lại Bước 3.
→ Ghi vào CLAUDE.md: lesson learned.
→ Lặp đến khi PASS.
```

---

## BƯỚC 9 — CẬP NHẬT BỘ NÃO
> 🔄 Post-commit bắt buộc

```bash
# Re-index GitNexus (chạy ngầm)
nohup npx gitnexus analyze --repo=. > /dev/null 2>&1 &
```

```markdown
# Cập nhật CLAUDE.md nếu có lesson learned mới
| [Ngày] | [Vấn đề] | [Nguyên nhân] | [Giải pháp & Cách phòng ngừa] |
```

---

## TÓM TẮT TOÀN BỘ WORKFLOW

```
Nhận Prompt
    │
    ▼ INIT     Cross-CLI Init        ← Đầu session / switch CLI
    │
    ▼ B1       Tier Check            ← HIERARCHY.md
    ▼ B2       Generator α           ← Surface assumptions + xác định có Frontend không
    ▼ B3       Check-Gate Backend    ← 8 check architecture BẮT BUỘC in bảng
    ▼ B4       Blast Radius          ← gitnexus_impact BẮT BUỘC
    ▼ B5       Surgical Plan         ← BẮT BUỘC đợi user duyệt (kèm UI Compliance nếu có FE)
    ▼ B6       Surgical Edits
    │           ├── Backend rules (Eloquent, Service, Interface...)
    │           └── [Nếu có Frontend]
    │               ├── 6A: Xác định Brand / Product register
    │               ├── 6B: IMPECCABLE UI CHECK-GATE (12 check)
    │               ├── 6C: npx impeccable detect [view]
    │               └── 6D: /impeccable audit|polish|critique nếu cần
    ▼ B7       Optimizer Ω           ← Self-review (kèm IMPECCABLE detector pass check)
    ▼ B8       Arch Guard            ← Pest PASS mới commit
    ▼ B9       Brain Update          ← gitnexus + CLAUDE.md
    │
    ▼
DONE ✅
```

---

## LỆNH GSD TÍCH HỢP

```bash
/gsd-plan-phase      → Kích hoạt Bước 5 với template đầy đủ
/gsd-execute-phase   → Chỉ chạy sau khi Bước 5 user đã duyệt
/gsd-verify-work     → Kích hoạt Bước 8 (Pest Architecture Test)
/gsd-security-audit  → Kiểm tra Vault Protocol + PII compliance
/gsd-status          → Đọc STATE.md, báo cáo tiến độ phase hiện tại
```

---

## SKILL ROUTING

| Tình huống | Skill cần đọc |
|---|---|
| Phân tích kiến trúc | `.claude/skills/gitnexus/gitnexus-exploring/SKILL.md` |
| Blast radius | `.claude/skills/gitnexus/gitnexus-impact-analysis/SKILL.md` |
| Debug lỗi | `.claude/skills/gitnexus/gitnexus-debugging/SKILL.md` |
| Refactor / rename | `.claude/skills/gitnexus/gitnexus-refactoring/SKILL.md` |
| CLI commands | `.claude/skills/gitnexus/gitnexus-cli/SKILL.md` |
| **UI audit / thiết kế** | **`tools/impeccable/CLAUDE.md` → `.windsurf/skills/impeccable/`** |
| **Anti-pattern detection** | **`npx impeccable detect [file-hoặc-url]`** |
| KTX domain logic | `.windsurf/skills/ktx-integration/SKILL.md` |

---

## EMERGENCY BYPASS (CHỈ DÙNG KHI HOTFIX PRODUCTION)

```
[EMERGENCY BYPASS]
Lý do bắt buộc hotfix: ___________
Bước bỏ qua: ___________
Cam kết refactor trong: ___ ngày
→ Ghi vào CLAUDE.md ngay sau khi xong.
```

---

*WORKFLOW.md v2.1 — TIER 1. Mọi conflict: file này thắng.*
*Repo: hethongquanlyktx | Cập nhật: 2026-04-29*
*Tích hợp: IMPECCABLE design system (pbakaus/impeccable) — tools/impeccable/*