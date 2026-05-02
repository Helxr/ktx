# Vibe Coding System Configuration
## Source of Truth for KTX Project

This file serves as the bridge between the Vibe Coding methodology and the GSD/GitNexus framework used in this project. All AI Agents (Windsurf, Cursor, etc.) must adhere to these principles.

### 1. Methodology (Đạo - 道)
- **Recursive Self-Optimization:** Always use a "Generator" prompt (α) and an "Optimizer" prompt (Ω).
- **Structure First:** Never write code before the architecture is validated via `gsd-plan-phase`.
- **Context Chunking:** Do not load all documentation at once. Use GitNexus to query only relevant symbols.

### 2. Standards & Rules (Pháp - 法)
- **Naming:** Follow [STANDARDS.md](file:///d:/laragon/www/hethongquanlyktx/STANDARDS.md).
  - Models/Variables: Tiếng Việt.
  - Enums: English.
- **MVC Strictness:** No DB queries in Blade. Business logic in Services/Observers.
- **ORM Magic:** Manually define `$table` and `$foreign_key` in Models to avoid language pluralization issues.

### 3. Vibe Tools (Khí - 器)
- **Prompts Library:** [tools/vibe-coding/i18n/zh/prompts/](file:///d:/laragon/www/hethongquanlyktx/tools/vibe-coding/i18n/zh/prompts/)
- **Skills:** [tools/vibe-coding/i18n/zh/skills/](file:///d:/laragon/www/hethongquanlyktx/tools/vibe-coding/i18n/zh/skills/)
- **Architecture Report:** [ARCHITECTURE_REPORT.md](file:///d:/laragon/www/hethongquanlyktx/ARCHITECTURE_REPORT.md)

### 4. Security & Privacy Standards (Enterprise Layer)
- **PII Protection (Encryption at Rest):**
  - Fields like `cccd`, `so_dien_thoai`, `email` MUST use Laravel `AsEncrypted` casting.
  - **The Search Paradox:** Use **Blind Indexing** (hashed shadow columns) for exact match searches on encrypted data. Never use `LIKE` on PII.
- **Audit Trail (Non-repudiation):**
  - All write operations on `Hoadon`, `Hopdong`, `Sinhvien` MUST be logged via Asynchronous Observers (Queue after commit).
  - Logs must include `old_values`, `new_values`, and `user_metadata`.

### 5. Concurrency & Reliability
- **Race Conditions:** Use Database Transactions (`DB::transaction`) and Pessimistic Locking (`lockForUpdate()`) for shared resources like `Phong` (bed capacity).
- **Idempotency:** Bulk operations (e.g., Monthly Billing) MUST be idempotent using `updateOrCreate` with composite unique keys.

### 6. The Vault Protocol (Key Safety)
- **.env Protection:** AI Agents are strictly FORBIDDEN from reading or printing the `APP_KEY`.
- **Key Disaster Prevention:** `php artisan key:generate` is a RESTRICTED command. Running it on production will destroy all PII data. AI must warn the user before suggesting any key rotation.

### 7. Cross-CLI Protocol
When switching between CLI tools:
1. **Initialize:** Read this file and `STANDARDS.md` first.
2. **Synchronize:** Check `.planning/STATE.md` to understand the current project phase.
3. **Validate:** Run `gsd-verify-work` AND `gsd-security-audit` before claiming any task as complete.
"Workflow chuẩn: Xem WORKFLOW.md — đã tích hợp sẵn Cross-CLI Init."

