@extends('layouts.app')

@section('title', 'Cetak / Ekspor - Wali Kelas')

@section('content')
<h2 class="fw-bold text-primary-custom mb-4" style="padding-top: 10px;"><i class="bi bi-printer"></i> Cetak / Ekspor Raport</h2>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIS</th>
                        <th>Nama Siswa</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($siswa as $index => $s)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $s->nis }}</td>
                        <td>{{ $s->nama_siswa }}</td>
                        <td>
                            <a href="{{ route('wali.cetak.pdf', $s->id) }}" class="btn btn-sm btn-primary" target="_blank">
                                <i class="bi bi-download"></i> Download PDF
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

