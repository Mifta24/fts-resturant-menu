# FTS Menu SaaS

FTS Menu SaaS adalah platform **multi-restaurant digital menu** berbasis subscription. Satu aplikasi digunakan oleh banyak restoran, tetapi setiap restoran memiliki akun, data, tampilan menu, QR code, dan URL publik sendiri.

Contoh URL menu restoran:

```text
https://menu.fts-tech.co.id/sakura-ramen
https://menu.fts-tech.co.id/kopi-senja
https://menu.fts-tech.co.id/bali-seafood
```

## 1. Tujuan Produk

Produk ini dibuat untuk membantu restoran:

- Menampilkan menu digital melalui QR code.
- Mengubah harga, foto, deskripsi, dan status menu tanpa mencetak ulang.
- Memberikan pengalaman menu yang nyaman di perangkat mobile.
- Mengelola menu sendiri melalui dashboard.
- Memiliki link menu khusus tanpa membuat website terpisah.

Bagi FTS, produk ini memberikan model bisnis berulang melalui subscription bulanan atau tahunan dengan satu source code yang dipakai banyak restoran.

## 2. Product Positioning

> **Satu QR, menu selalu terbaru.**

FTS Menu bukan sekadar QR yang membuka file PDF. Menu disimpan sebagai data terstruktur sehingga restoran dapat mengubahnya kapan saja melalui dashboard.

## 3. Target Pengguna

Target awal:

- Kafe kecil dan menengah.
- Restoran dengan 10–50 meja.
- Restoran di daerah wisata.
- Restoran yang sering mengganti menu atau harga.
- Restoran yang masih menggunakan menu PDF atau buku cetak.

## 4. Fitur MVP

### Untuk restoran

- Registrasi dan login.
- Membuat profil restoran.
- Mendapatkan URL menu unik.
- Mengelola kategori menu.
- Mengelola nama, harga, foto, dan deskripsi menu.
- Mengatur status tersedia atau habis.
- Mengatur urutan kategori dan menu.
- Mengunduh QR code.
- Melihat paket dan masa aktif subscription.

### Untuk pelanggan restoran

- Membuka menu tanpa login.
- Melihat kategori dan daftar menu.
- Melihat harga, foto, deskripsi, dan status ketersediaan.
- Mengakses WhatsApp, Instagram, dan Google Maps restoran jika tersedia.

### Untuk admin FTS

- Mengelola restoran dan pengguna.
- Mengaktifkan, menangguhkan, atau menonaktifkan akun.
- Mengelola paket subscription.
- Memeriksa pembayaran manual.
- Melihat penggunaan sistem.
- Mengelola batas menu, kategori, dan storage.

## 5. Model Multi-Tenant

Versi awal menggunakan model **shared database dengan `restaurant_id`**.

Semua data yang dimiliki restoran wajib terhubung ke satu restoran:

```text
users -> restaurant_users -> restaurants
restaurants -> categories -> menu_items
restaurants -> subscriptions
restaurants -> menu_views
```

Setiap query dashboard harus dibatasi berdasarkan restoran milik pengguna yang sedang login.

## 6. Struktur URL

```text
/                               Landing page
/pricing                        Pricing page
/login                          Login restoran
/register                       Registrasi restoran
/{restaurantSlug}               Menu publik restoran

/dashboard                      Dashboard restoran
/dashboard/profile              Profil restoran
/dashboard/categories           Kelola kategori
/dashboard/menu-items           Kelola menu
/dashboard/qr-code              QR code
/dashboard/subscription         Paket dan subscription
/dashboard/statistics           Statistik

/admin                          Dashboard admin FTS
/admin/restaurants              Kelola restoran
/admin/users                    Kelola pengguna
/admin/packages                 Kelola paket
/admin/subscriptions            Kelola subscription
/admin/payments                 Kelola pembayaran
```

## 7. Pricing Awal

| Paket | Harga Bulanan | Batas Menu | Fitur Utama |
|---|---:|---:|---|
| Free | Rp0 | 10 | QR, link menu, 3 kategori, branding FTS |
| Starter | Rp49.000 | 30 | Logo, foto menu, status tersedia/habis |
| Business | Rp99.000 | 100 | Unlimited kategori, theme, statistik dasar, tanpa branding |
| Pro | Rp149.000 | Unlimited | Multilingual, advanced statistics, priority support |

Harga masih berupa hipotesis awal dan perlu divalidasi kepada restoran pilot.

## 8. Dokumentasi

- [User dan Business Flow](docs/FLOW.md)
- [System Architecture](docs/SYSTEM_ARCHITECTURE.md)
- [Project Structure](docs/PROJECT_STRUCTURE.md)
- [Technology Stack](docs/TECH_STACK.md)
- [Database Schema](docs/DATABASE_SCHEMA.md)
- [Features dan Pricing](docs/FEATURES_AND_PRICING.md)
- [Routes dan API](docs/ROUTES_AND_API.md)
- [Security dan Multi-Tenancy](docs/SECURITY.md)
- [Testing Strategy](docs/TESTING.md)
- [Deployment](docs/DEPLOYMENT.md)
- [Development Roadmap](docs/ROADMAP.md)

## 9. Prinsip Pengembangan

1. Mulai dari MVP kecil yang dapat didemonstrasikan.
2. Jangan membangun POS, ordering, atau payment pelanggan pada tahap awal.
3. Pisahkan data setiap restoran dengan ketat.
4. Optimalkan tampilan publik untuk mobile.
5. Kompres dan batasi ukuran gambar.
6. Validasi harga dan fitur dengan restoran pilot.
7. Tambahkan fitur berdasarkan permintaan nyata pelanggan.

## 10. Scope yang Belum Masuk MVP

- Pemesanan dari meja.
- Pembayaran QRIS pelanggan.
- POS dan kasir.
- Kitchen Display System.
- Inventory bahan baku.
- Loyalty points.
- Reservasi.
- AI recommendation.
- Aplikasi Android dan iOS.

Fitur tersebut dapat menjadi roadmap setelah MVP memperoleh pengguna aktif.
