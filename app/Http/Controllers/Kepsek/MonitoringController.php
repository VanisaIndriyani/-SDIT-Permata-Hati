<?php

namespace App\Http\Controllers\Kepsek;

use App\Http\Controllers\Controller;
use App\Models\Nilai;
use App\Models\Mapel;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Http\Request;

class MonitoringController extends Controller
{
    public function index()
    {
        $mapel = Mapel::all();
        $kelas = Kelas::all();
        $guru = User::where('role', 'guru')->get();
        
        // Nilai per mapel
        $nilaiPerMapel = [];
        foreach ($mapel as $m) {
            $nilaiPerMapel[$m->nama_mapel] = Nilai::where('mapel_id', $m->id)
                ->whereNotNull('rata_rata')
                ->avg('rata_rata');
        }
        
        // Nilai per kelas
        $nilaiPerKelas = [];
        foreach ($kelas as $k) {
            $siswaIds = $k->siswa->pluck('id');
            $nilaiPerKelas[$k->nama_kelas] = Nilai::whereIn('siswa_id', $siswaIds)
                ->whereNotNull('rata_rata')
                ->avg('rata_rata');
        }
        
        // Nilai per guru
        $nilaiPerGuru = [];
        foreach ($guru as $g) {
            $nilaiPerGuru[$g->name] = Nilai::where('guru_id', $g->id)
                ->whereNotNull('rata_rata')
                ->avg('rata_rata');
        }
        
        return view('kepsek.monitoring', compact('nilaiPerMapel', 'nilaiPerKelas', 'nilaiPerGuru', 'mapel', 'kelas', 'guru'));
    }
}
