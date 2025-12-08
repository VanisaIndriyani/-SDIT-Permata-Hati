<?php

namespace App\Http\Controllers\Kepsek;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Nilai;
use App\Models\Mapel;
use App\Models\User;
use App\Models\Siswa;
use App\Exports\LaporanKelasExport;
use App\Exports\RekapSemesterExport;
use App\Exports\LaporanPendidikanExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        $kelas = Kelas::all();
        $mapel = Mapel::all();
        $guru = User::where('role', 'guru')->get();
        
        // Rata-rata nilai per kelas
        $rataRataPerKelas = [];
        foreach ($kelas as $k) {
            $siswaIds = $k->siswa->pluck('id');
            $rataRataPerKelas[$k->nama_kelas] = Nilai::whereIn('siswa_id', $siswaIds)
                ->whereNotNull('rata_rata')
                ->avg('rata_rata') ?? 0;
        }
        
        // Rata-rata nilai per mapel
        $rataRataPerMapel = [];
        foreach ($mapel as $m) {
            $rataRataPerMapel[$m->nama_mapel] = Nilai::where('mapel_id', $m->id)
                ->whereNotNull('rata_rata')
                ->avg('rata_rata') ?? 0;
        }
        
        // Grafik kinerja guru (rata-rata nilai yang diberikan guru)
        $kinerjaGuru = [];
        foreach ($guru as $g) {
            $kinerjaGuru[$g->name] = Nilai::where('guru_id', $g->id)
                ->whereNotNull('rata_rata')
                ->avg('rata_rata') ?? 0;
        }
        
        // Nilai tertinggi dan terendah
        $nilaiTertinggi = Nilai::with('siswa', 'mapel')
            ->whereNotNull('rata_rata')
            ->orderBy('rata_rata', 'desc')
            ->take(10)
            ->get();
        
        $nilaiTerendah = Nilai::with('siswa', 'mapel')
            ->whereNotNull('rata_rata')
            ->orderBy('rata_rata', 'asc')
            ->take(10)
            ->get();
        
        // Statistik umum
        $totalSiswa = Siswa::count();
        $totalNilai = Nilai::whereNotNull('rata_rata')->count();
        $rataRataUmum = Nilai::whereNotNull('rata_rata')->avg('rata_rata') ?? 0;
        
        return view('kepsek.laporan', compact(
            'kelas',
            'mapel',
            'guru',
            'rataRataPerKelas',
            'rataRataPerMapel',
            'kinerjaGuru',
            'nilaiTertinggi',
            'nilaiTerendah',
            'totalSiswa',
            'totalNilai',
            'rataRataUmum'
        ));
    }

    public function exportKelas($kelasId = null)
    {
        $filename = $kelasId 
            ? 'Laporan_Kelas_' . Kelas::find($kelasId)->nama_kelas . '_' . date('Y-m-d') . '.xlsx'
            : 'Laporan_Semua_Kelas_' . date('Y-m-d') . '.xlsx';
        
        return Excel::download(new LaporanKelasExport($kelasId), $filename);
    }

    public function exportSemester()
    {
        $filename = 'Rekap_Semester_' . date('Y-m-d') . '.xlsx';
        return Excel::download(new RekapSemesterExport(), $filename);
    }

    public function exportPendidikan()
    {
        $filename = 'Laporan_Pendidikan_' . date('Y-m-d') . '.xlsx';
        return Excel::download(new LaporanPendidikanExport(), $filename);
    }
}
