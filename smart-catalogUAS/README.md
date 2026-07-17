# Smart Catalog - Sistem Manajemen Katalog Produk

- **Kelvin Maulana** - 411232020

---

## Deskripsi Aplikasi

**Smart Catalog** adalah aplikasi web manajemen katalog produk berbasis Laravel yang dirancang untuk kebutuhan UAS (Ujian Akhir Semester). Aplikasi ini memungkinkan merchant/pengelola toko untuk mengelola data kategori produk, produk, pencatatan transaksi penjualan, serta mutasi stok secara terintegrasi.

---

## Teknologi yang Digunakan

| Komponen          | Teknologi                                               |
| ----------------- | ------------------------------------------------------- |
| **Backend**       | Laravel 13.x, PHP 8.3+                                  |
| **Frontend**      | Blade Templating, Tailwind CSS, Alpine.js, Lucide Icons |
| **Database**      | MySQL / MariaDB                                         |
| **PDF Generator** | barryvdh/laravel-dompdf                                 |
| **Excel Export**  | maatwebsite/excel                                       |
| **Session**       | Database Driver                                         |
| **Auth**          | Laravel Breeze (Manual)                                 |

---

## Instalasi

```bash
# 1. Clone repository
git clone <url-repositori>
cd smart-catalogUAS

# 2. Install dependency PHP
composer install

# 3. Install dependency JS & CSS
npm install
npm run build

# 4. Copy .env
cp .env.example .env

# 5. Generate APP_KEY
php artisan key:generate

# 6. Buat database
mysql -u root -e "CREATE DATABASE IF NOT EXISTS db_kelvin_pwl;"

# 7. Import struktur database
mysql -u root db_kelvin_pwl < database/db_kelvin_pwl.sql

# 8. Jalankan seeder (untuk akun demo)
php artisan db:seed

# 9. Jalankan server
php artisan serve --port=8000
```

---

## Konfigurasi Database

Buka file `.env` dan pastikan konfigurasi database sebagai berikut:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_kelvin_pwl
DB_USERNAME=root
DB_PASSWORD=
```

---

## Akun Demo

### Akun Utama (dari Database Seeder)

| Field        | Nilai                        |
| ------------ | ---------------------------- |
| **Email**    | `developer@smartcatalog.com` |
| **Password** | `password`                   |

### Akun Tambahan (dari SQL Dump)

| #   | Email              | Password                                 |
| --- | ------------------ | ---------------------------------------- |
| 1   | `test@example.com` | `password`                               |
| 2   | `admin@gmail.com`  | _(terenkripsi - buat baru via register)_ |

---

## Fitur Aplikasi

### 1. Autentikasi (Login & Register)

| Endpoint    | Method | Fungsi                      |
| ----------- | ------ | --------------------------- |
| `/login`    | GET    | Tampilkan form login        |
| `/login`    | POST   | Proses login                |
| `/register` | GET    | Tampilkan form register     |
| `/register` | POST   | Proses registrasi akun baru |
| `/logout`   | POST   | Proses logout               |

**Validasi Register:**

- Nama: wajib diisi
- Email: wajib unik & valid
- Password: wajib mix case, angka, dan simbol

---

### 2. Manajemen Kategori (CRUD)

| Endpoint                | Method    | Fungsi                                             |
| ----------------------- | --------- | -------------------------------------------------- |
| `/categories`           | GET       | Daftar semua kategori (dengan pencarian & sorting) |
| `/categories/create`    | GET       | Form tambah kategori                               |
| `/categories`           | POST      | Simpan kategori baru                               |
| `/categories/{id}/edit` | GET       | Form edit kategori                                 |
| `/categories/{id}`      | PUT/PATCH | Update kategori                                    |
| `/categories/{id}`      | DELETE    | Hapus kategori                                     |

**Fitur:**

- Pencarian berdasarkan nama kategori
- Sorting: Terbaru, Terlama, Nama A-Z, Nama Z-A
- Upload gambar kategori
- Tampilan grid dengan efek hover

---

### 3. Manajemen Produk (CRUD)

| Endpoint                 | Method    | Fungsi                                          |
| ------------------------ | --------- | ----------------------------------------------- |
| `/products`              | GET       | Daftar semua produk (dengan pencarian & filter) |
| `/products/create`       | GET       | Form tambah produk                              |
| `/products`              | POST      | Simpan produk baru                              |
| `/products/{id}/edit`    | GET       | Form edit produk                                |
| `/products/{id}`         | PUT/PATCH | Update produk                                   |
| `/products/{id}`         | DELETE    | Hapus produk                                    |
| `/products/export/excel` | GET       | Export produk ke Excel                          |

**Fitur:**

- Pencarian berdasarkan nama produk
- Filter berdasarkan kategori
- Upload foto produk
- Stok otomatis mulai dari 0
- Indikator stok (warna hijau > 10, kuning 5-10, merah < 5)
- Export ke Excel (.xlsx)

---

### 4. Transaksi Penjualan

| Endpoint              | Method | Fungsi                          |
| --------------------- | ------ | ------------------------------- |
| `/sales`              | GET    | Daftar semua transaksi          |
| `/sales/create`       | GET    | Form tambah transaksi           |
| `/sales`              | POST   | Simpan transaksi baru           |
| `/sales/export/excel` | GET    | Export transaksi ke Excel       |
| `/sales/{id}/pdf`     | GET    | Generate & download invoice PDF |

**Logic Penjualan:**

1. Pilih produk (hanya produk dengan stok > 0 yang ditampilkan)
2. Masukkan jumlah (qty) yang ingin dijual
3. Sistem otomatis generate nomor transaksi: `TRX-YYYYMMDD-XXXXXX`
4. Sistem memeriksa ketersediaan stok sebelum transaksi
5. Jika stok cukup, transaksi dicatat dan stok produk dikurangi
6. Menggunakan database transaction (DB::transaction) untuk keamanan data
7. Nomor transaksi bersifat **unique**

---

### 5. Mutasi Stok

| Endpoint         | Method | Fungsi                   |
| ---------------- | ------ | ------------------------ |
| `/stocks`        | GET    | Daftar semua mutasi stok |
| `/stocks/create` | GET    | Form tambah mutasi stok  |
| `/stocks`        | POST   | Simpan mutasi stok baru  |

**Logic Mutasi Stok:**

1. Pilih produk dari dropdown
2. Masukkan jumlah stok yang masuk (minimal 1)
3. Sistem otomatis generate kode mutasi: `STK-YYYYMMDD-XXXXXX`
4. Stok produk otomatis **bertambah** sesuai qty yang dimasukkan
5. Kode mutasi bersifat **unique**
6. Menggunakan database transaction (DB::transaction) untuk keamanan data

---

### 6. Dashboard

| Endpoint     | Method | Fungsi                    |
| ------------ | ------ | ------------------------- |
| `/dashboard` | GET    | Tampilkan dashboard utama |

**Widget Dashboard:**

- **Total Kategori**: Jumlah kategori produk
- **Total Produk**: Jumlah produk terdaftar
- **Total Terjual**: Jumlah unit produk terjual
- **Diagram Distribusi**: Diagram pie/kategori jumlah produk per kategori
- **Produk Terlaris**: Top 5 produk berdasarkan jumlah terjual
- **Stok Menipis**: Daftar produk dengan stok < 10
- **Transaksi Terbaru**: 5 transaksi terakhir
- **Rekomendasi DSS**: Saran keputusan berdasarkan data penjualan

---

## Halaman Frontend

### Layout Utama (`layouts/app.blade.php`)

- **Sidebar Navigation**: Menu navigasi samping (Dashboard, Kategori, Produk, Transaksi, Mutasi Stok)
- **Navbar**: Header dengan tombol logout
- **Responsive**: Mendukung tampilan desktop dan mobile
- **Styling**: Tailwind CSS dengan tema gelap/terang
- **Icons**: Lucide Icons

### Halaman Login (`auth/login.blade.php`)

- Form email & password
- Link ke register
- Validasi error ditampilkan

### Halaman Register (`auth/register.blade.php`)

- Form nama, email, password, konfirmasi password
- Validasi password: mix case, angka, simbol
- Link ke login

---

## Backend & Logic

### AuthController

| Method              | Fungsi                                                      |
| ------------------- | ----------------------------------------------------------- |
| `showLogin()`       | Menampilkan halaman login                                   |
| `showRegister()`    | Menampilkan halaman register                                |
| `register(Request)` | Validasi input → Buat user baru → Redirect ke login         |
| `login(Request)`    | Validasi kredensial → Auth::attempt → Redirect ke dashboard |
| `logout(Request)`   | Auth::logout → Invalidate session → Redirect ke login       |

**Validasi Register:**

```php
'name' => 'required|string',
'email' => 'required|email|unique:users',
'password' => ['required', 'string', Password::min(8)->mixedCase()->numbers()->symbols()],
```

---

### CategoryController

| Method                      | Fungsi                                                       |
| --------------------------- | ------------------------------------------------------------ |
| `index(Request)`            | Query kategori + pencarian + sorting + withCount('products') |
| `create()`                  | Tampilkan form create                                        |
| `store(Request)`            | Validasi → Upload gambar → Simpan ke database                |
| `edit(Category)`            | Tampilkan form edit + data kategori                          |
| `update(Request, Category)` | Validasi → Ganti gambar (jika ada) → Update database         |
| `destroy(Category)`         | Hapus gambar dari storage → Hapus dari database              |

**Sorting Options:**

- `latest` (default) - Data terbaru di atas
- `oldest` - Data terlama di atas
- `name_asc` - Nama A-Z
- `name_desc` - Nama Z-A

---

### ProductController

| Method                      | Fungsi                                                        |
| --------------------------- | ------------------------------------------------------------- |
| `index(Request)`            | Query produk + pencarian + filter kategori + with('category') |
| `create()`                  | Tampilkan form create + data kategori untuk dropdown          |
| `store(Request)`            | Validasi → Upload foto → Simpan produk (stok=0)               |
| `edit(Products)`            | Tampilkan form edit + data produk + kategori                  |
| `update(Request, Products)` | Validasi → Ganti foto (jika ada) → Update produk              |
| `destroy(Products)`         | Hapus foto dari storage → Hapus produk dari database          |
| `exportExcel()`             | Generate file Excel via ProductsExport                        |

**Validasi Store Produk:**

```php
'nama_produk' => 'required|string|max:255',
'category_id' => 'required|exists:categories,id',
'harga' => 'required|integer|min:0',
'deskripsi' => 'required|string',
'foto' => 'required|image|mimes:jpg,jpeg,png|max:2048',
```

---

### SalesTransactionController

| Method             | Fungsi                                                                  |
| ------------------ | ----------------------------------------------------------------------- |
| `index()`          | Query transaksi + with('product.category') + latest                     |
| `create()`         | Tampilkan form + produk dengan stok > 0                                 |
| `store(Request)`   | Validasi → Cek stok → DB::transaction → Kurangi stok → Simpan transaksi |
| `exportExcel()`    | Generate file Excel via SalesExport                                     |
| `generatePDF($id)` | Load transaksi + relations → Generate PDF invoice                       |

**Logic Generate Nomor Transaksi:**

```php
$nomorTransaksi = 'TRX-' . Carbon::now()->format('Ymd') . '-' . strtoupper(Str::random(6));
```

**Logic Penjualan (DB Transaction):**

```php
DB::transaction(function () use ($request) {
    // 1. Buat transaksi baru
    SalesTransaction::create([...]);
    // 2. Kurangi stok produk
    $product->decrement('stok', $request->qty);
});
```

---

### StockMutationController

| Method           | Fungsi                                                   |
| ---------------- | -------------------------------------------------------- |
| `index()`        | Query mutasi stok + with('product') + latest             |
| `create()`       | Tampilkan form + data semua produk                       |
| `store(Request)` | Validasi → DB::transaction → Tambah stok → Simpan mutasi |

**Logic Generate Kode Mutasi:**

```php
$stockCode = 'STK-' . Carbon::now()->format('Ymd') . '-' . strtoupper(Str::random(6));
```

**Logic Mutasi Stok (DB Transaction):**

```php
DB::transaction(function () use ($request) {
    // 1. Buat record mutasi stok
    StockMutation::create([...]);
    // 2. Tambah stok produk
    $product->increment('stok', $request->qty);
});
```

---

## Ekspor Data

### Export Produk ke Excel

- **Route**: `GET /products/export/excel`
- **Class**: `app/Exports/ProductsExport.php`
- **Kolom**: ID, Nama Produk, Kategori, Harga, Deskripsi, Tanggal Dibuat

### Export Transaksi ke Excel

- **Route**: `GET /sales/export/excel`
- **Class**: `app/Exports/SalesExport.php`
- **Kolom**: Kode Transaksi, Tanggal, Nama Produk, Kategori, Harga Satuan, Qty, Total Pendapatan, Kode Merchant

### Generate Invoice PDF

- **Route**: `GET /sales/{id}/pdf`
- **View**: `resources/views/reports/sales_invoice.blade.php`
- **Library**: barryvdh/laravel-dompdf

---

## Route Summary

| Method | URI                      | Middleware | Fungsi                 |
| ------ | ------------------------ | ---------- | ---------------------- |
| GET    | `/`                      | web        | Redirect ke login      |
| GET    | `/login`                 | guest      | Form login             |
| POST   | `/login`                 | guest      | Proses login           |
| GET    | `/register`              | guest      | Form register          |
| POST   | `/register`              | guest      | Proses register        |
| GET    | `/dashboard`             | auth       | Dashboard utama        |
| GET    | `/categories`            | auth       | Daftar kategori        |
| GET    | `/categories/create`     | auth       | Form tambah kategori   |
| POST   | `/categories`            | auth       | Simpan kategori        |
| GET    | `/categories/{id}/edit`  | auth       | Form edit kategori     |
| PUT    | `/categories/{id}`       | auth       | Update kategori        |
| DELETE | `/categories/{id}`       | auth       | Hapus kategori         |
| GET    | `/products`              | auth       | Daftar produk          |
| GET    | `/products/create`       | auth       | Form tambah produk     |
| POST   | `/products`              | auth       | Simpan produk          |
| GET    | `/products/{id}/edit`    | auth       | Form edit produk       |
| PUT    | `/products/{id}`         | auth       | Update produk          |
| DELETE | `/products/{id}`         | auth       | Hapus produk           |
| GET    | `/products/export/excel` | auth       | Export produk Excel    |
| GET    | `/sales`                 | auth       | Daftar transaksi       |
| GET    | `/sales/create`          | auth       | Form tambah transaksi  |
| POST   | `/sales`                 | auth       | Simpan transaksi       |
| GET    | `/sales/export/excel`    | auth       | Export transaksi Excel |
| GET    | `/sales/{id}/pdf`        | auth       | Download invoice PDF   |
| GET    | `/stocks`                | auth       | Daftar mutasi stok     |
| GET    | `/stocks/create`         | auth       | Form tambah mutasi     |
| POST   | `/stocks`                | auth       | Simpan mutasi stok     |
| POST   | `/logout`                | auth       | Proses logout          |
