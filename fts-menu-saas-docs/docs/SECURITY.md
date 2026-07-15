# Security dan Multi-Tenancy

Produk ini akan digunakan banyak restoran. Keamanan bukan fitur tambahan, tetapi bagian utama dari desain.

## 1. Risiko Utama

- Kebocoran data antar-restoran.
- Pengguna mengedit menu restoran lain.
- Upload file berbahaya.
- Account takeover.
- Brute force login.
- Subscription bypass.
- Exposure credential.
- Kehilangan data.
- Spam atau abuse pada free tier.

## 2. Tenant Isolation

Aturan wajib:

1. Semua data tenant memiliki `restaurant_id`.
2. Tenant context berasal dari membership pengguna yang login.
3. Jangan mempercayai `restaurant_id` dari browser.
4. Gunakan Policies untuk semua update dan delete.
5. Pastikan category dan menu item berasal dari restoran yang sama.
6. Tambahkan feature tests untuk cross-tenant access.

Contoh aman:

```php
$restaurant = $tenantContext->currentRestaurant();

$menuItem = $restaurant
    ->menuItems()
    ->findOrFail($menuItemId);
```

Hindari:

```php
$menuItem = MenuItem::findOrFail($menuItemId);
```

jika tidak diikuti pemeriksaan authorization tenant.

## 3. Authentication

- Password harus di-hash menggunakan mekanisme framework.
- Email verification untuk owner.
- Password reset token memiliki expiration.
- Session dirotasi setelah login.
- Secure dan HTTP-only cookie di production.
- Rate limit login dan password reset.

## 4. Authorization

Gunakan role:

```text
super_admin
owner
manager
staff
```

Permission contoh:

| Action | Owner | Manager | Staff |
|---|---:|---:|---:|
| Edit profile | Yes | Yes | No |
| Manage menu | Yes | Yes | Yes |
| Manage team | Yes | Optional | No |
| Change package | Yes | No | No |
| Upload payment | Yes | No | No |
| Delete restaurant | Yes | No | No |

## 5. File Upload Security

- Batasi file type dan MIME type.
- Batasi ukuran file.
- Rename file menggunakan generated ID.
- Jangan menggunakan original filename sebagai path publik.
- Proses gambar melalui image library.
- Tolak SVG kecuali sudah memiliki sanitization yang aman.
- Simpan bukti pembayaran secara private.
- Gunakan signed URL jika private file perlu dibuka.

## 6. Subscription Enforcement

Plan limit harus ditegakkan di backend, bukan hanya disembunyikan di UI.

Validasi:

- Jumlah menu.
- Jumlah kategori.
- Jumlah anggota tim.
- Storage usage.
- Feature availability.
- Masa aktif subscription.

## 7. Application Security

- CSRF protection aktif.
- Escaping output default.
- Validasi seluruh input.
- Hindari raw query yang tidak perlu.
- Disable debug di production.
- Jangan expose stack trace.
- Gunakan security headers.
- HTTPS wajib.

## 8. Data Protection

Data minimum yang disimpan:

- Data akun restoran.
- Data publik restoran.
- Data menu.
- Data pembayaran.
- Statistik agregat.

Hindari menyimpan data pribadi pelanggan restoran pada MVP karena belum diperlukan.

## 9. Backup

Minimal:

- Database backup harian.
- Retention backup terjadwal.
- Object storage protection atau versioning jika tersedia.
- Restore procedure harus diuji.
- Backup credential disimpan terpisah.

## 10. Logging dan Audit

Log aktivitas penting:

- Login gagal berulang.
- Perubahan status restoran.
- Perubahan paket.
- Approval pembayaran.
- Penghapusan data.
- Perubahan anggota tim.

Jangan log:

- Password.
- Full payment credential.
- Secret key.
- Sensitive token.

## 11. Free Tier Abuse Prevention

- Email verification.
- Rate limit registrasi.
- CAPTCHA jika abuse muncul.
- Limit upload.
- Limit jumlah tenant per akun.
- Suspend account yang melanggar kebijakan.
