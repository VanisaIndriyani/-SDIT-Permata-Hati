@extends('layouts.app')

@section('title', 'Laporan - Kepala Sekolah')

@section('content')
<h2 class="fw-bold text-primary-custom mb-4" style="padding-top: 10px;"><i class="bi bi-file-earmark-bar-graph"></i> Laporan</h2>

<!-- Statistik Cards -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card stat-card">
            <div class="card-body">
                <h6 class="text-muted mb-1">Total Siswa</h6>
                <h3 class="mb-0 text-primary-custom">{{ $totalSiswa }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stat-card">
            <div class="card-body">
                <h6 class="text-muted mb-1">Total Nilai</h6>
                <h3 class="mb-0 text-primary-custom">{{ $totalNilai }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stat-card">
            <div class="card-body">
                <h6 class="text-muted mb-1">Rata-rata Umum</h6>
                <h3 class="mb-0 text-primary-custom">{{ number_format($rataRataUmum, 2) }}</h3>
            </div>
        </div>
    </div>
</div>

<!-- Grafik Rata-rata Nilai per Kelas -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-primary-custom text-white">
                <h5 class="mb-0"><i class="bi bi-graph-up"></i> Rata-rata Nilai per Kelas</h5>
            </div>
            <div class="card-body">
                <canvas id="chartKelas" height="100"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-primary-custom text-white">
                <h5 class="mb-0"><i class="bi bi-book"></i> Rata-rata Nilai per Mapel</h5>
            </div>
            <div class="card-body">
                <canvas id="chartMapel" height="100"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Grafik Kinerja Guru -->
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-primary-custom text-white">
                <h5 class="mb-0"><i class="bi bi-person-badge"></i> Grafik Kinerja Guru</h5>
            </div>
            <div class="card-body">
                <canvas id="chartKinerjaGuru" height="80"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Tabel Nilai Tertinggi dan Terendah -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="bi bi-trophy"></i> Nilai Tertinggi</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Siswa</th>
                                <th>Mapel</th>
                                <th>Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($nilaiTertinggi as $index => $nilai)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $nilai->siswa->nama_siswa }}</td>
                                <td>{{ $nilai->mapel->nama_mapel }}</td>
                                <td><strong>{{ number_format($nilai->rata_rata, 2) }}</strong></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0"><i class="bi bi-exclamation-triangle"></i> Nilai Terendah</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Siswa</th>
                                <th>Mapel</th>
                                <th>Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($nilaiTerendah as $index => $nilai)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $nilai->siswa->nama_siswa }}</td>
                                <td>{{ $nilai->mapel->nama_mapel }}</td>
                                <td><strong>{{ number_format($nilai->rata_rata, 2) }}</strong></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Laporan Nilai per Kelas -->
<div class="card mb-4">
    <div class="card-header bg-primary-custom text-white">
        <h5 class="mb-0"><i class="bi bi-table"></i> Laporan Nilai per Kelas</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Kelas</th>
                        <th>Jumlah Siswa</th>
                        <th>Rata-rata Nilai</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kelas as $k)
                    @php
                        $siswaIds = $k->siswa->pluck('id');
                        $rataRata = \App\Models\Nilai::whereIn('siswa_id', $siswaIds)
                            ->whereNotNull('rata_rata')
                            ->avg('rata_rata');
                    @endphp
                    <tr>
                        <td>{{ $k->nama_kelas }}</td>
                        <td>{{ $k->siswa->count() }}</td>
                        <td><strong>{{ number_format($rataRata ?? 0, 2) }}</strong></td>
                        <td>
                            <a href="{{ route('kepsek.laporan.export-kelas', $k->id) }}" class="btn btn-sm btn-success">
                                <i class="bi bi-file-excel"></i> Excel
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="card">
    <div class="card-header bg-primary-custom text-white">
        <h5 class="mb-0"><i class="bi bi-download"></i> Ekspor Laporan</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4 mb-2">
                <a href="{{ route('kepsek.laporan.export-semester') }}" class="btn btn-success w-100">
                    <i class="bi bi-file-excel"></i> Rekap Semester (Excel)
                </a>
            </div>
            <div class="col-md-4 mb-2">
                <a href="{{ route('kepsek.laporan.export-pendidikan') }}" class="btn btn-info w-100">
                    <i class="bi bi-file-excel"></i> Laporan Pendidikan (Excel)
                </a>
            </div>
            <div class="col-md-4 mb-2">
                <a href="{{ route('kepsek.laporan.export-kelas') }}" class="btn btn-primary w-100">
                    <i class="bi bi-file-excel"></i> Semua Kelas (Excel)
                </a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Chart Rata-rata Nilai per Kelas
const ctxKelas = document.getElementById('chartKelas');
if (ctxKelas) {
    new Chart(ctxKelas, {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_keys($rataRataPerKelas)) !!},
            datasets: [{
                label: 'Rata-rata Nilai',
                data: {!! json_encode(array_values($rataRataPerKelas)) !!},
                backgroundColor: 'rgba(40, 167, 69, 0.8)',
                borderColor: 'rgba(40, 167, 69, 1)',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    ticks: {
                        stepSize: 10
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
}

// Chart Rata-rata Nilai per Mapel
const ctxMapel = document.getElementById('chartMapel');
if (ctxMapel) {
    new Chart(ctxMapel, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode(array_keys($rataRataPerMapel)) !!},
            datasets: [{
                data: {!! json_encode(array_values($rataRataPerMapel)) !!},
                backgroundColor: [
                    'rgba(40, 167, 69, 0.8)',
                    'rgba(220, 53, 69, 0.8)',
                    'rgba(255, 193, 7, 0.8)',
                    'rgba(0, 123, 255, 0.8)',
                    'rgba(108, 117, 125, 0.8)',
                    'rgba(23, 162, 184, 0.8)',
                    'rgba(102, 16, 242, 0.8)',
                    'rgba(253, 126, 20, 0.8)',
                    'rgba(32, 201, 151, 0.8)',
                    'rgba(13, 110, 253, 0.8)',
                    'rgba(111, 66, 193, 0.8)',
                    'rgba(214, 51, 132, 0.8)'
                ],
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'right'
                }
            }
        }
    });
}

// Chart Kinerja Guru
const ctxKinerjaGuru = document.getElementById('chartKinerjaGuru');
if (ctxKinerjaGuru) {
    new Chart(ctxKinerjaGuru, {
        type: 'line',
        data: {
            labels: {!! json_encode(array_keys($kinerjaGuru)) !!},
            datasets: [{
                label: 'Rata-rata Nilai',
                data: {!! json_encode(array_values($kinerjaGuru)) !!},
                borderColor: 'rgba(40, 167, 69, 1)',
                backgroundColor: 'rgba(40, 167, 69, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    ticks: {
                        stepSize: 10
                    }
                }
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                }
            }
        }
    });
}

</script>
@endpush
@endsection
