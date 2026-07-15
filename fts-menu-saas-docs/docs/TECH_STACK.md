# Technology Stack

## 1. Recommended MVP Stack

| Layer | Technology | Purpose |
|---|---|---|
| Backend | Laravel | Authentication, business logic, dashboard, subscription rules |
| Server-rendered UI | Blade | Cepat dan sederhana untuk MVP |
| Frontend interaction | Alpine.js | Modal, dropdown, preview, lightweight interaction |
| Styling | Tailwind CSS | Responsive UI dan konsistensi design system |
| Database | MySQL atau PostgreSQL | Menyimpan tenant, menu, subscription, dan analytics |
| Authentication | Laravel starter auth | Login, register, password reset, email verification |
| Authorization | Laravel Policies dan Gates | Isolasi data antar-restoran |
| Storage | Local untuk development, S3-compatible untuk production | Logo, foto menu, bukti pembayaran |
| QR Code | Server-side QR library | Generate QR dari URL restoran |
| Image processing | Image processing library | Resize, compress, thumbnail, WebP |
| Mail | SMTP atau transactional email provider | Verifikasi dan subscription reminder |
| Queue | Database queue atau Redis | Pekerjaan background |
| Cache | File/database untuk MVP, Redis saat scale | Mempercepat menu publik |
| Scheduler | Laravel Scheduler + cron | Reminder dan subscription expiration |
| Testing | PHPUnit atau Pest | Unit dan feature testing |
| Web server | Nginx atau Apache | Menjalankan aplikasi web |
| Deployment | VPS, Plesk, atau managed platform | Hosting aplikasi |
| CI/CD | GitHub Actions optional | Test dan deployment automation |

## 2. Mengapa Blade untuk MVP

Blade direkomendasikan karena:

- Tidak memerlukan frontend application terpisah.
- Login, dashboard, dan CRUD dapat dibuat lebih cepat.
- SEO dan initial page load sederhana.
- Tim hanya memelihara satu codebase.
- Cocok untuk interaksi menu yang tidak terlalu kompleks.

React atau Vue baru dipertimbangkan jika dashboard menjadi sangat interaktif atau produk membutuhkan aplikasi frontend terpisah.

## 3. Database Choice

MySQL dan PostgreSQL sama-sama sesuai untuk MVP.

Pilih berdasarkan:

- Infrastruktur FTS yang sudah tersedia.
- Pengalaman tim.
- Dukungan hosting.
- Kebutuhan query di masa depan.

Yang paling penting adalah:

- Foreign key aktif.
- Index tenant tersedia.
- Constraint slug unik.
- Backup otomatis.

## 4. Image Strategy

Foto adalah bagian terbesar dari storage dan bandwidth.

Aturan awal:

- Batasi ukuran upload mentah.
- Validasi MIME type.
- Resize ke ukuran display yang diperlukan.
- Simpan format terkompresi.
- Buat thumbnail.
- Hapus file lama ketika menu dihapus atau gambar diganti.
- Terapkan limit storage per paket.

## 5. Payment Strategy

### MVP

- Transfer bank.
- Upload bukti pembayaran.
- Approval manual oleh admin FTS.

### Setelah validasi

- Integrasi payment gateway.
- Webhook pembayaran.
- Aktivasi otomatis.
- Invoice dan riwayat transaksi.

Pendekatan manual mengurangi kompleksitas sebelum jumlah pelanggan terbukti.

## 6. Optional Integrations

Fitur lanjutan:

- Google Analytics atau privacy-friendly analytics.
- Error monitoring.
- Uptime monitoring.
- WhatsApp notification provider.
- CDN.
- Payment gateway.
- Email marketing.

## 7. Environment Separation

Gunakan minimal tiga environment:

```text
local        Development individual
staging      Internal review dan demo
production   Pelanggan publik
```

Jangan menggunakan database atau storage production untuk development.

## 8. Configuration Principles

- Semua credential berada di environment variables.
- Jangan commit `.env`.
- Gunakan separate key untuk staging dan production.
- Disable debug mode di production.
- Gunakan secure cookies dan HTTPS.
- Rotasi credential secara berkala.
