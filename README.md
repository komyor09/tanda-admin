# Tanda Admin Panel

Admin panel for education aggregator platform.

## Stack
- Laravel 11
- Filament v3
- MySQL
- Spatie Permission (RBAC)

## Setup

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```

## Admin panel доступна по адресу:

/admin
Roles

- superadmin
- admin
- partner

MVP stage – Architecture & Core setup

