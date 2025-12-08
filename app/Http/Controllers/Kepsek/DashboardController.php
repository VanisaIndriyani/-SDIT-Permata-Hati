<?php

namespace App\Http\Controllers\Kepsek;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Siswa;
use App\Models\Nilai;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $jumlahGuru = User::where('role', 'guru')->count();
        $jumlahSiswa = Siswa::count();
        
        // Progress input nilai
        $totalNilai = Nilai::count();
        $totalSiswa = Siswa::count();
        $totalMapel = 12; // Jumlah mapel
        $progress = ($totalSiswa * $totalMapel) > 0 ? ($totalNilai / ($totalSiswa * $totalMapel)) * 100 : 0;
        
        // Rata-rata nilai
        $rataRataNilai = Nilai::whereNotNull('rata_rata')->avg('rata_rata');
        
        // Rata-rata nilai per kelas untuk grafik
        $kelas = Kelas::with('siswa')->get();
        $chartKelas = [];
        foreach ($kelas as $k) {
            $siswaIds = $k->siswa->pluck('id');
            $rataRata = Nilai::whereIn('siswa_id', $siswaIds)
                ->whereNotNull('rata_rata')
                ->avg('rata_rata') ?? 0;
            
            $chartKelas[] = [
                'nama_kelas' => $k->nama_kelas,
                'rata_rata' => round($rataRata, 2)
            ];
        }
        
        return view('kepsek.dashboard', compact('jumlahGuru', 'jumlahSiswa', 'progress', 'rataRataNilai', 'chartKelas'));
    }

    public function dataGuru()
    {
        $guru = User::where('role', 'guru')
            ->with('mapelGuru.mapel', 'mapelGuru.kelas')
            ->get();
        
        return view('kepsek.data-guru', compact('guru'));
    }

    public function dataKelas()
    {
        $kelas = \App\Models\Kelas::with('waliKelas', 'siswa')->get();
        
        return view('kepsek.data-kelas', compact('kelas'));
    }
}
