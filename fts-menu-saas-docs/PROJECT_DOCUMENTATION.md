# FTS Menu SaaS — Project Documentation Index

Dokumen ini adalah index ringkas untuk seluruh dokumentasi proyek.

## Product Summary

FTS Menu SaaS adalah platform multi-restaurant yang memungkinkan setiap restoran membuat menu digital, mengelola menu melalui dashboard, memperoleh URL unik, dan menghasilkan QR code untuk pelanggan.

Contoh:

```text
menu.fts-tech.co.id/nama-restoran
```

## Core Business Model

- Satu platform digunakan banyak restoran.
- Setiap restoran memiliki data terpisah.
- Free tier digunakan untuk acquisition.
- Paid tier membuka kapasitas dan fitur tambahan.
- FTS dapat memperoleh recurring revenue bulanan atau tahunan.

## MVP Scope

- Registration dan login.
- Restaurant profile.
- Unique slug.
- Category management.
- Menu management.
- Image upload.
- Availability status.
- Public mobile menu.
- QR code.
- Package limits.
- Manual subscription payment.
- Admin dashboard.

## Recommended Stack

- Laravel.
- Blade.
- Alpine.js.
- Tailwind CSS.
- MySQL atau PostgreSQL.
- Local storage untuk development.
- S3-compatible object storage untuk production.
- Laravel Policies untuk tenant isolation.
- Scheduler untuk subscription reminder.
- Queue dan Redis ketika aplikasi berkembang.

## Pricing Summary

| Package | Price | Limit |
|---|---:|---:|
| Free | Rp0 | 10 menu |
| Starter | Rp49.000/month | 30 menu |
| Business | Rp99.000/month | 100 menu |
| Pro | Rp149.000/month | Unlimited |

## Documentation Files

- `README.md`
- `docs/FLOW.md`
- `docs/SYSTEM_ARCHITECTURE.md`
- `docs/PROJECT_STRUCTURE.md`
- `docs/TECH_STACK.md`
- `docs/DATABASE_SCHEMA.md`
- `docs/FEATURES_AND_PRICING.md`
- `docs/ROUTES_AND_API.md`
- `docs/SECURITY.md`
- `docs/TESTING.md`
- `docs/DEPLOYMENT.md`
- `docs/ROADMAP.md`
