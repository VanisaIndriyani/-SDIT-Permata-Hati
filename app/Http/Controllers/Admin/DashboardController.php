<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Siswa;
use App\Models\Nilai;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $jumlahUser = User::count();
        $jumlahGuru = User::where('role', 'guru')->count();
        $jumlahWaliKelas = User::where('role', 'wali_kelas')->count();
        $jumlahKelas = Kelas::count();
        $jumlahMapel = Mapel::count();
        $jumlahSiswa = Siswa::count();
        $jumlahNilai = Nilai::count();
        
        // Statistik per role
        $statistikRole = [
            'admin' => User::where('role', 'admin')->count(),
            'guru' => User::where('role', 'guru')->count(),
            'wali_kelas' => User::where('role', 'wali_kelas')->count(),
            'kepsek' => User::where('role', 'kepsek')->count(),
        ];
        
        // Data terbaru
        $usersTerbaru = User::latest()->take(5)->get();
        $siswaTerbaru = Siswa::with('kelas')->latest()->take(5)->get();
        
        return view('admin.dashboard', compact(
            'jumlahUser',
            'jumlahGuru',
            'jumlahWaliKelas',
            'jumlahKelas',
            'jumlahMapel',
            'jumlahSiswa',
            'jumlahNilai',
            'statistikRole',
            'usersTerbaru',
            'siswaTerbaru'
        ));
    }
}
