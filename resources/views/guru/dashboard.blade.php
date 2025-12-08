@extends('layouts.app')

@section('title', 'Dashboard Guru')

@section('content')
<h2 class="fw-bold text-primary-custom mb-4" style="padding-top: 10px;"><i class="bi bi-speedometer2"></i> Dashboard Guru</h2>

<div class="row mb-4">
    <div class="col-md-4">
        <div class="card stat-card">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-building"></i> Jumlah Kelas</h5>
                <h2 class="text-primary-custom">{{ $jumlahKelas }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stat-card">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-book"></i> Mata Pelajaran</h5>
                <h2 class="text-primary-custom">{{ $mapelGuru->unique('mapel_id')->count() }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stat-card">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-graph-up"></i> Progress Input</h5>
                <h2 class="text-primary-custom">{{ number_format($progress, 1) }}%</h2>
            </div>
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header bg-primary-custom text-white">
        <h5 class="mb-0"><i class="bi bi-book"></i> Daftar Mata Pelajaran</h5>
    </div>
    <div class="card-body">
        <div class="row">
            @foreach($mapelGuru->unique('mapel_id') as $mg)
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h6>{{ $mg->mapel->nama_mapel }}</h6>
                        <small class="text-muted">Kelas: {{ $mg->kelas->nama_kelas }}</small>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

@if(count($belumLengkap) > 0)
<div class="card">
    <div class="card-header bg-danger text-white">
        <h5 class="mb-0"><i class="bi bi-exclamation-triangle"></i> Notifikasi Nilai Belum Lengkap</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>Mapel</th>
                        <th>Kelas</th>
                        <th>Siswa</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($belumLengkap as $item)
                    <tr>
                        <td>{{ $item['mapel'] }}</td>
                        <td>{{ $item['kelas'] }}</td>
                        <td>{{ $item['siswa'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif
@endsection

