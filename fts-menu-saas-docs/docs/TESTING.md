# Testing Strategy

## 1. Testing Goals

- Menjamin data antar-restoran tidak tercampur.
- Menjamin limit paket ditegakkan.
- Menjamin halaman menu publik stabil di mobile.
- Menjamin upload gambar aman.
- Menjamin subscription dan pembayaran bekerja benar.

## 2. Unit Tests

Target unit test:

```text
SlugServiceTest
PlanLimitServiceTest
SubscriptionStatusTest
PriceFormattingTest
QrCodeUrlTest
TenantContextTest
```

## 3. Feature Tests

### Authentication

- User dapat register.
- Email harus unik.
- User dapat login dan logout.
- Suspended user tidak dapat mengakses dashboard.

### Tenant Isolation

- User restoran A tidak dapat melihat menu restoran B.
- User restoran A tidak dapat mengedit kategori restoran B.
- User restoran A tidak dapat menghapus foto restoran B.
- Staff tidak dapat mengubah subscription.

### Menu Management

- Owner dapat membuat kategori.
- Menu harus memiliki kategori milik tenant yang sama.
- Harga negatif ditolak.
- File non-image ditolak.
- Menu unavailable tampil dengan status yang benar.

### Plan Limits

- Free user tidak dapat membuat menu ke-11.
- Starter user tidak dapat melewati limit paket.
- Unlimited plan tidak dibatasi jumlah menu.
- Upgrade langsung memperbarui limit.

### Public Menu

- Slug valid menampilkan menu.
- Slug tidak ditemukan menghasilkan 404.
- Restoran draft tidak dapat diakses publik.
- Restoran expired menampilkan inactive page.
- Hanya kategori aktif yang tampil.

### Payment

- Restaurant dapat upload bukti pembayaran.
- Hanya admin dapat approve.
- Approval mengaktifkan subscription.
- Rejection tidak mengaktifkan subscription.

## 4. Browser and Responsive Testing

Perangkat minimum:

- Android mobile viewport.
- iPhone mobile viewport.
- Tablet.
- Desktop.

Browser minimum:

- Chrome.
- Safari.
- Edge.
- Mobile browser umum.

## 5. Manual Acceptance Checklist

### Restaurant Owner

- Register dan verify email.
- Membuat profil.
- Menambah kategori.
- Menambah menu dengan foto.
- Mengubah harga.
- Menandai menu habis.
- Mengunduh QR.
- Membuka hasil QR.

### Admin

- Melihat restoran baru.
- Mengubah status restoran.
- Memverifikasi pembayaran.
- Mengubah paket.
- Memeriksa audit log.

## 6. Security Testing

- Cross-tenant ID manipulation.
- Unauthorized route access.
- CSRF protection.
- Upload invalid MIME.
- Oversized upload.
- Rate limit login.
- Session fixation prevention.
- Production debug check.

## 7. Performance Targets for MVP

Target awal:

- Halaman menu publik tetap ringan pada koneksi mobile.
- Gambar menggunakan thumbnail yang terkompresi.
- Query menu publik tidak menghasilkan N+1 query.
- Database memiliki index tenant.
- Cache digunakan jika trafik meningkat.

## 8. Release Gate

Jangan rilis publik sebelum:

- Critical authorization tests lulus.
- Backup dan restore diuji.
- HTTPS aktif.
- Debug mode nonaktif.
- Error page production tersedia.
- Subscription limit diuji.
- Mobile public menu diuji pada perangkat nyata.
