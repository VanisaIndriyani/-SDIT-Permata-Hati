<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mapel;
use App\Models\User;
use App\Models\Kelas;
use App\Models\MapelGuru;
use Illuminate\Http\Request;

class MapelController extends Controller
{
    public function index()
    {
        $mapel = Mapel::with('mapelGuru.guru', 'mapelGuru.kelas')->paginate(10);
        $guru = User::where('role', 'guru')->get();
        $kelas = Kelas::all();
        return view('admin.mapel.index', compact('mapel', 'guru', 'kelas'));
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

    public function assignGuru(Request $request, string $id)
    {
        $mapel = Mapel::findOrFail($id);
        
        $validated = $request->validate([
            'guru_id' => 'required|exists:users,id',
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        // Check if already assigned
        $existing = MapelGuru::where('mapel_id', $id)
            ->where('guru_id', $validated['guru_id'])
            ->where('kelas_id', $validated['kelas_id'])
            ->first();

        if ($existing) {
            return redirect()->back()
                ->with('error', 'Guru sudah di-assign ke mapel dan kelas ini!');
        }

        MapelGuru::create([
            'mapel_id' => $id,
            'guru_id' => $validated['guru_id'],
            'kelas_id' => $validated['kelas_id'],
        ]);

        return redirect()->back()
            ->with('success', 'Guru berhasil di-assign ke mapel!');
    }

    public function removeGuru(string $mapelId, string $mapelGuruId)
    {
        $mapelGuru = MapelGuru::where('mapel_id', $mapelId)
            ->findOrFail($mapelGuruId);
        
        $mapelGuru->delete();

        return redirect()->back()
            ->with('success', 'Guru berhasil dihapus dari mapel!');
    }
}
