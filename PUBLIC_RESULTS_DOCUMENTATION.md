# Dokumentasi Halaman Hasil Publik - SPK Kontes Unggas

## Overview
Halaman publik ini menampilkan hasil kontes unggas secara visual dan menarik tanpa memerlukan login. Halaman ini dapat diakses oleh siapa saja untuk melihat hasil penilaian dan peringkat final.

## URL Akses
- **Route:** `/` atau `/hasil`
- **Controller:** `PublicResultController`
- **View:** `resources/views/public/results.blade.php`
- **Layout:** `resources/views/layouts/public.blade.php`

## Komponen Halaman

### 1. Ranking Board (Papan Peringkat)
**Lokasi:** Bagian tengah halaman setelah podium

**Fitur:**
- Tabel lengkap semua alternatif yang dinilai
- Kolom: Peringkat (#), Kode, Nama Alternatif, Skor Total (Vj), Tombol Detail
- Penanda visual untuk 3 teratas:
  - 👑 untuk Juara 1 (warna emas)
  - 🥈 untuk Juara 2 (warna perak)
  - 🥉 untuk Juara 3 (warna perunggu)
- Highlight baris untuk 3 teratas dengan background kuning

**Data Source:**
- `$ranked` - Collection dari `SmartCalculationService::rank()`
- Setiap item berisi: `rank`, `alternative`, `final_value`

### 2. Top Winner Spotlight (Pemenang Utama)
**Lokasi:** Setelah podium, sebelum ranking board

**Fitur:**
- Section khusus dengan gradient emas untuk Juara 1
- Menampilkan:
  - Ikon mahkota (👑)
  - Nama alternatif
  - Kode alternatif
  - Skor total akhir dalam box khusus
  - Deskripsi (jika ada)

**Data Source:**
- `$ranked[0]` - Alternatif dengan ranking tertinggi

### 3. Podium Visualisasi (Top 3)
**Lokasi:** Bagian atas halaman

**Fitur:**
- Visualisasi podium dengan tinggi berbeda:
  - Peringkat 1: Tinggi 200px (tertinggi)
  - Peringkat 2: Tinggi 150px
  - Peringkat 3: Tinggi 120px
- Setiap podium menampilkan:
  - Ikon medali (👑, 🥈, 🥉)
  - Nama alternatif
  - Skor total
- Background gradient untuk setiap podium

### 4. Visualisasi Data (Grafik)

#### A. Grafik Batang (Bar Chart)
**Library:** Chart.js v4.4.0

**Fitur:**
- Menampilkan kontribusi setiap kriteria terhadap skor total
- Data: `Wi × U(Xij)` untuk setiap kriteria
- Tooltip menampilkan:
  - Kontribusi skor
  - Nilai normalisasi
  - Bobot kriteria

**Struktur Data:**
```javascript
{
    labels: ['Kriteria 1', 'Kriteria 2', ...],
    datasets: [{
        label: 'Kontribusi Skor (Wi × U(Xij))',
        data: [contribution1, contribution2, ...]
    }]
}
```

#### B. Grafik Radar (Radar Chart)
**Library:** Chart.js v4.4.0

**Fitur:**
- Perbandingan performa alternatif pada setiap kriteria
- Visualisasi berbentuk jaring laba-laba
- Menunjukkan kekuatan dan kelemahan di setiap kriteria

**Struktur Data:**
```javascript
{
    labels: ['Kriteria 1', 'Kriteria 2', ...],
    datasets: [{
        label: 'Nama Alternatif',
        data: [contribution1, contribution2, ...]
    }]
}
```

**Selector:**
- Dropdown untuk memilih alternatif yang akan ditampilkan
- Grafik update secara dinamis saat alternatif dipilih

### 5. Tabel Detail Penilaian
**Lokasi:** Setelah grafik

**Fitur:**
- Tabel lengkap dengan:
  - Nama alternatif
  - Nilai normalisasi (U) untuk setiap kriteria
  - Kontribusi skor (Wi × U(Xij)) untuk setiap kriteria
  - Total skor akhir (Vj)
- Highlight untuk 3 teratas

### 6. Tabel Detail Penilaian Juri
**Lokasi:** Bagian bawah halaman

**Fitur:**
- Menampilkan penilaian dari:
  - **Juri 1:** Nilai langsung dari Juri 1
  - **Rata-rata Juri 2 & 3:** Rata-rata nilai dari Juri 2 dan Juri 3
- Dikelompokkan per alternatif
- Menampilkan nilai untuk setiap kriteria

## Struktur Data untuk Grafik

### Contribution Data Structure
Data disiapkan oleh `PublicResultController::prepareContributionData()`

```php
[
    [
        'name' => 'Unggas A',
        'code' => 'UGA001',
        'criteria' => [
            [
                'name' => 'Bentuk Tubuh',
                'category' => 'Penampilan Fisik',
                'weight' => 25.00,
                'normalized' => 0.85,
                'contribution' => 21.25  // weight * normalized
            ],
            // ... more criteria
        ]
    ],
    // ... more alternatives
]
```

### JSON Output untuk JavaScript
Data dikonversi ke JSON menggunakan `@json()` directive:
```javascript
const contributionData = [
    {
        name: "Unggas A",
        code: "UGA001",
        criteria: [
            {
                name: "Bentuk Tubuh",
                category: "Penampilan Fisik",
                weight: 25.00,
                normalized: 0.85,
                contribution: 21.25
            }
        ]
    }
];
```

## Laravel Package untuk Grafik

### Chart.js (Recommended)
**Package:** Chart.js v4.4.0
**CDN:** `https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js`

**Keuntungan:**
- Ringan dan cepat
- Mudah digunakan
- Mendukung berbagai jenis grafik (Bar, Radar, Line, Pie, dll)
- Responsif dan interaktif
- Dokumentasi lengkap

**Alternatif:**
1. **ApexCharts** - Lebih modern, lebih banyak fitur
   - CDN: `https://cdn.jsdelivr.net/npm/apexcharts`
   - Cocok untuk dashboard yang lebih kompleks

2. **Plotly.js** - Sangat powerful untuk visualisasi data
   - CDN: `https://cdn.plot.ly/plotly-latest.min.js`
   - Cocok untuk analisis data yang lebih dalam

## Alur Data

```
PublicResultController::index()
    ↓
SmartCalculationService::calculate()
    ↓
    ├─ normalize() → Normalisasi nilai
    ├─ calculateFinalValues() → Perhitungan Vj
    └─ rank() → Perangkingan
    ↓
PublicResultController::prepareContributionData()
    ↓
    └─ Menyiapkan data untuk grafik
    ↓
PublicResultController::prepareJuriRatings()
    ↓
    └─ Menyiapkan data penilaian juri
    ↓
View: public.results
    ↓
    ├─ Menampilkan Podium
    ├─ Menampilkan Spotlight Winner
    ├─ Menampilkan Ranking Board
    ├─ Menampilkan Grafik (Chart.js)
    ├─ Menampilkan Tabel Detail
    └─ Menampilkan Tabel Penilaian Juri
```

## Wireframe Desain

```
┌─────────────────────────────────────────┐
│         Header & Navigation             │
├─────────────────────────────────────────┤
│                                         │
│      🏆 Hasil Kontes Unggas             │
│   Peringkat Final Berdasarkan SMART     │
│                                         │
├─────────────────────────────────────────┤
│                                         │
│         Podium (Top 3)                  │
│      🥈      👑      🥉                 │
│     #2      #1      #3                 │
│                                         │
├─────────────────────────────────────────┤
│                                         │
│    Top Winner Spotlight (Juara 1)      │
│    [Gradient Gold Background]           │
│                                         │
├─────────────────────────────────────────┤
│                                         │
│         Ranking Board Table             │
│    # | Kode | Nama | Skor | Detail     │
│                                         │
├─────────────────────────────────────────┤
│                                         │
│    Visualisasi Grafik                   │
│    [Dropdown Selector]                  │
│    ┌──────────┬──────────┐            │
│    │ Bar Chart│Radar Chart│            │
│    │          │           │            │
│    └──────────┴──────────┘            │
│                                         │
├─────────────────────────────────────────┤
│                                         │
│      Tabel Detail Penilaian             │
│    Alternatif | Kriteria | Total        │
│                                         │
├─────────────────────────────────────────┤
│                                         │
│    Tabel Detail Penilaian Juri         │
│    Juri 1 | Rata-rata Juri 2 & 3       │
│                                         │
└─────────────────────────────────────────┘
```

## Fitur Interaktif

1. **Dropdown Selector Grafik**
   - User dapat memilih alternatif untuk melihat grafik
   - Grafik update secara real-time

2. **Tooltip pada Grafik**
   - Menampilkan detail saat hover
   - Menampilkan kontribusi, normalisasi, dan bobot

3. **Responsive Design**
   - Mobile-friendly
   - Grid layout yang adaptif

## Styling & Visual

- **Color Scheme:**
  - Gold (#FFD700) untuk Juara 1
  - Silver (#C0C0C0) untuk Juara 2
  - Bronze (#CD7F32) untuk Juara 3
  - Blue untuk skor dan data

- **Typography:**
  - Font: Segoe UI (system font)
  - Headings: Bold, large
  - Body: Regular, readable

- **Spacing:**
  - Consistent padding dan margin
  - Breathing room antar section

## Testing

Untuk menguji halaman publik:
1. Akses `/` atau `/hasil` tanpa login
2. Pastikan data sudah ada (alternatif, kriteria, penilaian)
3. Cek semua komponen tampil dengan benar
4. Test interaksi grafik (dropdown selector)
5. Test responsive di berbagai ukuran layar

## Catatan Penting

- Halaman ini **tidak memerlukan authentication**
- Data diambil langsung dari database
- Grafik menggunakan Chart.js via CDN (tidak perlu install package)
- Semua perhitungan menggunakan `SmartCalculationService` yang sudah ada
- Data penilaian juri diambil dari tabel `ratings`

