@extends('layouts.app')

@section('title', 'Dashboard Wali Kelas')

@section('content')
<h2 class="fw-bold text-primary-custom mb-4"><i class="bi bi-speedometer2"></i> Dashboard Wali Kelas</h2>

<div class="row mb-4">
    <div class="col-md-4">
        <div class="card stat-card">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-people"></i> Jumlah Siswa</h5>
                <h2 class="text-primary-custom">{{ $jumlahSiswa }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stat-card">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-building"></i> Kelas</h5>
                <h2 class="text-primary-custom">{{ $kelas->nama_kelas }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stat-card">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-graph-up"></i> Progress Raport</h5>
                <h2 class="text-primary-custom">{{ number_format($progress, 1) }}%</h2>
            </div>
        </div>
    </div>
</div>

@if(count($belumLengkap) > 0)
<div class="card">
    <div class="card-header bg-danger text-white">
        <h5 class="mb-0"><i class="bi bi-exclamation-triangle"></i> Notifikasi Nilai Belum Lengkap</h5>
    </div>
    <div class="card-body">
        <p>Berikut siswa yang belum memiliki nilai:</p>
        <ul>
            @foreach($belumLengkap as $nama)
            <li>{{ $nama }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endif
@endsection

