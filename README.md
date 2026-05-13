# Apartment Visitors Management System (AVMS)

A production-quality Laravel 12 web application for digitally managing visitor access in apartment complexes. Replaces manual visitor books with a modern, role-based digital platform.

---

## Tech Stack

| Layer | Technology |
|-------|-----------|
| Backend | Laravel 12, PHP 8+ |
| Database | MySQL (XAMPP) |
| Frontend | Blade Templates, Bootstrap 5 |
| Icons | Font Awesome 6 |
| Charts | Chart.js 4 |
| PDF Export | barryvdh/laravel-dompdf |

---

## Quick Start

### 1. Start MySQL (XAMPP)
```powershell
Start-Process "C:\xampp\mysql\bin\mysqld.exe" -ArgumentList "--standalone" -WindowStyle Hidden
```

### 2. Create the database (first time only)
```powershell
C:\xampp\mysql\bin\mysql.exe -u root -e "CREATE DATABASE IF NOT EXISTS apartment_visitors_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

### 3. Run migrations and seed
```bash
php artisan migrate:fresh --seed
```

### 4. Start the development server
```bash
php artisan serve
```

Visit: **http://127.0.0.1:8000**

---

## Demo Accounts

All accounts use the password: **`password`**

| Role | Email |
|------|-------|
| Admin | admin@avms.com |
| Security Guard | guard1@avms.com |
| Security Guard | guard2@avms.com |
| Tenant | alice@avms.com |
| Tenant | bob@avms.com |
| Tenant | clara@avms.com |

---

## Features

### Admin
- Full dashboard with live stats and Chart.js analytics
- CRUD: Apartments, Tenants, Guards, Visitors
- View all visits with filters (date, status, name)
- Monthly visitor trend charts
- PDF report export

### Security Guard
- Register visitors with photo upload
- Automatic check-in timestamp
- One-click check-out
- Active visitors monitor
- Today's logs with search

### Tenant
- Personal visitor history with filters
- Approve / Reject visitor requests
- Active visitor monitor
- Pending notification badge

---

## User Roles & Access

```
admin  → /admin/*
guard  → /guard/*
tenant → /tenant/*
```
Role middleware (`RoleMiddleware`) enforces access on every route group.

---

## Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/   (Dashboard, Apartment, Tenant, Guard, Visitor, Report)
│   │   ├── Guard/   (Dashboard, Visitor, Visit)
│   │   └── Tenant/  (Dashboard, Visit)
│   └── Middleware/
│       └── RoleMiddleware.php
├── Models/
│   ├── User.php        (hasOne Tenant)
│   ├── Apartment.php   (hasMany Tenants)
│   ├── Tenant.php      (belongsTo User, Apartment; hasMany Visits)
│   ├── Visitor.php     (hasMany Visits)
│   └── Visit.php       (belongsTo Visitor, Tenant)
database/
├── migrations/         (users, apartments, tenants, visitors, visits)
└── seeders/
    └── DatabaseSeeder.php
resources/views/
├── admin/              (dashboard, apartments, tenants, guards, visitors, visits, reports)
├── guard/              (dashboard, visitors, visits)
├── tenant/             (dashboard, visits)
├── layouts/
│   ├── dashboard.blade.php      (main sidebar layout)
│   └── partials/                (sidebar-admin, sidebar-guard, sidebar-tenant)
└── auth/login.blade.php         (custom premium login page)
routes/
├── web.php             (admin, guard, tenant route groups)
└── auth.php            (login/logout only — registration disabled)
```

---

## Environment

Key `.env` values:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=apartment_visitors_db
DB_USERNAME=root
DB_PASSWORD=
```

---

## Security

- CSRF protection on all forms
- Bcrypt password hashing
- Role-based middleware on every route group
- Public registration disabled — users created by admin only
- File upload validation (image/jpeg, image/png, max 2MB)

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
