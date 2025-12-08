# Aplikasi Pengelolaan Nilai Raport Kelas V SDIT Permata Hati

Aplikasi web berbasis Laravel untuk mengelola nilai raport siswa kelas V dengan sistem role-based access control.

## Fitur Utama

### 1. Role Admin
- Kelola User (Tambah, Edit, Hapus, Reset Password)
- Kelola Kelas (Tambah, Edit, Hapus, Assign Wali Kelas)
- Kelola Mata Pelajaran (Tambah, Edit, Hapus)
- Kelola Siswa (Tambah, Edit, Hapus, Assign Kelas)

### 2. Role Guru
- Dashboard (Jumlah kelas, mata pelajaran, progress input nilai)
- Mata Pelajaran (Daftar mapel yang diampu)
- Input Nilai (UH, PTS, PAS dengan validasi otomatis)
- Rekap Nilai (Tabel rekap nilai per mapel)

### 3. Role Wali Kelas
- Dashboard (Jumlah siswa, progress raport, notifikasi)
- Rekap Nilai (Seluruh nilai siswa untuk semua mapel)
- Raport (Lihat detail raport siswa)
- Cetak / Ekspor (Download PDF raport)

### 4. Role Kepala Sekolah
- Dashboard (Statistik guru, siswa, progress, grafik)
- Monitoring Nilai (Nilai per mapel, kelas, guru dengan grafik)
- Data Guru (Nama, NIP, Mapel, Kelas)
- Data Kelas (Jumlah siswa, wali kelas, daftar mapel)
- Laporan (Laporan nilai per kelas, ekspor PDF/Excel)

## Teknologi

- **Framework**: Laravel 12
- **Frontend**: Bootstrap 5.3.2
- **Icons**: Bootstrap Icons
- **Charts**: Chart.js
- **Database**: SQLite (default) / MySQL / PostgreSQL

## Instalasi

1. Clone repository atau extract project
2. Install dependencies:
```bash
composer install
npm install
```

3. Setup environment:
```bash
cp .env.example .env
php artisan key:generate
```

4. Setup database (jika menggunakan SQLite):
```bash
touch database/database.sqlite
```

Atau konfigurasi database di `.env` untuk MySQL/PostgreSQL.

5. Jalankan migrations dan seeder:
```bash
php artisan migrate --seed
```

6. Build assets:
```bash
npm run build
```

7. Jalankan server:
```bash
php artisan serve
```

Akses aplikasi di: `http://localhost:8000`

## Akun Default

Setelah menjalankan seeder, gunakan akun berikut:

- **Admin**: 
  - Username: `admin`
  - Password: `password123`

- **Guru**: 
  - Username: `guru`
  - Password: `password123`

- **Wali Kelas**: 
  - Username: `walikelas`
  - Password: `password123`

- **Kepala Sekolah**: 
  - Username: `kepsek`
  - Password: `password123`

## Struktur Database

- `users` - Data user (admin, guru, wali kelas, kepsek)
- `tahun_ajaran` - Data tahun ajaran aktif
- `kelas` - Data kelas
- `mapel` - Data mata pelajaran
- `siswa` - Data siswa
- `nilai` - Data nilai (UH, PTS, PAS, Rata-rata)
- `mapel_guru` - Relasi guru dengan mapel dan kelas

## Mata Pelajaran

1. PAI
2. PKN
3. BAHASA INDONESIA
4. MATEMATIKA
5. IPAS
6. SBDP
7. PJOK
8. BAHASA SUNDA
9. BAHASA INGGRIS
10. TAHFIDZH
11. BAHASA ARAB
12. BTQ

## Validasi

- Nilai harus dalam range 0-100
- Nilai tidak boleh kosong (opsional, bisa diisi bertahap)
- Rata-rata dihitung otomatis dari UH, PTS, PAS
- Pop-up konfirmasi saat simpan data
- Notifikasi sukses/error menggunakan alert Bootstrap

## Warna Tema

Aplikasi menggunakan warna sesuai logo SDIT Permata Hati:
- **Primary Green**: #28a745 (untuk tombol, header, accent)
- **Primary Red**: #dc3545 (untuk error, danger actions)
- **Light Green**: #d4edda (untuk background success)
- **Light Red**: #f8d7da (untuk background error)

## Development

Untuk development dengan hot reload:
```bash
npm run dev
php artisan serve
```

## License

Aplikasi ini dibuat khusus untuk SDIT Permata Hati.
