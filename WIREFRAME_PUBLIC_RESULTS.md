# Wireframe & Struktur Data - Halaman Hasil Publik

## Wireframe Desain Halaman

```
┌─────────────────────────────────────────────────────────────────┐
│  🏆 Hasil Kontes Unggas - Peringkat Final Berdasarkan SMART    │
│                    [Login Button]                                │
├─────────────────────────────────────────────────────────────────┤
│                                                                 │
│                    Pemenang Teratas                             │
│                                                                 │
│              ┌──────┐    ┌──────┐    ┌──────┐                 │
│              │ 🥈   │    │ 👑   │    │ 🥉   │                 │
│              │ #2   │    │ #1   │    │ #3   │                 │
│              │      │    │      │    │      │                 │
│              │      │    │      │    │      │                 │
│              └──────┘    └──────┘    └──────┘                 │
│              Peringkat 2  JUARA 1   Peringkat 3               │
│                                                                 │
├─────────────────────────────────────────────────────────────────┤
│                                                                 │
│         Top Winner Spotlight (Gradient Gold Background)         │
│                                                                 │
│         👑  Juara 1: Unggas A                                   │
│         Kode: UGA001                                            │
│         ┌─────────────────────┐                                │
│         │  Skor Total Akhir   │                                │
│         │      0.8523         │                                │
│         └─────────────────────┘                                │
│                                                                 │
├─────────────────────────────────────────────────────────────────┤
│                                                                 │
│                    Papan Peringkat                              │
│                                                                 │
│  ┌──────┬──────┬──────────────┬──────────────┬──────────┐     │
│  │ Rank │ Kode │ Nama         │ Skor Total   │ Detail  │     │
│  ├──────┼──────┼──────────────┼──────────────┼──────────┤     │
│  │ 👑#1 │ UGA  │ Unggas A     │ 0.8523       │ [Grafik]│     │
│  │ 🥈#2 │ UGB  │ Unggas B     │ 0.7845       │ [Grafik]│     │
│  │ 🥉#3 │ UGC  │ Unggas C     │ 0.7123       │ [Grafik]│     │
│  └──────┴──────┴──────────────┴──────────────┴──────────┘     │
│                                                                 │
├─────────────────────────────────────────────────────────────────┤
│                                                                 │
│         Visualisasi Kontribusi Skor per Kriteria                │
│                                                                 │
│  [Dropdown: Pilih Alternatif]                                  │
│                                                                 │
│  ┌──────────────────────┬──────────────────────┐               │
│  │  Grafik Batang       │  Grafik Radar       │               │
│  │                      │                      │               │
│  │  ▁▂▃▅▆▇█            │      ╱╲             │               │
│  │  Kriteria 1-5        │     ╱  ╲            │               │
│  │                      │    ╱    ╲           │               │
│  │                      │   ╱      ╲          │               │
│  │                      │  ╱        ╲         │               │
│  └──────────────────────┴──────────────────────┘               │
│                                                                 │
├─────────────────────────────────────────────────────────────────┤
│                                                                 │
│                    Tabel Detail Penilaian                       │
│                                                                 │
│  Alternatif │ Kriteria 1 │ Kriteria 2 │ ... │ Total (Vj)     │
│  #1 Unggas A│ U:0.85     │ U:0.78     │ ... │ 0.8523         │
│             │ 21.25      │ 15.60      │     │                │
│  #2 Unggas B│ ...        │ ...        │ ... │ 0.7845         │
│  ...                                                           │
│                                                                 │
├─────────────────────────────────────────────────────────────────┤
│                                                                 │
│              Detail Penilaian Juri                              │
│                                                                 │
│  Unggas A (UGA001)                                              │
│  ┌──────────┬──────────┬──────────────────┐                   │
│  │ Kriteria │ Juri 1   │ Rata-rata Juri   │                   │
│  │          │          │ 2 & 3            │                   │
│  ├──────────┼──────────┼──────────────────┤                   │
│  │ Kriteria1│ 85.00    │ 82.50            │                   │
│  │ Kriteria2│ 78.00    │ 80.00            │                   │
│  └──────────┴──────────┴──────────────────┘                   │
│                                                                 │
└─────────────────────────────────────────────────────────────────┘
```

## Struktur Data untuk Grafik

### 1. Contribution Data (Array PHP)
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
                'normalized' => 0.8500,      // U(Xij)
                'contribution' => 21.2500    // Wi × U(Xij)
            ],
            [
                'name' => 'Warna Bulu',
                'category' => 'Penampilan Fisik',
                'weight' => 20.00,
                'normalized' => 0.7800,
                'contribution' => 15.6000
            ],
            // ... more criteria
        ]
    ],
    // ... more alternatives
]
```

### 2. JSON untuk Chart.js
```javascript
// Bar Chart Data Structure
{
    labels: ['Bentuk Tubuh', 'Warna Bulu', 'Kondisi Kesehatan', 'Aktivitas'],
    datasets: [{
        label: 'Kontribusi Skor (Wi × U(Xij))',
        data: [21.25, 15.60, 25.50, 19.25],
        backgroundColor: 'rgba(59, 130, 246, 0.6)',
        borderColor: 'rgba(59, 130, 246, 1)',
        borderWidth: 2
    }]
}

// Radar Chart Data Structure
{
    labels: ['Bentuk Tubuh', 'Warna Bulu', 'Kondisi Kesehatan', 'Aktivitas'],
    datasets: [{
        label: 'Unggas A',
        data: [21.25, 15.60, 25.50, 19.25],
        backgroundColor: 'rgba(59, 130, 246, 0.2)',
        borderColor: 'rgba(59, 130, 246, 1)',
        borderWidth: 2
    }]
}
```

### 3. Juri Ratings Data Structure
```php
[
    [
        'name' => 'Unggas A',
        'code' => 'UGA001',
        'criteria' => [
            [
                'name' => 'Bentuk Tubuh',
                'juri1_rating' => 85.00,      // Nilai dari Juri 1
                'juri2_3_avg' => 82.50        // Rata-rata Juri 2 & 3
            ],
            // ... more criteria
        ]
    ],
    // ... more alternatives
]
```

## Rekomendasi Package Laravel/JavaScript

### 1. Chart.js (Recommended - Sudah Diimplementasikan)
**CDN:** `https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js`

**Keuntungan:**
- ✅ Ringan (~200KB minified)
- ✅ Mudah digunakan
- ✅ Mendukung banyak jenis grafik
- ✅ Responsif dan interaktif
- ✅ Dokumentasi lengkap
- ✅ Tidak perlu install package (CDN)

**Jenis Grafik yang Didukung:**
- Bar Chart ✅ (Sudah digunakan)
- Radar Chart ✅ (Sudah digunakan)
- Line Chart
- Pie Chart
- Doughnut Chart
- Area Chart
- dll

### 2. ApexCharts (Alternatif)
**Install:** `npm install apexcharts`
**CDN:** `https://cdn.jsdelivr.net/npm/apexcharts`

**Keuntungan:**
- Lebih modern dan stylish
- Animasi yang lebih smooth
- Lebih banyak customisasi
- Cocok untuk dashboard kompleks

**Kekurangan:**
- Lebih besar ukurannya
- Perlu install package

### 3. Plotly.js (Untuk Analisis Lanjutan)
**CDN:** `https://cdn.plot.ly/plotly-latest.min.js`

**Keuntungan:**
- Sangat powerful
- Cocok untuk analisis data mendalam
- 3D charts support
- Interactive zoom dan pan

**Kekurangan:**
- Sangat besar ukurannya (~3MB)
- Overkill untuk kebutuhan sederhana

## Integrasi dengan SmartCalculationService

### Alur Data Flow:

```
PublicResultController::index()
    ↓
SmartCalculationService::calculate()
    ├─ normalize()
    │   └─ Input: Alternatives, Criteria
    │   └─ Output: Array normalized[alternative_id][criterion_id]
    │
    ├─ calculateFinalValues()
    │   └─ Input: Alternatives, Criteria, normalized[]
    │   └─ Output: Array finalValues[alternative_id]
    │
    └─ rank()
        └─ Input: Alternatives, finalValues[]
        └─ Output: Collection ranked dengan rank, alternative, final_value
    ↓
PublicResultController::prepareContributionData()
    └─ Input: Alternatives, Criteria, results dari calculate()
    └─ Output: Array contributionData untuk grafik
    └─ Formula: contribution = weight × normalized
    ↓
PublicResultController::prepareJuriRatings()
    └─ Input: Alternatives, Criteria
    └─ Output: Array juriRatings dengan data Juri 1 dan rata-rata Juri 2 & 3
    ↓
View: public.results
    ├─ Menampilkan Podium (Top 3)
    ├─ Menampilkan Spotlight Winner
    ├─ Menampilkan Ranking Board
    ├─ Menampilkan Grafik (Chart.js)
    ├─ Menampilkan Tabel Detail
    └─ Menampilkan Tabel Penilaian Juri
```

## Formula Perhitungan yang Ditampilkan

### 1. Nilai Normalisasi U(Xij)
- **Benefit:** U(Xij) = Xij / Xmax
- **Cost:** U(Xij) = Xmin / Xij
- Ditampilkan di tooltip grafik dan tabel detail

### 2. Kontribusi Skor Wi × U(Xij)
- Perkalian antara bobot kriteria (Wi) dengan nilai normalisasi (U(Xij))
- Ditampilkan sebagai tinggi bar di Bar Chart
- Ditampilkan sebagai nilai di Radar Chart

### 3. Skor Total Akhir Vj
- Vj = Σ(Wi × U(Xij)) untuk semua kriteria
- Ditampilkan di ranking board dan spotlight winner

## Responsive Design

### Desktop (> 1024px)
- 2 kolom untuk grafik (Bar Chart | Radar Chart)
- Full width untuk tabel
- Podium horizontal dengan 3 kolom

### Tablet (768px - 1024px)
- 2 kolom untuk grafik (stacked)
- Tabel dengan horizontal scroll
- Podium tetap horizontal

### Mobile (< 768px)
- 1 kolom untuk grafik (stacked)
- Tabel dengan horizontal scroll
- Podium vertical stack

## Color Scheme

- **Gold (#FFD700):** Juara 1, highlight
- **Silver (#C0C0C0):** Juara 2
- **Bronze (#CD7F32):** Juara 3
- **Blue (#3B82F6):** Data, skor, grafik
- **Green (#10B981):** Success, rata-rata Juri 2 & 3
- **Gray (#6B7280):** Text secondary

## Interaksi User

1. **Dropdown Selector**
   - User memilih alternatif
   - Grafik update secara real-time
   - Tidak perlu reload halaman

2. **Tooltip Grafik**
   - Hover pada bar/point
   - Menampilkan detail: kontribusi, normalisasi, bobot

3. **Responsive Navigation**
   - Menu collapse di mobile
   - Login button selalu accessible

## Testing Checklist

- [ ] Halaman dapat diakses tanpa login
- [ ] Podium menampilkan top 3 dengan benar
- [ ] Spotlight winner menampilkan juara 1
- [ ] Ranking board menampilkan semua alternatif
- [ ] Grafik Bar Chart berfungsi
- [ ] Grafik Radar Chart berfungsi
- [ ] Dropdown selector update grafik
- [ ] Tabel detail menampilkan data benar
- [ ] Tabel penilaian juri menampilkan data benar
- [ ] Responsive di mobile, tablet, desktop
- [ ] Chart.js load dengan benar (CDN)

