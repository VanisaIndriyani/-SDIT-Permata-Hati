<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\TahunAjaran;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Siswa;
use App\Models\MapelGuru;
use App\Models\Nilai;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin
        User::create([
            'name' => 'Administrator',
            'username' => 'admin',
            'email' => 'admin@sditpermatahati.sch.id',
            'role' => 'admin',
            'password' => Hash::make('admin'),
        ]);

        // Create Tahun Ajaran
        $tahunAjaran = TahunAjaran::create([
            'tahun_ajaran' => '2024/2025',
            'semester' => 'Ganjil',
            'is_active' => true,
        ]);

        // Create Kelas
        $kelas = Kelas::create([
            'nama_kelas' => 'Kelas 5',
            'jumlah_siswa' => 30,
        ]);

        // Create Mapel
        $mapelList = [
            ['kode_mapel' => 'PAI', 'nama_mapel' => 'PAI'],
            ['kode_mapel' => 'PKN', 'nama_mapel' => 'PKN'],
            ['kode_mapel' => 'BIN', 'nama_mapel' => 'BAHASA INDONESIA'],
            ['kode_mapel' => 'MAT', 'nama_mapel' => 'MATEMATIKA'],
            ['kode_mapel' => 'IPAS', 'nama_mapel' => 'IPAS'],
            ['kode_mapel' => 'SBDP', 'nama_mapel' => 'SBDP'],
            ['kode_mapel' => 'PJOK', 'nama_mapel' => 'PJOK'],
            ['kode_mapel' => 'BSU', 'nama_mapel' => 'BAHASA SUNDA'],
            ['kode_mapel' => 'BING', 'nama_mapel' => 'BAHASA INGGRIS'],
            ['kode_mapel' => 'TAHFIDZH', 'nama_mapel' => 'TAHFIDZH'],
            ['kode_mapel' => 'BAR', 'nama_mapel' => 'BAHASA ARAB'],
            ['kode_mapel' => 'BTQ', 'nama_mapel' => 'BTQ'],
        ];

        foreach ($mapelList as $mapelData) {
            Mapel::create($mapelData);
        }

        // Create 12 Guru (satu per mapel)
        $guruList = [
            ['name' => 'Guru PAI', 'username' => 'guru_pai', 'nip' => '19600101198001001'],
            ['name' => 'Guru PKN', 'username' => 'guru_pkn', 'nip' => '19600101198001002'],
            ['name' => 'Guru Bahasa Indonesia', 'username' => 'guru_bin', 'nip' => '19600101198001003'],
            ['name' => 'Guru Matematika', 'username' => 'guru_mat', 'nip' => '19600101198001004'],
            ['name' => 'Guru IPAS', 'username' => 'guru_ipas', 'nip' => '19600101198001005'],
            ['name' => 'Guru SBDP', 'username' => 'guru_sbdp', 'nip' => '19600101198001006'],
            ['name' => 'Guru PJOK', 'username' => 'guru_pjok', 'nip' => '19600101198001007'],
            ['name' => 'Guru Bahasa Sunda', 'username' => 'guru_bsu', 'nip' => '19600101198001008'],
            ['name' => 'Guru Bahasa Inggris', 'username' => 'guru_bing', 'nip' => '19600101198001009'],
            ['name' => 'Guru Tahfidzh', 'username' => 'guru_tahfidzh', 'nip' => '19600101198001010'],
            ['name' => 'Guru Bahasa Arab', 'username' => 'guru_bar', 'nip' => '19600101198001011'],
            ['name' => 'Guru BTQ', 'username' => 'guru_btq', 'nip' => '19600101198001012'],
        ];

        $guruUsers = [];
        foreach ($guruList as $index => $guruData) {
            // Semua guru mapel menggunakan password 'guru'
            $guru = User::create([
                'name' => $guruData['name'],
                'username' => $guruData['username'],
                'email' => $guruData['username'] . '@sditpermatahati.sch.id',
                'role' => 'guru',
                'nip' => $guruData['nip'],
                'password' => Hash::make('guru'),
            ]);
            $guruUsers[] = $guru;
        }

        // Create Wali Kelas
        $waliKelas = User::create([
            'name' => 'Siti Nurhaliza',
            'username' => 'walikelas',
            'email' => 'walikelas@sditpermatahati.sch.id',
            'role' => 'wali_kelas',
            'nip' => '197501151995032001',
            'password' => Hash::make('walikelas'),
        ]);

        // Update kelas dengan wali kelas
        $kelas->update(['wali_kelas_id' => $waliKelas->id]);

        // Create Kepala Sekolah
        User::create([
            'name' => 'Kepala Sekolah',
            'username' => 'kepsek',
            'email' => 'kepsek@sditpermatahati.sch.id',
            'role' => 'kepsek',
            'nip' => '987654321',
            'password' => Hash::make('kepsek'),
        ]);

        // Assign mapel to guru (satu mapel per guru) - Mapping eksplisit untuk sinkronisasi
        $mapelGuruMapping = [
            'guru_pai' => 'PAI',
            'guru_pkn' => 'PKN',
            'guru_bin' => 'BIN',
            'guru_mat' => 'MAT',
            'guru_ipas' => 'IPAS',
            'guru_sbdp' => 'SBDP',
            'guru_pjok' => 'PJOK',
            'guru_bsu' => 'BSU',
            'guru_bing' => 'BING',
            'guru_tahfidzh' => 'TAHFIDZH',
            'guru_bar' => 'BAR',
            'guru_btq' => 'BTQ',
        ];

        // Get all mapel dengan key berdasarkan kode_mapel
        $mapelData = Mapel::all()->keyBy('kode_mapel');

        // Assign mapel ke guru berdasarkan mapping
        foreach ($guruUsers as $guru) {
            $username = $guru->username;
            if (isset($mapelGuruMapping[$username])) {
                $kodeMapel = $mapelGuruMapping[$username];
                $mapel = $mapelData->get($kodeMapel);
                
                if ($mapel) {
                    MapelGuru::create([
                        'guru_id' => $guru->id,
                        'mapel_id' => $mapel->id,
                        'kelas_id' => $kelas->id,
                    ]);
                }
            }
        }

        // Create Siswa (30 siswa dari list yang diberikan)
        $siswaList = [
            'AHMAD KENZEI PARAMA RUHMADHA',
            'AKHTAR ALKHALIFI ADYATAMA TAIM',
            'AL IRSYAD ABIDZAR FAIRUZ',
            'ALFATHIER RAMADHAN AMARULLAH',
            'ASHILA PERMANA NOERSAM ZA',
            'BUNGA PUTRI IRAWAN',
            'HAFIZA KHAIRA GANI',
            'INDY AUDREY FAHLEVY',
            'KHAIRA ELVINA DZAKIRA',
            'KHAIRUNNISA NUR AZIZAH',
            'KINANTHY ZARRA ADHELIA',
            'KIRANI PUTRI DINANTI',
            'LETIZIA ALMA NURSYIFA',
            'MALIK ABDURRAHIEM ROBIY',
            'MAULANA YUSUF YUSTISIO',
            'MAZAYA NUHA AMARA',
            'MOHAMMAD JABAR',
            'MUCHAMAD KHAIRAN ARSYA KAMIL NURFIANSYAH',
            'MUHAMMAD SYABIL ELFATHIN AFRIYANTO',
            'NAJWA AL JAZARI ARETA KALIFA',
            'NANCY AULIA RAHMAN',
            'RADISTY JUNINDIA KURNIAWAN PUTRI',
            'RAZA SAM\'ANI FEBRIANSYAH',
            'SULTHAN ABDURRAHMAN TALITS',
            'SYABIL ADYASTA RAHARJA',
            'MUHAMAD KAISAR RAMADHAN',
            'M FADLAN IBNU MALIK',
            'ALZENA AZALIA ZARA',
            'AKHTAR ANDANESH ALGHANIIY',
            'ABDU RAZIQ DARY ABIYYU',
        ];

        $siswaRecords = [];
        foreach ($siswaList as $index => $namaSiswa) {
            $siswaRecords[] = Siswa::create([
                'nis' => 'NIS' . str_pad($index + 1, 4, '0', STR_PAD_LEFT),
                'nama_siswa' => $namaSiswa,
                'kelas_id' => $kelas->id,
                'tahun_ajaran_id' => $tahunAjaran->id,
            ]);
        }

        // Create Nilai UH untuk semua siswa di semua mapel
        $mapelIds = Mapel::pluck('id')->toArray();
        $siswaIds = Siswa::pluck('id')->toArray();
        
        // Get mapel_guru untuk mendapatkan guru_id berdasarkan mapel_id dan kelas_id
        $mapelGuruData = MapelGuru::where('kelas_id', $kelas->id)->get()->keyBy('mapel_id');
        
        foreach ($siswaIds as $siswaId) {
            foreach ($mapelIds as $mapelId) {
                // Get guru_id from mapel_guru
                $mapelGuru = $mapelGuruData->get($mapelId);
                if (!$mapelGuru) {
                    continue; // Skip if no guru assigned to this mapel
                }
                
                // Generate random nilai UH between 60-100
                $nilaiUh = rand(60, 100);
                
                Nilai::create([
                    'siswa_id' => $siswaId,
                    'mapel_id' => $mapelId,
                    'guru_id' => $mapelGuru->guru_id,
                    'tahun_ajaran_id' => $tahunAjaran->id,
                    'nilai_uh' => $nilaiUh,
                    'nilai_pts' => null,
                    'nilai_pas' => null,
                    'rata_rata' => null,
                    'deskripsi_kompetensi' => null,
                ]);
            }
        }

        // Update Nilai PAS untuk semua siswa di semua mapel
        $allNilai = Nilai::where('tahun_ajaran_id', $tahunAjaran->id)->get();
        
        foreach ($allNilai as $nilai) {
            // Generate random nilai PAS between 60-100
            $nilaiPas = rand(60, 100);
            
            // Hitung rata-rata dari UH dan PAS
            $nilaiArray = array_filter([$nilai->nilai_uh, $nilaiPas], function($v) {
                return $v !== null && $v !== '';
            });
            $rataRata = !empty($nilaiArray) ? array_sum($nilaiArray) / count($nilaiArray) : null;
            
            $nilai->update([
                'nilai_pas' => $nilaiPas,
                'rata_rata' => $rataRata,
            ]);
        }
    }
}
