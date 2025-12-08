<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\MapelGuru;
use App\Models\Nilai;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $guru = Auth::user();
        $mapelGuru = MapelGuru::where('guru_id', $guru->id)->with('mapel', 'kelas')->get();
        $jumlahKelas = $mapelGuru->unique('kelas_id')->count();
        
        // Progress input nilai
        $totalSiswa = Siswa::whereIn('kelas_id', $mapelGuru->pluck('kelas_id'))->count();
        $nilaiMasuk = Nilai::where('guru_id', $guru->id)->distinct('siswa_id')->count();
        $progress = $totalSiswa > 0 ? ($nilaiMasuk / $totalSiswa) * 100 : 0;
        
        // Notifikasi nilai belum lengkap
        $belumLengkap = [];
        foreach ($mapelGuru as $mg) {
            $siswaKelas = Siswa::where('kelas_id', $mg->kelas_id)->get();
            foreach ($siswaKelas as $siswa) {
                $nilai = Nilai::where('siswa_id', $siswa->id)
                    ->where('mapel_id', $mg->mapel_id)
                    ->where('guru_id', $guru->id)
                    ->first();
                if (!$nilai || !$nilai->nilai_uh || !$nilai->nilai_pts || !$nilai->nilai_pas) {
                    $belumLengkap[] = [
                        'mapel' => $mg->mapel->nama_mapel,
                        'kelas' => $mg->kelas->nama_kelas,
                        'siswa' => $siswa->nama_siswa
                    ];
                }
            }
        }
        
        return view('guru.dashboard', compact('mapelGuru', 'jumlahKelas', 'progress', 'belumLengkap'));
    }

    public function mapel()
    {
        $guru = Auth::user();
        $mapelGuru = MapelGuru::where('guru_id', $guru->id)
            ->with('mapel', 'kelas')
            ->get()
            ->groupBy('mapel_id');
        
        return view('guru.mapel', compact('mapelGuru'));
    }

    public function rekap()
    {
        $guru = Auth::user();
        $mapelId = request('mapel_id');
        
        $mapelGuru = MapelGuru::where('guru_id', $guru->id)
            ->with('mapel')
            ->get()
            ->unique('mapel_id');
        
        $nilai = collect();
        if ($mapelId) {
            $nilai = Nilai::where('guru_id', $guru->id)
                ->where('mapel_id', $mapelId)
                ->with('siswa', 'mapel')
                ->get();
        }
        
        return view('guru.rekap', compact('mapelGuru', 'nilai'));
    }
}
