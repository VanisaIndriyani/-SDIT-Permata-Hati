@extends('layouts.app')

@section('title', 'Dashboard Kepala Sekolah')

@section('content')
<h2 class="fw-bold text-primary-custom mb-4" style="padding-top: 10px;"><i class="bi bi-speedometer2"></i> Dashboard Kepala Sekolah</h2>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="card stat-card">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-people"></i> Jumlah Guru</h5>
                <h2 class="text-primary-custom">{{ $jumlahGuru }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-person-badge"></i> Jumlah Siswa</h5>
                <h2 class="text-primary-custom">{{ $jumlahSiswa }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-graph-up"></i> Progress Input</h5>
                <h2 class="text-primary-custom">{{ number_format($progress, 1) }}%</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-star"></i> Rata-rata Nilai</h5>
                <h2 class="text-primary-custom">{{ number_format($rataRataNilai ?? 0, 2) }}</h2>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header bg-primary-custom text-white">
        <h5 class="mb-0"><i class="bi bi-graph-up"></i> Grafik Rata-rata Nilai per Kelas</h5>
    </div>
    <div class="card-body">
        <canvas id="chartKelas" height="100"></canvas>
    </div>
</div>

@push('scripts')
<script>
const ctx = document.getElementById('chartKelas');
if (ctx) {
    const chartData = @json($chartKelas);
    const labels = chartData.map(item => item.nama_kelas);
    const data = chartData.map(item => item.rata_rata);
    
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Rata-rata Nilai',
                data: data,
                backgroundColor: 'rgba(40, 167, 69, 0.8)',
                borderColor: 'rgba(40, 167, 69, 1)',
                borderWidth: 1
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
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Rata-rata: ' + context.parsed.y.toFixed(2);
                        }
                    }
                }
            }
        }
    });
}
</script>
@endpush
@endsection

