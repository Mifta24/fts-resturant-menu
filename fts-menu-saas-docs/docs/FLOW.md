# User dan Business Flow

## 1. Alur Registrasi Restoran

```mermaid
flowchart TD
    A[Restoran membuka landing page] --> B[Klik Register]
    B --> C[Isi nama, email, dan password]
    C --> D[Verifikasi email]
    D --> E[Buat profil restoran]
    E --> F[Sistem membuat slug unik]
    F --> G[Pilih Free Plan atau paket berbayar]
    G --> H[Masuk dashboard]
    H --> I[Tambah kategori dan menu]
    I --> J[Generate QR code]
    J --> K[Pasang QR di meja atau kasir]
```

## 2. Alur Pengelolaan Menu

```mermaid
flowchart TD
    A[Restoran login] --> B[Dashboard]
    B --> C[Kelola kategori]
    C --> D[Tambah atau edit menu]
    D --> E[Upload foto]
    E --> F[Isi nama, deskripsi, dan harga]
    F --> G[Atur status tersedia]
    G --> H[Simpan]
    H --> I[Menu publik langsung diperbarui]
```

## 3. Alur Pelanggan Restoran

```mermaid
flowchart TD
    A[Pelanggan scan QR] --> B[Buka URL restoran]
    B --> C[Sistem mencari restaurant berdasarkan slug]
    C --> D{Restoran aktif?}
    D -- Tidak --> E[Tampilkan halaman tidak aktif]
    D -- Ya --> F[Tampilkan profil dan kategori]
    F --> G[Pelanggan memilih kategori]
    G --> H[Melihat detail menu]
    H --> I[Hubungi restoran atau lihat lokasi]
```

## 4. Alur Subscription

```mermaid
flowchart TD
    A[Restoran memilih paket] --> B{Paket Free?}
    B -- Ya --> C[Aktifkan Free Plan]
    B -- Tidak --> D[Tampilkan instruksi pembayaran]
    D --> E[Restoran upload bukti pembayaran]
    E --> F[Admin FTS memeriksa pembayaran]
    F --> G{Disetujui?}
    G -- Tidak --> H[Minta koreksi pembayaran]
    G -- Ya --> I[Aktifkan subscription]
    I --> J[Set start date dan end date]
    J --> K[Kirim notifikasi berhasil]
```

## 5. Alur Upgrade Paket

1. Restoran mencapai batas paket.
2. Sistem menolak penambahan data baru yang melebihi limit.
3. Sistem menampilkan pesan upgrade.
4. Restoran memilih paket baru.
5. Pembayaran diverifikasi.
6. Limit baru langsung diterapkan.

Contoh pesan:

```text
You have reached the Free Plan limit of 10 menu items.
Upgrade to Starter to add more menu items.
```

## 6. Alur Subscription Kedaluwarsa

1. Sistem mengirim pengingat sebelum masa aktif habis.
2. Setelah tanggal berakhir, status menjadi `expired`.
3. Data restoran tidak langsung dihapus.
4. Dashboard dapat tetap diakses secara terbatas.
5. Menu publik dapat menampilkan status tidak aktif.
6. Data disimpan selama periode retensi yang ditentukan FTS.

## 7. Peran Pengguna

### Super Admin FTS

- Akses seluruh restoran.
- Mengelola paket dan pembayaran.
- Menonaktifkan akun bermasalah.
- Melihat audit log dan statistik sistem.

### Restaurant Owner

- Mengelola profil restoran.
- Mengelola anggota tim restoran.
- Mengelola menu dan subscription.

### Restaurant Staff

- Mengelola kategori dan menu sesuai permission.
- Tidak dapat mengubah paket atau kepemilikan restoran jika tidak diizinkan.

### Customer

- Tidak memiliki akun.
- Hanya melihat menu publik.
