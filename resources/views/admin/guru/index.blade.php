@extends('layouts.app')

@section('title', 'Kelola Guru - Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold text-primary-custom">
        <i class="bi bi-person-badge"></i> Kelola Guru
    </h2>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>NIP</th>
                        <th>Mapel yang Diampu</th>
                        <th>Kelas yang Diajar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($guru as $index => $g)
                    <tr>
                        <td>{{ $guru->firstItem() + $index }}</td>
                        <td>{{ $g->name }}</td>
                        <td>{{ $g->nip ?? '-' }}</td>
                        <td>
                            @if($g->mapelGuru->count() > 0)
                                @foreach($g->mapelGuru as $mg)
                                    <span class="badge bg-primary me-1">{{ $mg->mapel->nama_mapel }}</span>
                                @endforeach
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @if($g->mapelGuru->count() > 0)
                                @php
                                    $kelas = $g->mapelGuru->pluck('kelas.nama_kelas')->unique()->filter();
                                @endphp
                                @if($kelas->count() > 0)
                                    @foreach($kelas as $namaKelas)
                                        <span class="badge bg-success me-1">{{ $namaKelas }}</span>
                                    @endforeach
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada data guru</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3 d-flex justify-content-center">
            {{ $guru->links() }}
        </div>
    </div>
</div>
@endsection

