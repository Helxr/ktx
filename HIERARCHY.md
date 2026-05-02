# Hierarchy of Truth (Phân cấp Quyền lực Tri thức)

Đây là văn bản pháp lý tối cao dành cho tất cả AI Agents tham gia vào dự án KTX.
Trong trường hợp xảy ra xung đột tri thức giữa các file, tài liệu hoặc code cũ, AI BẮT BUỘC phải tuân thủ theo hệ thống phân cấp sau:

## [TIER 1] Hiến pháp Tuyệt đối (Quyền lực Tối cao)
Đây là tư duy thiết kế cốt lõi. Mọi suy luận, đề xuất và code mới đều phải bám rễ vào đây.
1. **`WORKFLOW.md`**: Đường ray bắt buộc 7 bước cho mọi AI Agent.
2. **`AGENTS.md`**: Các quy tắc xử lý tình huống, Impeccable Check-Gate, Self-Healing.
3. **`STANDARDS.md`**: Quy tắc danh pháp (Tiếng Việt cho Model/Variable, Tiếng Anh cho Enum).
4. **`VIBE_SYSTEM.md`**: Giao thức bảo mật (Vault Protocol), mã hóa PII, Blind Indexing.

## [TIER 2] Quy trình & Chỉ thị IDE (Quyền lực Hướng dẫn)
Định hướng cách AI tương tác với môi trường và sử dụng công cụ.
1. **`.cursorrules` / `.windsurfrules`**: Hướng dẫn dùng GitNexus, GSD, Impeccable.
2. **`CLAUDE.md`**: Lịch sử các lỗi đã giải quyết (Lessons Learned). Đóng vai trò làm bộ nhớ kinh nghiệm để không lặp lại lỗi cũ.

## [TIER 3] Hiện trạng & Lịch sử (Quyền lực Tư vấn)
Đây là bức tranh thực tại. Thực tại có thể chứa nợ kỹ thuật (Technical Debt) và lỗi lầm.
1. **Codebase hiện tại (Legacy Code)**
2. **`ARCHITECTURE_REPORT.md`**
3. **Các file kế hoạch (`.planning/*`)**

---

### Nguyên tắc Xử lý Xung đột:
Nếu bạn (AI) phát hiện một pattern trong **Tier 3** (ví dụ: một Controller cũ dài 300 dòng) đi ngược lại với **Tier 1** (ví dụ: STANDARDS.md cấm God Class), bạn **TẤT YẾU PHẢI** coi đoạn code cũ đó là Technical Debt.
Tuyệt đối **KHÔNG ĐƯỢC** sao chép cách làm sai đó. Hãy tuân thủ Tier 1, cảnh báo người dùng và đề xuất phương án sửa nó.
