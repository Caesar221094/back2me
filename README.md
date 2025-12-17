Back2Me scaffold
=================

This folder contains scaffold files and instructions to create a new Laravel app for the "Back2Me" lost & found system.

Quick setup (Windows, `cmd.exe`):

1. Create a new Laravel project:

```cmd
composer create-project laravel/laravel back2me
cd back2me
```

2. Install Breeze (simple auth):

```cmd
composer require laravel/breeze --dev
php artisan breeze:install blade
npm install
npm run dev
php artisan migrate
```

3. Copy scaffold files from this folder into the new project (merge `app/`, `database/`, `routes/`, `resources/views/`).

4. Run migrations & seeders:

```cmd
php artisan migrate
php artisan db:seed --class=Back2MeSeeder
```

5. Create storage symlink for uploaded photos:

```cmd
php artisan storage:link
```

Notes:
- Roles are implemented using a simple `role` column on `users` (`superadmin`, `petugas`, `user`).
- Upload rules: images only, max 5 MB, up to 5 images per report.
- Notifications are in-app (stored in `notifications` table) and displayed on the dashboard.

If you want, I can automate applying these files into a fresh Laravel install, run composer, and execute migrations & tests.

Automated bootstrap (Windows):

```cmd
cd <repo-root>
scripts\bootstrap-back2me.bat
```

Notes: the script will check `php`, `composer`, and `npm` are available in PATH, create a `back2me` folder, copy the scaffold files, install Breeze, build assets, run migrations & seeders, create the storage link, and run tests.
