<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mapel;
use App\Models\User;
use Illuminate\Http\Request;

class MapelController extends Controller
{
    public function index()
    {
        $mapel = Mapel::with('mapelGuru.guru')->paginate(10);
        return view('admin.mapel.index', compact('mapel'));
    }

    public function create()
    {
        $guru = User::where('role', 'guru')->get();
        return view('admin.mapel.create', compact('guru'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_mapel' => 'required|string|max:255|unique:mapel',
            'nama_mapel' => 'required|string|max:255',
        ]);

        Mapel::create($validated);

        return redirect()->route('admin.mapel.index')
            ->with('success', 'Mata pelajaran berhasil ditambahkan!');
    }

    public function show(string $id)
    {
        $mapel = Mapel::with('mapelGuru.guru', 'mapelGuru.kelas')->findOrFail($id);
        return view('admin.mapel.show', compact('mapel'));
    }

    public function edit(string $id)
    {
        $mapel = Mapel::findOrFail($id);
        return view('admin.mapel.edit', compact('mapel'));
    }

    public function update(Request $request, string $id)
    {
        $mapel = Mapel::findOrFail($id);
        
        $validated = $request->validate([
            'kode_mapel' => 'required|string|max:255|unique:mapel,kode_mapel,' . $id,
            'nama_mapel' => 'required|string|max:255',
        ]);

        $mapel->update($validated);

        return redirect()->route('admin.mapel.index')
            ->with('success', 'Mata pelajaran berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $mapel = Mapel::findOrFail($id);
        $mapel->delete();

        return redirect()->route('admin.mapel.index')
            ->with('success', 'Mata pelajaran berhasil dihapus!');
    }
}
