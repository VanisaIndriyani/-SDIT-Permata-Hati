@extends('layouts.app')

@section('title', 'Data Kelas - Kepala Sekolah')

@section('content')
<h2 class="fw-bold text-primary-custom mb-4"><i class="bi bi-building"></i> Data Kelas</h2>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Kelas</th>
                        <th>Wali Kelas</th>
                        <th>Jumlah Siswa</th>
                        <th>Daftar Mapel</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kelas as $index => $k)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $k->nama_kelas }}</td>
                        <td>{{ $k->waliKelas->name ?? '-' }}</td>
                        <td>{{ $k->jumlah_siswa }}</td>
                        <td>
                            @php
                                $mapel = \App\Models\MapelGuru::where('kelas_id', $k->id)
                                    ->with('mapel')
                                    ->get()
                                    ->unique('mapel_id')
                                    ->pluck('mapel.nama_mapel');
                            @endphp
                            {{ $mapel->implode(', ') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

