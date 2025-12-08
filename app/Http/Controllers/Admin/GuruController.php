<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    public function index()
    {
        $guru = User::where('role', 'guru')
            ->with(['mapelGuru.mapel', 'mapelGuru.kelas'])
            ->orderBy('name')
            ->paginate(10);
        
        return view('admin.guru.index', compact('guru'));
    }
}
