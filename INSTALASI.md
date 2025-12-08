# Panduan Instalasi dan Penggunaan

## Langkah Instalasi

1. **Install Dependencies**
```bash
composer install
npm install
```

2. **Setup Environment**
```bash
# Copy file .env
cp .env.example .env

# Generate application key
php artisan key:generate
```

3. **Setup Database**

Untuk SQLite (default):
```bash
touch database/database.sqlite
```

Atau edit `.env` untuk MySQL/PostgreSQL:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=raport_sdit
DB_USERNAME=root
DB_PASSWORD=
```

4. **Jalankan Migration dan Seeder**
```bash
php artisan migrate --seed
```

Ini akan membuat:
- User admin, guru, wali kelas, kepsek
- Tahun ajaran 2024/2025
- Kelas V A
- 12 mata pelajaran
- 30 siswa dari daftar yang diberikan

5. **Build Assets**
```bash
npm run build
```

6. **Jalankan Server**
```bash
php artisan serve
```

Akses: http://localhost:8000

## Akun Login

| Role | Username | Password |
|------|----------|----------|
| Admin | `admin` | `password123` |
| Guru | `guru` | `password123` |
| Wali Kelas | `walikelas` | `password123` |
| Kepala Sekolah | `kepsek` | `password123` |

## Fitur yang Tersedia

### Admin
- ✅ Kelola User (CRUD + Reset Password)
- ✅ Kelola Kelas (CRUD + Assign Wali Kelas)
- ✅ Kelola Mapel (CRUD)
- ✅ Kelola Siswa (CRUD + Assign Kelas & Tahun Ajaran)

### Guru
- ✅ Dashboard (Statistik & Notifikasi)
- ✅ Daftar Mata Pelajaran
- ✅ Input Nilai (UH, PTS, PAS dengan validasi)
- ✅ Rekap Nilai per Mapel

### Wali Kelas
- ✅ Dashboard (Statistik & Notifikasi)
- ✅ Rekap Nilai Semua Siswa
- ✅ Lihat Detail Raport
- ✅ Cetak/Ekspor PDF (Template siap)

### Kepala Sekolah
- ✅ Dashboard (Statistik & Grafik)
- ✅ Monitoring Nilai (Per Mapel, Kelas, Guru)
- ✅ Data Guru
- ✅ Data Kelas
- ✅ Laporan

## Catatan Penting

1. **Validasi Nilai**: Sistem akan memvalidasi bahwa nilai harus antara 0-100
2. **Rata-rata Otomatis**: Rata-rata dihitung otomatis dari UH, PTS, PAS
3. **Pop-up Konfirmasi**: Setiap aksi penting akan meminta konfirmasi
4. **Notifikasi**: Alert sukses/error akan muncul di setiap aksi

## Troubleshooting

### Error: "Class not found"
```bash
composer dump-autoload
```

### Error: "Migration not found"
```bash
php artisan migrate:fresh --seed
```

### Error: "Assets not found"
```bash
npm run build
```

### Error: "Session driver"
Pastikan di `.env`:
```env
SESSION_DRIVER=file
```

## Development Mode

Untuk development dengan hot reload:
```bash
# Terminal 1
php artisan serve

# Terminal 2
npm run dev
```

## Production

Sebelum deploy ke production:
1. Set `APP_ENV=production` di `.env`
2. Set `APP_DEBUG=false` di `.env`
3. Run `php artisan config:cache`
4. Run `php artisan route:cache`
5. Run `php artisan view:cache`
6. Build assets: `npm run build`

