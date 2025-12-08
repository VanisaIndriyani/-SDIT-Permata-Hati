@extends('layouts.app')

@section('title', 'Monitoring Nilai - Kepala Sekolah')

@section('content')
<h2 class="fw-bold text-primary-custom mb-4"><i class="bi bi-graph-up"></i> Monitoring Nilai</h2>

<div class="row mb-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-primary-custom text-white">
                <h5 class="mb-0">Nilai per Mapel</h5>
            </div>
            <div class="card-body">
                <canvas id="chartMapel" height="100"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-primary-custom text-white">
                <h5 class="mb-0">Nilai per Kelas</h5>
            </div>
            <div class="card-body">
                <canvas id="chartKelas" height="100"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header bg-primary-custom text-white">
        <h5 class="mb-0">Nilai per Guru</h5>
    </div>
    <div class="card-body">
        <canvas id="chartGuru" height="100"></canvas>
    </div>
</div>

@push('scripts')
<script>
// Chart Mapel
const ctxMapel = document.getElementById('chartMapel');
if (ctxMapel) {
    new Chart(ctxMapel, {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_keys($nilaiPerMapel)) !!},
            datasets: [{
                label: 'Rata-rata Nilai',
                data: {!! json_encode(array_values($nilaiPerMapel)) !!},
                backgroundColor: 'rgba(40, 167, 69, 0.8)'
            }]
        }
    });
}

// Chart Kelas
const ctxKelas = document.getElementById('chartKelas');
if (ctxKelas) {
    new Chart(ctxKelas, {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_keys($nilaiPerKelas)) !!},
            datasets: [{
                label: 'Rata-rata Nilai',
                data: {!! json_encode(array_values($nilaiPerKelas)) !!},
                backgroundColor: 'rgba(40, 167, 69, 0.8)'
            }]
        }
    });
}

// Chart Guru
const ctxGuru = document.getElementById('chartGuru');
if (ctxGuru) {
    new Chart(ctxGuru, {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_keys($nilaiPerGuru)) !!},
            datasets: [{
                label: 'Rata-rata Nilai',
                data: {!! json_encode(array_values($nilaiPerGuru)) !!},
                backgroundColor: 'rgba(40, 167, 69, 0.8)'
            }]
        }
    });
}
</script>
@endpush
@endsection

