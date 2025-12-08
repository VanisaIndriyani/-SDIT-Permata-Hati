<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\MapelGuru;
use App\Models\Nilai;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NilaiController extends Controller
{
    public function index()
    {
        $guru = Auth::user();
        
        // Ambil mapel yang benar-benar di-assign ke guru ini
        $mapelGuru = MapelGuru::where('guru_id', $guru->id)
            ->with('mapel', 'kelas')
            ->get()
            ->unique('mapel_id');
        
        // Validasi: pastikan mapel yang dipilih benar-benar di-assign ke guru ini
        $mapelId = request('mapel_id');
        $siswa = collect();
        $kelas = null;
        
        if ($mapelId) {
            // Validasi: cek apakah mapel ini benar-benar di-assign ke guru ini
            $mapelGuruSelected = MapelGuru::where('guru_id', $guru->id)
                ->where('mapel_id', $mapelId)
                ->with('kelas')
                ->first();
            
            if (!$mapelGuruSelected) {
                // Jika mapel tidak di-assign ke guru ini, redirect kembali tanpa mapel_id
                return redirect()->route('guru.nilai.index')
                    ->with('error', 'Anda tidak memiliki akses ke mata pelajaran ini!');
            }
            
            if ($mapelGuruSelected && $mapelGuruSelected->kelas) {
                $kelas = $mapelGuruSelected->kelas;
                $kelasId = $mapelGuruSelected->kelas->id;
                $siswa = Siswa::where('kelas_id', $kelasId)
                    ->with(['nilai' => function($query) use ($mapelId, $guru) {
                        $query->where('mapel_id', $mapelId)
                              ->where('guru_id', $guru->id);
                    }])
                    ->orderBy('nama_siswa')
                    ->get();
            }
        }
        
        return view('guru.nilai.index', compact('mapelGuru', 'siswa', 'mapelId', 'kelas'));
    }

    public function store(Request $request)
    {
        $guru = Auth::user();
        $tahunAjaran = TahunAjaran::where('is_active', true)->first();
        
        if (!$tahunAjaran) {
            return redirect()->back()->with('error', 'Tahun ajaran aktif tidak ditemukan!');
        }
        
        $nilaiData = $request->input('nilai', []);
        $siswaIds = $request->input('siswa_id', []);
        $mapelId = $request->input('mapel_id');
        
        if (empty($siswaIds) || !$mapelId) {
            return redirect()->back()->with('error', 'Data tidak lengkap!');
        }
        
        $saved = 0;
        foreach ($siswaIds as $siswaId) {
            $nilaiSiswa = $nilaiData[$siswaId] ?? [];
            
            $nilaiUh = !empty($nilaiSiswa['uh']) ? (float)$nilaiSiswa['uh'] : null;
            $nilaiPts = !empty($nilaiSiswa['pts']) ? (float)$nilaiSiswa['pts'] : null;
            $nilaiPas = !empty($nilaiSiswa['pas']) ? (float)$nilaiSiswa['pas'] : null;
            $deskripsi = !empty($nilaiSiswa['deskripsi']) ? trim($nilaiSiswa['deskripsi']) : null;
            
            // Validasi
            if ($nilaiUh !== null && ($nilaiUh < 0 || $nilaiUh > 100)) {
                continue;
            }
            if ($nilaiPts !== null && ($nilaiPts < 0 || $nilaiPts > 100)) {
                continue;
            }
            if ($nilaiPas !== null && ($nilaiPas < 0 || $nilaiPas > 100)) {
                continue;
            }
            
            // Hitung rata-rata
            $nilaiArray = array_filter([$nilaiUh, $nilaiPts, $nilaiPas], function($v) {
                return $v !== null && $v !== '';
            });
            $rataRata = !empty($nilaiArray) ? array_sum($nilaiArray) / count($nilaiArray) : null;
            
            Nilai::updateOrCreate(
                [
                    'siswa_id' => $siswaId,
                    'mapel_id' => $mapelId,
                    'guru_id' => $guru->id,
                    'tahun_ajaran_id' => $tahunAjaran->id,
                ],
                [
                    'nilai_uh' => $nilaiUh,
                    'nilai_pts' => $nilaiPts,
                    'nilai_pas' => $nilaiPas,
                    'rata_rata' => $rataRata,
                    'deskripsi_kompetensi' => $deskripsi,
                ]
            );
            $saved++;
        }
        
        return redirect()->back()->with('success', "Nilai berhasil disimpan untuk {$saved} siswa!");
    }

    public function update(Request $request, string $id)
    {
        $nilai = Nilai::findOrFail($id);
        $guru = Auth::user();
        
        if ($nilai->guru_id != $guru->id) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk mengubah nilai ini.');
        }
        
        $validated = $request->validate([
            'nilai_uh' => 'nullable|numeric|min:0|max:100',
            'nilai_pts' => 'nullable|numeric|min:0|max:100',
            'nilai_pas' => 'nullable|numeric|min:0|max:100',
        ]);
        
        // Hitung rata-rata
        $nilaiArray = array_filter([
            $validated['nilai_uh'],
            $validated['nilai_pts'],
            $validated['nilai_pas']
        ]);
        $validated['rata_rata'] = !empty($nilaiArray) ? array_sum($nilaiArray) / count($nilaiArray) : null;
        
        $nilai->update($validated);
        
        return redirect()->back()->with('success', 'Nilai berhasil diperbarui!');
    }
}
