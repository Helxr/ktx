> ⚡ MANDATORY: Read and follow WORKFLOW.md (9-step mandatory workflow) before writing any code.
# GitHub Copilot Instructions — KTX Management System

This is a Laravel 10 Dormitory Management System. Follow project conventions strictly.

## Project Conventions (from STANDARDS.md)

| Component | Format | Example |
|-----------|--------|---------|
| Controllers | PascalCase + Controller | `SinhvienController` |
| Models | **Tiếng Việt** PascalCase | `Sinhvien`, `Phong`, `Hopdong` |
| Variables | **Tiếng Việt** camelCase | `$tuKhoa`, `$danhSachPhong` |
| DB Tables | **Tiếng Việt** snake_case | `sinhvien`, `phong` |
| Enums | **Tiếng Anh** PascalCase | `ContractStatus`, `RegistrationType` |
| Views | kebab-case | `admin/sinhvien/danhsach.blade.php` |

## Architecture Rules

- Business logic belongs in `app/Services/` — Controllers only route.
- Always use `DB::transaction()` for multi-step writes.
- Always use `SoftDeletes` on important models (Sinhvien, Hopdong, Hoadon, Phong).
- Use Enums for all status fields — never raw strings.
- Always validate with FormRequest classes.

## Security

- NEVER disclose `APP_KEY` or secrets from `.env`.
- Use `AsEncrypted` for PII fields.

---

## Karpathy LLM Coding Guidelines
> Source: https://github.com/forrestchang/andrej-karpathy-skills

### 1. Think Before Coding
- State your assumptions explicitly. If uncertain, ask.
- If multiple interpretations exist, present them — don't pick silently.
- If a simpler approach exists, say so. Push back when warranted.
- If something is unclear, stop. Name what's confusing. Ask.

### 2. Simplicity First
- No features beyond what was asked.
- No abstractions for single-use code.
- No "flexibility" that wasn't requested.
- If you write 200 lines and it could be 50, rewrite it.

### 3. Surgical Changes
- Don't "improve" adjacent code, comments, or formatting.
- Don't refactor things that aren't broken.
- Match existing style, even if you'd do it differently.
- Remove imports/vars YOUR changes made unused. Leave pre-existing dead code alone.
- Every changed line should trace directly to the user's request.

### 4. Goal-Driven Execution
- Transform tasks into verifiable goals before coding.
- For multi-step tasks, state a brief plan: `[Step] → verify: [check]`
- Clarifying questions come BEFORE implementation, not after mistakes.
