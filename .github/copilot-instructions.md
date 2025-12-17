# Back2Me - AI Coding Instructions

This is a Laravel 12 lost & found web application with role-based access control. The application uses Laravel Breeze for authentication, Vite for asset bundling, and Tailwind CSS 4 for styling.

## Project Structure & Architecture

- **Main feature routes**: [routes/back2me.php](../routes/back2me.php) defines all `/back2me/*` endpoints (included in `routes/web.php`)
- **Role-based access**: Simple role column on users table (`superadmin`, `petugas`, `user`) enforced by [app/Http/Middleware/EnsureRole.php](../app/Http/Middleware/EnsureRole.php)
- **Middleware registration**: Laravel 11+ style - middleware alias `role` registered in [bootstrap/app.php](../bootstrap/app.php) `withMiddleware()` callback
- **Reports workflow**: Users create reports → users can claim reports → petugas verify/change status → users confirm receipt → in-app notifications

## Key Models & Relationships

- **User**: Has `role` and `is_banned` columns. Roles: `superadmin`, `petugas`, `user`
- **Report**: Belongs to User and Category. Fields: `judul`, `deskripsi`, `lokasi`, `foto` (JSON array), `status` (enum: pending/diproses/selesai/ditolak), `claimed_by`, `claimed_at`, `confirmed_by`, `confirmed_at`
- **Category**: Lookup table with `nama` and `deskripsi` fields

## Role-Based Access Patterns

Use middleware syntax: `->middleware('role:superadmin|petugas')` for multiple roles or `->middleware('role:petugas')` for single role.

**Role hierarchy:**
- `superadmin`: User management, category management, system settings, report export
- `petugas`: Verify reports, change status, view claims
- `user`: Create/claim/edit reports, confirm receipt, search/filter

Banned users (`is_banned = true`) are blocked by [EnsureRole](../app/Http/Middleware/EnsureRole.php) middleware.

## Feature Implementation

### SuperAdmin Features
- **User Management**: [Admin/UserController.php](../app/Http/Controllers/Admin/UserController.php) - CRUD users, reset password, ban/unban
- **Category Management**: [Admin/CategoryController.php](../app/Http/Controllers/Admin/CategoryController.php) - CRUD categories
- **System Settings**: [Admin/SettingsController.php](../app/Http/Controllers/Admin/SettingsController.php) - Upload limits, claim timeouts (stored in cache)
- **Report Export**: [Admin/ReportExportController.php](../app/Http/Controllers/Admin/ReportExportController.php) - Monthly/yearly CSV exports with statistics

### Petugas Features
- **Verify Reports**: [ReportController::verify](../app/Http/Controllers/ReportController.php) - Change status (diproses/selesai/ditolak)
- **View Claims**: Access all reports with filter by status

### User Features
- **Create Reports**: Max 5 images, 5MB each → `storage/app/public/reports/`
- **Search/Filter**: By keyword, category, location, status
- **Claim Items**: [ReportController::claim](../app/Http/Controllers/ReportController.php)
- **Edit Reports**: Only when status is `pending`
- **Confirm Receipt**: [ReportController::confirmReceipt](../app/Http/Controllers/ReportController.php) - After petugas approves
- **Notifications**: Database-only via [app/Notifications/](../app/Notifications/)

## File Upload Convention

Reports support up to 5 images, max 5MB each. Validation rule: `'foto.*' => 'nullable|image|max:5120'`

Files stored in `storage/app/public/reports/` via `$file->store('reports','public')`. The `foto` column is cast to array in [Report model](../app/Models/Report.php).

Must run `php artisan storage:link` after setup to create public symlink.

## Testing Patterns

All feature tests use `RefreshDatabase` and seed with [Back2MeSeeder](../database/seeders/Back2MeSeeder.php):
```php
$this->seed(\Database\Seeders\Back2MeSeeder::class);
```

Seeder creates:
- Superadmin: `admin@back2me.test` / `password123`
- Petugas: `petugas@back2me.test` / `password123`
- 5 regular users + sample categories and report

See [tests/Feature/](../tests/Feature/) for test examples.

## Development Workflow

**Setup**: `composer run setup` (installs deps, generates key, migrates DB, builds assets) or use `setup-database.bat` for automatic MySQL setup

**Dev server**: `composer run dev` (runs 4 concurrent processes: server, queue worker, pail logs, vite dev server)

**Testing**: `composer run test` (clears config cache and runs PHPUnit)

**Manual commands:**
```bash
php artisan migrate
php artisan db:seed --class=Back2MeSeeder
php artisan storage:link
php artisan test
```

## Database Configuration

- **Default**: MySQL (configured in `.env`)
- **Connection**: `DB_CONNECTION=mysql`, database name `back2me`
- **Setup Script**: Run `setup-database.bat` for automatic database creation (detects XAMPP/standalone MySQL)
- **Manual Setup**: See [SETUP.md](../SETUP.md) for phpMyAdmin instructions

## Important Notes

- **Routes**: Already loaded via `require __DIR__.'/back2me.php';` in [routes/web.php](../routes/web.php)
- **Middleware**: Already registered in [bootstrap/app.php](../bootstrap/app.php)
- **Notifications**: Database-only (no email/SMS). Check `notifications` table for in-app messages.
- **Report editing**: Only allowed when status is `pending` (see [ReportController::edit](../app/Http/Controllers/ReportController.php))
- **Confirmation workflow**: User claims → Petugas verifies (selesai) → User confirms receipt → Complete

## Testing Guide

See [TESTING.md](../TESTING.md) for comprehensive step-by-step testing guide covering all roles and features.

