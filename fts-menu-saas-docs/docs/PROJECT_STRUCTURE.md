# Project Structure

Dokumen ini menggunakan struktur Laravel modular sederhana. Nama folder dapat disesuaikan ketika implementasi dimulai.

## 1. Struktur Repository

```text
fts-menu-saas/
├── app/
│   ├── Actions/
│   ├── Console/
│   ├── Enums/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   ├── Restaurant/
│   │   │   └── PublicMenuController.php
│   │   ├── Middleware/
│   │   ├── Requests/
│   │   └── Resources/
│   ├── Models/
│   ├── Notifications/
│   ├── Policies/
│   ├── Providers/
│   ├── Queries/
│   ├── Services/
│   └── Support/
├── bootstrap/
├── config/
├── database/
│   ├── factories/
│   ├── migrations/
│   └── seeders/
├── public/
├── resources/
│   ├── css/
│   ├── js/
│   └── views/
│       ├── admin/
│       ├── auth/
│       ├── components/
│       ├── layouts/
│       ├── public-menu/
│       └── restaurant/
├── routes/
│   ├── web.php
│   ├── admin.php
│   ├── restaurant.php
│   └── api.php
├── storage/
├── tests/
│   ├── Feature/
│   └── Unit/
├── .env.example
├── composer.json
├── package.json
└── README.md
```

## 2. Models

```text
User
Restaurant
RestaurantUser
Category
MenuItem
Package
Subscription
Payment
MenuView
Media
AuditLog
```

## 3. Controller Groups

### Public

```text
PublicMenuController
PublicRestaurantController
```

### Restaurant Dashboard

```text
DashboardController
RestaurantProfileController
CategoryController
MenuItemController
QrCodeController
SubscriptionController
StatisticController
TeamMemberController
```

### Admin FTS

```text
AdminDashboardController
AdminRestaurantController
AdminUserController
AdminPackageController
AdminSubscriptionController
AdminPaymentController
AdminAuditLogController
```

## 4. Service Layer

Service digunakan untuk logika yang lebih kompleks agar controller tetap tipis.

```text
TenantContextService
SlugService
QrCodeService
ImageService
SubscriptionService
PlanLimitService
PaymentVerificationService
MenuAnalyticsService
```

## 5. Policies

```text
RestaurantPolicy
CategoryPolicy
MenuItemPolicy
SubscriptionPolicy
PaymentPolicy
TeamMemberPolicy
```

Setiap policy harus memeriksa apakah resource berasal dari restoran yang dapat diakses pengguna.

## 6. Form Requests

```text
StoreRestaurantRequest
UpdateRestaurantRequest
StoreCategoryRequest
UpdateCategoryRequest
StoreMenuItemRequest
UpdateMenuItemRequest
UploadPaymentProofRequest
InviteRestaurantMemberRequest
```

## 7. Views

```text
resources/views/public-menu/
├── show.blade.php
├── partials/
│   ├── header.blade.php
│   ├── category-nav.blade.php
│   ├── menu-card.blade.php
│   └── social-links.blade.php

resources/views/restaurant/
├── dashboard.blade.php
├── profile/
├── categories/
├── menu-items/
├── qr-code/
├── subscription/
└── statistics/

resources/views/admin/
├── dashboard.blade.php
├── restaurants/
├── users/
├── packages/
├── subscriptions/
└── payments/
```

## 8. Naming Convention

- Table: plural snake_case.
- Model: singular PascalCase.
- Route name: dot notation.
- Slug: lowercase kebab-case.
- Enum value: lowercase snake_case.
- Storage path: tenant-based prefix.

Contoh:

```text
restaurants/12/logo.webp
restaurants/12/menu-items/184/thumbnail.webp
restaurants/12/payments/payment-2026-07.webp
```
