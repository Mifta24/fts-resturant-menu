# Development Roadmap

Roadmap berbasis fase. Durasi detail harus ditentukan setelah scope dan kapasitas tim disepakati.

## Phase 0 — Validation dan Planning

Deliverables:

- Final product scope.
- User personas.
- Pricing hypothesis.
- Wireframe.
- Database draft.
- Risk list.
- Daftar restoran pilot.

Validation target:

- Wawancara minimal 5 restoran.
- Identifikasi masalah menu saat ini.
- Uji minat terhadap harga.
- Tentukan fitur yang benar-benar wajib.

## Phase 1 — Internal Prototype

Tujuan: menunjukkan alur utama kepada Mr. Yoshi dan tim.

Scope:

- Login sederhana.
- Satu atau beberapa restoran demo.
- Profil restoran.
- CRUD kategori.
- CRUD menu.
- Public menu URL.
- QR code.
- Responsive mobile page.

Belum untuk publik:

- Payment.
- Advanced authorization.
- Full subscription automation.
- Production hardening.

## Phase 2 — MVP Foundation

Scope:

- Registration dan email verification.
- Multi-tenant membership.
- Restaurant onboarding.
- Package model.
- Plan limit enforcement.
- Manual payment flow.
- Admin dashboard.
- File validation dan compression.
- Policies dan tenant isolation tests.
- Staging deployment.

## Phase 3 — Pilot Release

Scope:

- 3–5 restoran pilot.
- Assisted menu setup.
- Feedback collection.
- Bug fixing.
- Usage observation.
- Pricing validation.
- Basic analytics.

Success criteria:

- Restoran dapat mengelola menu tanpa bantuan developer.
- QR bekerja stabil.
- Tidak ada kebocoran data tenant.
- Restoran melihat manfaat dibanding menu PDF.
- Minimal beberapa pilot bersedia melanjutkan ke paket berbayar.

## Phase 4 — Public Launch

Scope:

- Landing page.
- Pricing page.
- Terms dan privacy.
- Stable onboarding.
- Production monitoring.
- Backup dan restore process.
- Subscription reminder.
- Customer support workflow.

## Phase 5 — Growth Features

Prioritas berdasarkan feedback:

- More themes.
- Multilingual menu.
- Better analytics.
- Team member management.
- Custom domain.
- Import menu dari spreadsheet.
- Bulk image upload.
- Annual billing.
- Automated payment gateway.

## Phase 6 — Restaurant Operations Expansion

Hanya setelah core QR menu terbukti:

- WhatsApp ordering.
- Table ordering.
- Customer payment.
- QRIS integration through official provider.
- Kitchen display.
- POS integration.
- Reservation.
- Loyalty.
- AI translation.
- AI recommendation.

## Product Metrics

Pantau:

- Total registered restaurants.
- Activated restaurants.
- Published menus.
- Weekly active restaurants.
- Free-to-paid conversion.
- Monthly recurring revenue.
- Churn.
- Average menu items per restaurant.
- Menu scans.
- Support requests.
- Storage usage.

## Development Prioritization Rule

Setiap fitur baru harus menjawab salah satu pertanyaan:

1. Apakah fitur meningkatkan aktivasi restoran?
2. Apakah fitur meningkatkan conversion ke paket berbayar?
3. Apakah fitur mengurangi churn?
4. Apakah fitur mengurangi support manual?
5. Apakah fitur diminta oleh beberapa pelanggan nyata?

Jika tidak, fitur tersebut tidak menjadi prioritas awal.
