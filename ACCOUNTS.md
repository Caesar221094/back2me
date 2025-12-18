# Akun Testing Back2Me

Password semua akun: **password123**

## SuperAdmin
- Email: admin@back2me.test
- Password: password123
- Akses: Full admin panel (users, categories, settings, export)

## Petugas
- Email: petugas@back2me.test
- Password: password123
- Akses: Verify reports

## Users Reguler

### Budi Santoso
- Email: budi@back2me.test
- Password: password123
- Role: user

### Siti Rahayu
- Email: siti@back2me.test
- Password: password123
- Role: user

### Andi Wijaya
- Email: andi@back2me.test
- Password: password123
- Role: user

### Dewi Lestari
- Email: dewi@back2me.test
- Password: password123
- Role: user

### Rudi Hartono
- Email: rudi@back2me.test
- Password: password123
- Role: user

---

## Cara Test Login

1. Jalankan server: `php artisan serve`
2. Buka: http://localhost:8000
3. Login dengan salah satu email di atas
4. Password: **password123**

## Jika Login Gagal

Jalankan ulang seeder:
```bash
php artisan migrate:fresh --seed
```

Atau manual seed:
```bash
php artisan db:seed --class=Back2MeSeeder
```
