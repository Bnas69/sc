# Smart Catalog

**Kelvin Maulana - 411232020**
**Septian Dwi Saputra - 411232056**

---

## Penjelasan

Aplikasi manajemen katalog produk untuk UAS PWL dengan fitur CRUD, transaksi penjualan, mutasi stok, dan ekspor data.

---

## Stack / Teknis

| Komponen | Teknologi |
|---|---|
| Bahasa Pemrograman | PHP 8.3+, JavaScript |
| Framework | Laravel 13.x |
| Frontend | Blade, Tailwind CSS, Alpine.js |
| Database | MySQL / MariaDB (Laravel Eloquent API) |
| AI Recommendation | OpenAI API |
| PDF Generator | barryvdh/laravel-dompdf |
| Excel Export | maatwebsite/excel |

---

## Flow Aplikasi

```
Login / Register
       │
       ▼
   Dashboard
       │
       ├──> Kategori (CRUD)
       │
       ├──> Produk (CRUD + Export Excel)
       │
       ├──> Transaksi Penjualan (CRUD + Export PDF/Excel)
       │
       ├──> Mutasi Stok (CRUD)
       │
       └──> Logout
```

---

## Akun Demo

| Email | Password |
|---|---|
| `developer@smartcatalog.com` | `password` |
| `test@example.com` | `password` |

---

## Instalasi

```bash
git clone https://github.com/Bnas69/sc.git
cd sc/smart-catalogUAS

composer install
npm install && npm run build

cp .env.example .env
php artisan key:generate

mysql -u root -e "CREATE DATABASE IF NOT EXISTS db_kelvin_pwl;"
mysql -u root db_kelvin_pwl < database/db_kelvin_pwl.sql
php artisan db:seed

php artisan serve
```

Buka **http://localhost:8000** di browser.

---

**Smart Catalog** © 2026 - UAS PWL
