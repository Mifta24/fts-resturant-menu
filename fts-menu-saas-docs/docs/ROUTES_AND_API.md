# Routes dan API

## 1. Public Web Routes

```text
GET  /                              Landing page
GET  /pricing                       Pricing page
GET  /terms                         Terms of service
GET  /privacy                       Privacy policy
GET  /{restaurantSlug}              Public menu
```

Slug reserved words harus dicegah, misalnya:

```text
admin
login
register
pricing
dashboard
api
terms
privacy
```

## 2. Authentication Routes

```text
GET  /login
POST /login
POST /logout
GET  /register
POST /register
GET  /forgot-password
POST /forgot-password
GET  /reset-password/{token}
POST /reset-password
GET  /email/verify
```

## 3. Restaurant Dashboard Routes

```text
GET    /dashboard
GET    /dashboard/profile
PATCH  /dashboard/profile

GET    /dashboard/categories
POST   /dashboard/categories
PATCH  /dashboard/categories/{category}
DELETE /dashboard/categories/{category}
POST   /dashboard/categories/reorder

GET    /dashboard/menu-items
POST   /dashboard/menu-items
GET    /dashboard/menu-items/{menuItem}/edit
PATCH  /dashboard/menu-items/{menuItem}
DELETE /dashboard/menu-items/{menuItem}
POST   /dashboard/menu-items/reorder
PATCH  /dashboard/menu-items/{menuItem}/availability

GET    /dashboard/qr-code
POST   /dashboard/qr-code/download

GET    /dashboard/subscription
POST   /dashboard/subscription/select-package
POST   /dashboard/subscription/upload-payment

GET    /dashboard/statistics
```

## 4. Admin Routes

```text
GET    /admin
GET    /admin/restaurants
GET    /admin/restaurants/{restaurant}
PATCH  /admin/restaurants/{restaurant}/status

GET    /admin/packages
POST   /admin/packages
PATCH  /admin/packages/{package}

GET    /admin/subscriptions
PATCH  /admin/subscriptions/{subscription}

GET    /admin/payments
GET    /admin/payments/{payment}
POST   /admin/payments/{payment}/approve
POST   /admin/payments/{payment}/reject
```

## 5. Optional JSON API

MVP server-rendered tidak wajib memiliki public API. API dapat ditambahkan untuk:

- Mobile app.
- Separate frontend.
- Partner integration.
- Ordering system.

Contoh future API:

```text
GET /api/v1/restaurants/{slug}
GET /api/v1/restaurants/{slug}/categories
GET /api/v1/restaurants/{slug}/menu-items
```

## 6. Route Security

- Dashboard routes wajib memakai authentication middleware.
- Admin routes wajib memakai super-admin authorization.
- Resource route model binding wajib divalidasi terhadap active tenant.
- Jangan menerima `restaurant_id` bebas dari form untuk menentukan ownership.
- Public routes hanya mengembalikan data yang memang public.

## 7. Response Behavior

### Restaurant not found

```text
404 Not Found
```

### Restaurant inactive or expired

Tampilkan halaman khusus tanpa membocorkan detail internal subscription.

### Plan limit reached

```json
{
  "message": "Plan limit reached.",
  "upgrade_required": true
}
```

### Unauthorized tenant access

Gunakan `404` atau `403` sesuai kebijakan keamanan aplikasi, tanpa membuka informasi tenant lain.
