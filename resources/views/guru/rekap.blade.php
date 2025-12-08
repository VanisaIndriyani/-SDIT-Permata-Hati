@extends('layouts.app')

@section('title', 'Rekap Nilai - Guru')

@section('content')
<h2 class="fw-bold text-primary-custom mb-4" style="padding-top: 10px;"><i class="bi bi-table"></i> Rekap Nilai</h2>

<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('guru.rekap') }}">
            <div class="row">
                <div class="col-md-6">
                    <label class="form-label">Pilih Mata Pelajaran</label>
                    <select name="mapel_id" class="form-select" onchange="this.form.submit()">
                        <option value="">-- Pilih Mapel --</option>
                        @foreach($mapelGuru as $mg)
                        <option value="{{ $mg->mapel_id }}" {{ request('mapel_id') == $mg->mapel_id ? 'selected' : '' }}>
                            {{ $mg->mapel->nama_mapel }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </form>
    </div>
</div>

@if(request('mapel_id') && $nilai->count() > 0)
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Siswa</th>
                        <th>UH</th>
                        <th>PTS</th>
                        <th>PAS</th>
                        <th>Rata-rata</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($nilai as $index => $n)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $n->siswa->nama_siswa }}</td>
                        <td>{{ $n->nilai_uh ?? '-' }}</td>
                        <td>{{ $n->nilai_pts ?? '-' }}</td>
                        <td>{{ $n->nilai_pas ?? '-' }}</td>
                        <td><strong>{{ $n->rata_rata ?? '-' }}</strong></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif
@endsection

