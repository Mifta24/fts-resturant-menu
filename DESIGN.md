# Design System — FTS Menu SaaS

> Status: **draft/preview**. Diambil dari referensi Refero Styles ("Paste" — clipboard manager) dan diadaptasi untuk konteks FTS Menu SaaS (dashboard restoran + halaman menu publik). Belum diterapkan ke `tailwind.config.js` atau Blade views — ini cuma dokumentasi visual dulu sebelum dieksekusi ke kode.

## Ringkasan Visual

Light theme, monokrom (putih/hitam) dengan satu titik fokus warna hangat (amber gradient) sebagai brand mark, dan biru sebagai warna CTA. Kontras tinggi antara heading (near-black) dan body text (abu-abu). Tombol full-pill (radius 100px), card lembut dengan shadow ambient (bukan directional), tipografi system-ui untuk kesan native/clean.

**Kenapa referensi ini relevan untuk FTS Menu SaaS:**
- Kontras tinggi + white space besar cocok untuk halaman menu publik yang harus mudah dibaca di HP (foto makanan jadi fokus, bukan chrome UI).
- Satu warna aksen hangat (amber) bisa dipetakan ke identitas brand FTS, sementara biru tetap dipakai sebagai warna CTA/aksi (pesan, login, simpan) — memisahkan "brand" dari "aksi".
- Card + pill button system cocok untuk kartu menu item, badge kategori, dan tombol availability status.

⚠️ **Catatan konflik**: `tailwind.config.js` project ini saat ini pakai font `Figtree` sebagai `sans` default, bukan `system-ui`. Referensi asli pakai `system-ui` untuk kesan "native Apple app". Untuk FTS Menu SaaS (bukan Mac utility), **Figtree lebih pas dipertahankan** — sudah didesain untuk web/UI dan lebih hangat dibanding system-ui. Rekomendasi: pertahankan Figtree, tapi pakai scale ukuran & letter-spacing dari referensi ini. Tokoh warna & spacing tetap dipakai apa adanya. Konfirmasi ke saya kalau mau tetap pakai system-ui.

---

## Tokens — Colors

| Token | Value | Role di FTS Menu SaaS |
|---|---|---|
| `--color-amber-flame` | `linear-gradient(0deg, rgb(240,100,19) -29.375%, rgb(254,171,48) 100%)` | Logo/brand mark FTS, aksen headline di landing/marketing section |
| `--color-honey-glow` | `#feab30` | Highlight hangat sekunder (badge "Populer", "Rekomendasi") |
| `--color-signal-blue` | `#0088ff` | Primary CTA: tombol "Pesan", "Simpan Menu", "Login", "Upgrade Paket" |
| `--color-bright-blue` | `#1c95ff` | Hover/active state tombol biru |
| `--color-pure-white` | `#ffffff` | Background utama page & card |
| `--color-snow-gray` | `#f5f5f7` | Background alternating section (mis. antara hero menu & daftar kategori) |
| `--color-mist` | `#f0f0f0` | Divider/container tipis |
| `--color-silver` | `#d0d0d3` | Border, garis pemisah kategori |
| `--color-pewter` | `#ababb0` | Teks sekunder, caption harga coret / satuan |
| `--color-smoke` | `#6e6e73` | Teks tersier: deskripsi menu item, metadata (jam buka, alamat) |
| `--color-charcoal` | `#272727` | Background gelap (footer, dark section jika ada) |
| `--color-ink` | `#101010` | Heading & body text utama |
| `--color-true-black` | `#000000` | Nav link, icon, kontras maksimal |
| `--color-vivid-green` | `#34c759` | Status "Tersedia" / "Buka" |
| `--color-electric-magenta` | `#cb30e0` | Badge kategori khusus (mis. "Best Seller") |
| `--color-alert-red` | `#ff383c` | Status "Habis" / "Tutup" / error/limit paket tercapai |

## Tokens — Typography

Dipertahankan pakai **Figtree** (bukan system-ui) sebagai font family, tapi scale & tracking dari referensi ini:

| Role | Size | Line height | Letter spacing | Token |
|---|---|---|---|---|
| caption | 14px | 18 | -0.41px | `--text-caption` |
| body | 16px | 24 | — | `--text-body` |
| subheading | 18px | 24 | — | `--text-subheading` |
| heading-sm | 22px | 28 | — | `--text-heading-sm` |
| heading | 40px | 44 | -0.24px | `--text-heading` |
| heading-lg | 54px | 56 | -0.7px | `--text-heading-lg` |
| display | 80px | 80 | -1.04px | `--text-display` |

Weight: 400 (body), 500 (label/nav), 600–700 (heading).

## Tokens — Spacing & Shapes

**Density:** comfortable

- Spacing scale: 4, 8, 10, 12, 16, 20, 24, 30, 36, 40, 50, 60, 70, 100, 140 (px)
- Border radius: card 16–20px · badge & tombol 100px (full pill) · gambar menu 16–24px · container 24–40px
- Shadow (satu-satunya): `rgba(16,16,16,0.1) 0px 0px 30px 0px` — ambient, bukan directional
- Max page width: 1200px · gap antar section: 80–120px · card padding: 20–30px

---

## Components (dipetakan ke halaman FTS Menu SaaS)

### Primary CTA Button (Filled Pill)
Background `#0088ff`, teks putih, radius 100px, padding `8px 20px`, weight 600, ~16px. Hover → `#1c95ff`.
Dipakai untuk: "Login", "Daftar", "Simpan Menu Item", "Upgrade Paket", tombol pesan di public menu (jika ada fitur order).

### Ghost Pill Button (Outline)
Transparent, border sewarna teks, radius 100px, padding `10px 30px`.
Dipakai untuk: "Batal", "Lihat Detail", secondary action di dashboard.

### Top Navigation / Dashboard Sidebar
Background putih, logo amber gradient + wordmark "FTS" kiri, nav item `#000000` weight 400–500 ~16px, CTA pill kanan.
Untuk dashboard restoran: sidebar bisa pakai pattern sama tapi vertikal.

### Public Menu Hero (Header Profil Restoran)
Background putih. Nama restoran + tagline center atau left-aligned, heading 40–54px weight 700 `#101010`. Deskripsi/alamat di `#6e6e73` 16–18px. Foto cover restoran sebagai hero image (bukan device mockup seperti referensi asli).

### Menu Item Card
Background putih atau `#f5f5f7`, radius 16–20px, padding 20–24px, shadow ambient `rgba(16,16,16,0.1) 0px 0px 30px`. Foto menu di atas (radius 16–24px), nama item weight 600 22px, harga weight 700 `#101010`, deskripsi `#6e6e73` 16px. Badge status (Tersedia/Habis) pill kecil pojok kanan atas.

### Category Badge / Filter Chip
Pill radius 100px, padding kecil, dipakai untuk filter kategori menu (mis. "Makanan", "Minuman", "Dessert"). Active state pakai `#0088ff` bg + teks putih; inactive pakai border `#d0d0d3` + teks `#6e6e73`.

### Status Indicator (Availability)
Titik/pill kecil: hijau `#34c759` = Tersedia/Buka, merah `#ff383c` = Habis/Tutup — dipakai di menu item card dan status restoran.

### Auth Card (Login/Register)
Card putih radius 20px, shadow ambient, max-width ~400px center screen, background page `#f5f5f7`. Form input dengan border `#d0d0d3`, focus state biru.

### Pricing Table (Free / Starter / Business / Pro)
4 card sejajar, radius 16–20px, shadow ambient. Card paket aktif/rekomendasi bisa dapat border/aksen amber gradient di top. Harga heading weight 700, limit fitur list dengan icon check hijau `#34c759`.

### Section Divider
Tidak ada garis divider — pergantian background `#ffffff` ↔ `#f5f5f7` dengan gap 80–120px sebagai pemisah visual antar section landing page.

---

## Do's and Don'ts

**Do**
- Radius 100px untuk semua tombol & badge — non-negotiable.
- Alternate background `#ffffff` / `#f5f5f7` antar section untuk ritme visual tanpa garis.
- Heading besar (40px+) weight 600–700, tracking negatif.
- Amber gradient cuma untuk logo/brand mark & aksen headline — jangan jadi background/tombol.
- CTA konsisten biru `#0088ff` + teks putih.
- Shadow cuma versi ambient (`rgba(16,16,16,0.1) 0px 0px 30px`), tidak ada shadow directional/tajam.

**Don't**
- Jangan pakai amber gradient sebagai fill tombol.
- Jangan campur radius tajam (0px) dengan sistem pill — minimum radius container 8px, card 16–20px.
- Jangan pakai lebih dari satu warna chromatic (`#0088ff`) dalam satu konteks CTA — hijau/magenta/merah cuma untuk indikator status/kategori, bukan tombol.
- Jangan body text weight 700 — reserved untuk heading 40px+.
- Jangan tambah border line antar section — pakai pergantian background + spacing.

---

## Referensi Tailwind (untuk `tailwind.config.js` — belum diterapkan)

Project ini pakai `tailwind.config.js` gaya v3 (`theme.extend`), bukan CSS `@theme` v4. Kalau disetujui, token di atas akan ditambahkan ke `theme.extend.colors`, `theme.extend.borderRadius`, `theme.extend.boxShadow`, dan `theme.extend.spacing` — dengan `fontFamily.sans` tetap `Figtree`.

---

## Next Steps

Ini baru dokumentasi referensi. Belum ada perubahan ke `tailwind.config.js`, `resources/css`, atau Blade views. Kalau sudah oke, langkah berikutnya:

1. Tambahkan token warna/radius/shadow ke `tailwind.config.js`.
2. Terapkan ke komponen Blade yang sudah ada (`resources/views/layouts`, `resources/views/public-menu`, `resources/views/restaurant`).
3. Setelah plugin Impeccable terpasang, jalankan `/impeccable init` supaya dokumen ini bisa dikonversi jadi format `DESIGN.md` yang Impeccable pahami penuh (slop detection dsb) — file ini sudah ditulis dengan struktur yang kompatibel.
