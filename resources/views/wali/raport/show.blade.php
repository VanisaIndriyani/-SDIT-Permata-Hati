@extends('layouts.app')

@section('title', 'Detail Raport')

@section('content')
<h2 class="fw-bold text-primary-custom mb-4"><i class="bi bi-file-earmark-text"></i> Raport Siswa</h2>

<div class="card mb-4">
    <div class="card-body">
        <h5>Data Siswa</h5>
        <p><strong>NIS:</strong> {{ $siswa->nis }}</p>
        <p><strong>Nama:</strong> {{ $siswa->nama_siswa }}</p>
        <p><strong>Kelas:</strong> {{ $siswa->kelas->nama_kelas }}</p>
        <p><strong>Tahun Ajaran:</strong> {{ $siswa->tahunAjaran->tahun_ajaran ?? '-' }} - {{ $siswa->tahunAjaran->semester ?? '-' }}</p>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <h5>Nilai Mata Pelajaran</h5>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Mata Pelajaran</th>
                        <th>UH</th>
                        <th>PTS</th>
                        <th>PAS</th>
                        <th>Nilai Akhir</th>
                        <th>Deskripsi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($siswa->nilai as $index => $nilai)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $nilai->mapel->nama_mapel }}</td>
                        <td>{{ $nilai->nilai_uh ?? '-' }}</td>
                        <td>{{ $nilai->nilai_pts ?? '-' }}</td>
                        <td>{{ $nilai->nilai_pas ?? '-' }}</td>
                        <td><strong>{{ $nilai->rata_rata ?? '-' }}</strong></td>
                        <td>{{ $nilai->deskripsi_kompetensi ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-3">
    <a href="{{ route('wali.raport.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
    <a href="{{ route('wali.cetak.pdf', $siswa->id) }}" class="btn btn-primary" target="_blank">
        <i class="bi bi-printer"></i> Cetak PDF
    </a>
</div>
@endsection

