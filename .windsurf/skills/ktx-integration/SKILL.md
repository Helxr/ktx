# KTX Integration Skill - GSD + GitNexus + Impeccable

Tích hợp 3 công cụ AI (GSD, GitNexus, Impeccable) thành một đội đồng bộ cho dự án KTX.

## Khi dùng skill này

Dùng skill này khi:
- Bắt đầu một phase mới trong dự án KTX
- Thực hiện thay đổi kiến trúc lớn
- Refactor code phức tạp
- Debug lỗi khó
- Deploy code

## Workflow tích hợp

### Phase 1: Discovery (GitNexus)
1. **Query knowledge graph** trước khi bắt đầu:
   ```bash
   gitnexus query "tìm hiểu về [module/function]"
   gitnexus context [symbol_name]
   ```
2. **Impact analysis** trước khi sửa:
   ```bash
   gitnexus_impact({target: "symbolName", direction: "upstream"})
   ```
3. **Check duplicates** trước khi tạo mới:
   ```bash
   gitnexus_query({query: "tìm class/function tương tự"})
   ```

### Phase 2: Planning (GSD)
1. **Discuss phase** với GSD:
   ```bash
   /gsd-discuss-phase [N]
   ```
2. **Plan phase** với GSD:
   ```bash
   /gsd-plan-phase [N]
   ```

### Phase 3: Implementation (GSD + GitNexus)
1. **Execute phase** với GSD:
   ```bash
   /gsd-execute-phase [N]
   ```
2. **Trong quá trình implement:**
   - Trước khi sửa code: Chạy `gitnexus_impact`
   - Sau khi sửa code: Chạy `gitnexus_detect_changes`
   - Nếu rename: Dùng `gitnexus_rename`

### Phase 4: UI Verification (Impeccable)
1. **Audit UI** nếu có thay đổi frontend:
   ```bash
   impeccable detect resources/views/[module]/
   ```
2. **Polish UI** trước khi deploy:
   ```bash
   impeccable polish resources/views/[module]/
   ```

### Phase 5: Verification (GSD + GitNexus + Impeccable)
1. **Verify work** với GSD:
   ```bash
   /gsd-verify-work [N]
   ```
2. **Detect changes** trước khi commit:
   ```bash
   gitnexus_detect_changes()
   ```
3. **Final UI audit**:
   ```bash
   impeccable detect resources/views/ --fast
   ```

### Phase 6: Memory Update
1. **Cập nhật Permanent Memory** nếu gặp lỗi mới hoặc kiến trúc thay đổi:
   - Thêm vào `CLAUDE.md` mục `## Lessons Learned & Memory`
   - Format: `[Ngày] | [Vấn đề] | [Nguyên nhân] | [Giải pháp & Cách phòng ngừa]`

## Quy tắc bắt buộc

1. **BẮT BUỘC chạy GitNexus impact** trước khi sửa bất kỳ symbol nào
2. **BẮT BUỘC chạy Impeccable** sau khi thay đổi UI
3. **BẮT BUỘC chạy gitnexus_detect_changes** trước khi commit
4. **BẮT BUỘC cập nhật Memory** sau khi giải quyết lỗi phức tạp

## Lệnh nhanh

```bash
# Full workflow cho một feature
ktx-feature [module-name]

# Debug workflow
ktx-debug [mô tả lỗi]

# Refactor workflow
ktx-refactor [symbol-name]

# Deploy workflow
ktx-deploy
```

## Ví dụ sử dụng

**Bắt đầu feature mới:**
```
1. gitnexus query "tìm hiểu về module sinh viên"
2. /gsd-discuss-phase 1
3. /gsd-plan-phase 1
4. /gsd-execute-phase 1
5. impeccable detect resources/views/sinhvien/
6. /gsd-verify-work 1
7. gitnexus_detect_changes()
8. git add . && git commit
```

**Debug lỗi:**
```
1. gitnexus_query({query: "lỗi đăng nhập"})
2. gitnexus_context LoginController
3. gitnexus_impact({target: "LoginController", direction: "upstream"})
4. Sửa lỗi
5. gitnexus_detect_changes()
6. Cập nhật Memory nếu cần
```
