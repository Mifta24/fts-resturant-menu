# Risk List (Draft)

Draft awal untuk Phase 0. Update setelah validasi pasar dan progres development.

| # | Risiko | Kategori | Dampak | Mitigasi Awal |
|---|---|---|---|---|
| 1 | Restoran enggan pindah dari menu cetak/PDF | Product-market fit | Tinggi | Free plan tanpa batas waktu, onboarding dibantu tim FTS |
| 2 | Harga langganan dianggap terlalu mahal | Pricing | Tinggi | Validasi harga lewat wawancara (lihat FEATURES_AND_PRICING.md) sebelum public launch |
| 3 | Kebocoran data antar-tenant (restoran A lihat data restoran B) | Security | Kritis | Policy + tenant scoping wajib di setiap query, test isolasi tenant |
| 4 | Ketergantungan koneksi internet saat pelanggan scan QR | Teknis | Sedang | Cache halaman menu publik, optimasi loading |
| 5 | Storage foto menu membengkak | Biaya infrastruktur | Sedang | Limit ukuran upload + compression per paket |
| 6 | Proses approval pembayaran manual lambat | Operasional | Sedang | SLA internal admin, notifikasi otomatis |
| 7 | Tim kecil, kapasitas development terbatas | Eksekusi | Tinggi | Prioritaskan sesuai Development Prioritization Rule di ROADMAP.md |
| 8 | Pilot restoran churn setelah masa gratis pilot habis | Retention | Tinggi | Kumpulkan feedback aktif selama pilot, tunjukkan value sebelum masa pilot berakhir |

## Status

- [ ] Direview ulang tiap akhir fase
- [ ] Risiko baru ditambahkan saat ditemukan
