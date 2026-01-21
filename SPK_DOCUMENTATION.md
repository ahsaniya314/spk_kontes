# Dokumentasi Sistem Pendukung Keputusan (SPK) Penilaian Kontes Unggas

## Overview
Sistem ini dibangun menggunakan Laravel Framework dengan implementasi metode SMART (Simple Multi-Attribute Rating Technique) untuk penilaian kontes unggas.

## Struktur Database (ERD)

### Tabel-tabel Utama:

1. **users**
   - id (PK)
   - name
   - email (unique)
   - password
   - role (enum: 'admin', 'juri')
   - timestamps

2. **categories**
   - id (PK)
   - name
   - description
   - timestamps

3. **criteria**
   - id (PK)
   - category_id (FK → categories.id)
   - name
   - description
   - weight (decimal) - Bobot kriteria (Wi)
   - type (enum: 'benefit', 'cost')
   - timestamps

4. **alternatives**
   - id (PK)
   - name
   - code (unique)
   - description
   - timestamps

5. **ratings**
   - id (PK)
   - criterion_id (FK → criteria.id)
   - alternative_id (FK → alternatives.id)
   - user_id (FK → users.id) - ID Juri yang memberikan penilaian
   - value (decimal) - Nilai penilaian
   - timestamps
   - Unique constraint: (criterion_id, alternative_id, user_id)

## Relasi Eloquent Models

### Category Model
- `hasMany(Criterion::class)` → criteria()

### Criterion Model
- `belongsTo(Category::class)` → category()
- `hasMany(Rating::class)` → ratings()

### Alternative Model
- `hasMany(Rating::class)` → ratings()

### Rating Model
- `belongsTo(Criterion::class)` → criterion()
- `belongsTo(Alternative::class)` → alternative()
- `belongsTo(User::class)` → user()

### User Model
- `hasMany(Rating::class)` → ratings()
- Helper methods: `isAdmin()`, `isJuri()`

## Authorization (Gates & Policies)

### Gates (Defined in AuthServiceProvider):
- `manage-criteria` - Hanya Admin
- `manage-categories` - Hanya Admin
- `input-rating` - Hanya Juri
- `view-results` - Admin dan Juri

### Policies:
- `CriterionPolicy` - Mengatur akses CRUD kriteria (hanya Admin)

## Service Layer: SmartCalculationService

### Metode Utama:

1. **normalize(Collection $alternatives, Collection $criteria): array**
   - Menghitung normalisasi U(Xij)
   - Benefit: U(Xij) = Xij / Xmax
   - Cost: U(Xij) = Xmin / Xij
   - Menggunakan rata-rata penilaian dari semua Juri

2. **calculateFinalValues(Collection $alternatives, Collection $criteria, array $normalized): array**
   - Menghitung nilai akhir Vj = Σ(Wi * U(Xij))

3. **rank(Collection $alternatives, array $finalValues): Collection**
   - Merangking alternatif berdasarkan nilai akhir (descending)

4. **calculate(Collection $alternatives, Collection $criteria): array**
   - Metode utama yang menggabungkan semua perhitungan

## Routes & Controllers

### Routes (web.php):
- `/login` - Halaman login
- `/dashboard` - Dashboard (berbeda untuk Admin dan Juri)
- `/categories` - CRUD Kategori (Admin only)
- `/criteria` - CRUD Kriteria (Admin only)
- `/alternatives` - CRUD Alternatif (Juri & Admin)
- `/ratings` - CRUD Penilaian (Juri only)
- `/results` - Lihat hasil perhitungan SMART (Admin & Juri)

### Controllers:
- `AuthController` - Login/Logout
- `DashboardController` - Dashboard berdasarkan role
- `CategoryController` - Resource controller untuk Kategori
- `CriterionController` - Resource controller untuk Kriteria
- `AlternativeController` - Resource controller untuk Alternatif
- `RatingController` - CRUD Penilaian
- `ResultController` - Menampilkan hasil perhitungan SMART

## Form Request Validation

Semua Form Request menggunakan authorization check:
- `StoreCategoryRequest` / `UpdateCategoryRequest`
- `StoreCriterionRequest` / `UpdateCriterionRequest`
- `StoreAlternativeRequest` / `UpdateAlternativeRequest`
- `StoreRatingRequest`

## Alur Proses Perhitungan SMART

1. **Input Data** (View)
   - Juri menginput penilaian melalui form
   - Data disimpan ke tabel `ratings`

2. **Controller** (RatingController)
   - Menerima request dari form
   - Validasi menggunakan Form Request
   - Menyimpan data ke database

3. **Service Layer** (SmartCalculationService)
   - Controller memanggil `SmartCalculationService::calculate()`
   - Service melakukan:
     a. Normalisasi nilai (menggunakan rata-rata Juri 2 & 3)
     b. Perhitungan nilai akhir Vj
     c. Perangkingan alternatif

4. **Model** (Eloquent)
   - Data disimpan dan diambil menggunakan Eloquent ORM
   - Relasi antar model memudahkan query data

5. **View** (Blade Template)
   - Menampilkan hasil perhitungan dan ranking

## Daftar Halaman & Controller

| URL | Controller | Method | Role | Deskripsi |
|-----|-----------|--------|------|-----------|
| `/login` | AuthController | showLoginForm | Guest | Halaman login |
| `/dashboard` | DashboardController | index | Auth | Dashboard sesuai role |
| `/categories` | CategoryController | index | Admin | Daftar kategori |
| `/categories/create` | CategoryController | create | Admin | Form tambah kategori |
| `/categories` | CategoryController | store | Admin | Simpan kategori baru |
| `/criteria` | CriterionController | index | Admin | Daftar kriteria |
| `/criteria/create` | CriterionController | create | Admin | Form tambah kriteria |
| `/criteria` | CriterionController | store | Admin | Simpan kriteria baru |
| `/alternatives` | AlternativeController | index | Auth | Daftar alternatif |
| `/alternatives/create` | AlternativeController | create | Juri/Admin | Form tambah alternatif |
| `/ratings` | RatingController | index | Juri | Daftar penilaian saya |
| `/ratings/create` | RatingController | create | Juri | Form input penilaian |
| `/ratings` | RatingController | store | Juri | Simpan penilaian |
| `/results` | ResultController | index | Auth | Hasil perhitungan SMART |

## Setup & Instalasi

1. **Install Dependencies**
   ```bash
   composer install
   npm install
   ```

2. **Setup Environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

3. **Setup Database**
   - Konfigurasi database di `.env`
   - Jalankan migrations:
     ```bash
     php artisan migrate
     ```

4. **Seed Data Awal**
   ```bash
   php artisan db:seed
   ```
   
   Data default:
   - Admin: admin@kontess.test / password
   - Juri 1: juri1@kontess.test / password
   - Juri 2: juri2@kontess.test / password
   - Juri 3: juri3@kontess.test / password

5. **Run Development Server**
   ```bash
   php artisan serve
   ```

## Fitur Utama

1. **Manajemen Akun & Hak Akses**
   - Role-based access control (Admin & Juri)
   - Authentication menggunakan Laravel default

2. **Manajemen Kategori & Kriteria**
   - Admin dapat CRUD kategori dan kriteria
   - Set bobot (weight) untuk setiap kriteria
   - Tipe kriteria: Benefit atau Cost

3. **Manajemen Alternatif**
   - Juri dan Admin dapat menambah alternatif
   - Setiap alternatif memiliki kode unik

4. **Input Penilaian**
   - Juri dapat memberikan penilaian untuk setiap kriteria dan alternatif
   - Sistem menghitung rata-rata penilaian dari Juri 2 dan Juri 3

5. **Perhitungan SMART**
   - Normalisasi nilai
   - Perhitungan nilai akhir
   - Perangkingan alternatif

6. **Hasil & Laporan**
   - Menampilkan hasil perhitungan SMART
   - Ranking alternatif berdasarkan nilai akhir

## Catatan Penting

- Sistem menggunakan rata-rata penilaian dari semua Juri (role='juri') untuk perhitungan
- Bobot kriteria harus diatur dengan benar (total tidak harus 100, tapi disarankan)
- Setiap Juri hanya bisa memberikan satu penilaian per kriteria per alternatif
- Unique constraint pada tabel ratings mencegah duplikasi penilaian

