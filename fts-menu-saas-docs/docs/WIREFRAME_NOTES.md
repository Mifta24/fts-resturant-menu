# Wireframe Notes (Draft)

Catatan struktur halaman untuk Phase 0 & Phase 1. Wireframe visual (Figma/FigJam) sebaiknya dibuat terpisah; dokumen ini mendeskripsikan struktur konten tiap halaman sebagai acuan implementasi Blade.

## 1. Public Menu Page (`/{restaurantSlug}`)

```text
[ Header: logo, nama restoran, deskripsi singkat ]
[ Cover image (opsional) ]
[ Social links: WhatsApp, Instagram, Maps ]
[ Category navigation (tab/scroll horizontal, mobile-first) ]
[ Menu list per kategori ]
  - Foto (jika ada)
  - Nama menu
  - Deskripsi singkat
  - Harga
  - Status: tersedia / habis
[ Footer: Powered by FTS Menu (Free plan) ]
```

Prioritas: mobile-first, load cepat, tanpa perlu login.

## 2. Restaurant Dashboard

```text
[ Sidebar/topbar: Profil, Kategori, Menu, QR Code, (Subscription, Statistik - phase lanjut) ]
[ Dashboard home: ringkasan jumlah kategori & menu, link cepat ]
```

## 3. Category Management

```text
[ List kategori dengan drag-to-reorder ]
[ Tombol tambah kategori ]
[ Form: nama, deskripsi, status aktif ]
```

## 4. Menu Item Management

```text
[ List menu per kategori ]
[ Tombol tambah menu ]
[ Form: nama, deskripsi, harga, foto, status tersedia ]
[ Toggle cepat: tersedia / habis ]
```

## 5. QR Code Page

```text
[ Preview QR code besar ]
[ URL menu publik ]
[ Tombol download (PNG) ]
```

## Status

- [ ] Wireframe visual (Figma) menyusul
- [ ] Direview bersama Mr. Yoshi
