# Laravel Senior Developer Assessment

This project implements **two tasks** as part of the Laravel Senior Developer Assessment:

- **Task A**: Bulk CSV Import + Chunked Image Upload
- **Task B**: Laravel Package for User Discounts

---

## 🚀 Tech Stack

- PHP 8.2
- Laravel 12
- MySQL 8
- Composer
- Postman (for API testing)
- [Intervention Image](https://image.intervention.io/) (for image resizing in Task A)

---

# Task A — Bulk Import + Chunked Image Upload

### 🎯 Goal
- Import large CSV files (10,000+ rows) for **Products** (unique by SKU).
- Upsert logic: if SKU exists → update, else → insert.
- Result summary: total, imported, updated, invalid, duplicates.
- Chunked image upload: supports resumable uploads, checksum validation.
- Image variants generation: `256px`, `512px`, `1024px` while preserving aspect ratio.
- Database relations: Products ↔ Uploads ↔ Images.
- Concurrency safe and idempotent.

---

### 📂 Database Schema

- **products**
  - `id`, `sku`, `name`, `price`, timestamps
- **uploads**
  - `id`, `path`, `checksum`, `meta`, timestamps
- **images**
  - `id`, `upload_id`, `product_id`, `size`, `path`, `is_primary`, timestamps

---

### 🛠 Approach

1. **CSV Import**
   - Read CSV using `fgetcsv`.
   - Validate required columns (`sku`, `name`).
   - Upsert into `products` table.
   - Generate summary report.

2. **Chunked Upload**
   - Each file split into chunks.
   - Chunks stored temporarily in `storage/app/chunks/{identifier}`.
   - On last chunk → merge all into final file → store in `uploads` table.
   - Validate checksum before completing.

3. **Image Variants**
   - Use `Intervention/Image` to resize into multiple sizes.
   - Save resized files under `storage/app/images/`.
   - Store metadata in `images` table.
   - Ensure one primary image per product.

---

### 📦 API Endpoints (Task A)

#### Import Products
`POST /api/import/products`

- **Request** (form-data):
  - `file` = CSV file (required)

- **Response**
```json
{
  "total": 5,
  "imported": 3,
  "updated": 1,
  "invalid": 1,
  "duplicates": 0
}
