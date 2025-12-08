<?php

namespace App\Http\Controllers\WaliKelas;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Nilai;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $waliKelas = Auth::user();
        $kelas = Kelas::where('wali_kelas_id', $waliKelas->id)->first();
        
        if (!$kelas) {
            return redirect()->back()->with('error', 'Anda belum ditugaskan sebagai wali kelas.');
        }
        
        $jumlahSiswa = Siswa::where('kelas_id', $kelas->id)->count();
        
        // Notifikasi nilai belum lengkap
        $belumLengkap = [];
        $siswa = Siswa::where('kelas_id', $kelas->id)->get();
        foreach ($siswa as $s) {
            $nilaiCount = Nilai::where('siswa_id', $s->id)->count();
            if ($nilaiCount == 0) {
                $belumLengkap[] = $s->nama_siswa;
            }
        }
        
        // Progress raport
        $totalNilai = Nilai::whereIn('siswa_id', $siswa->pluck('id'))->count();
        $progress = count($siswa) > 0 ? ($totalNilai / (count($siswa) * 12)) * 100 : 0; // 12 mapel
        
        return view('wali.dashboard', compact('kelas', 'jumlahSiswa', 'belumLengkap', 'progress'));
    }

    public function rekap()
    {
        $waliKelas = Auth::user();
        $kelas = Kelas::where('wali_kelas_id', $waliKelas->id)->first();
        
        if (!$kelas) {
            return redirect()->back()->with('error', 'Anda belum ditugaskan sebagai wali kelas.');
        }
        
        $siswa = Siswa::where('kelas_id', $kelas->id)
            ->with(['nilai.mapel', 'nilai.guru'])
            ->get();
        
        return view('wali.rekap', compact('siswa', 'kelas'));
    }
}
