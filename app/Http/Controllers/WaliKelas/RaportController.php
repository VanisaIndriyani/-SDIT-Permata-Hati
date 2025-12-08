<?php

namespace App\Http\Controllers\WaliKelas;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RaportController extends Controller
{
    public function index()
    {
        $waliKelas = Auth::user();
        $kelas = Kelas::where('wali_kelas_id', $waliKelas->id)->first();
        
        if (!$kelas) {
            return redirect()->back()->with('error', 'Anda belum ditugaskan sebagai wali kelas.');
        }
        
        $siswa = Siswa::where('kelas_id', $kelas->id)->get();
        
        return view('wali.raport.index', compact('siswa', 'kelas'));
    }

    public function show($siswaId)
    {
        $siswa = Siswa::with(['kelas', 'tahunAjaran', 'nilai.mapel', 'nilai.guru'])->findOrFail($siswaId);
        
        return view('wali.raport.show', compact('siswa'));
    }

    public function cetak()
    {
        $waliKelas = Auth::user();
        $kelas = Kelas::where('wali_kelas_id', $waliKelas->id)->first();
        
        if (!$kelas) {
            return redirect()->back()->with('error', 'Anda belum ditugaskan sebagai wali kelas.');
        }
        
        $siswa = Siswa::where('kelas_id', $kelas->id)->get();
        
        return view('wali.cetak', compact('siswa', 'kelas'));
    }

    public function cetakPdf($siswaId)
    {
        $siswa = Siswa::with(['kelas', 'tahunAjaran', 'nilai.mapel', 'nilai.guru'])->findOrFail($siswaId);
        
        // TODO: Implement PDF generation using DomPDF or similar
        return view('wali.raport.pdf', compact('siswa'));
    }
}
