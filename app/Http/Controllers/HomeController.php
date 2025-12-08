<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        
        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.users.index');
            case 'guru':
                return redirect()->route('guru.dashboard');
            case 'wali_kelas':
                return redirect()->route('wali.dashboard');
            case 'kepsek':
                return redirect()->route('kepsek.dashboard');
            default:
                return redirect()->route('login');
        }
    }
}
