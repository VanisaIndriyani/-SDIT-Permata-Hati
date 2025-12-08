@extends('layouts.app')

@section('title', 'Raport - Wali Kelas')

@section('content')
<h2 class="fw-bold text-primary-custom mb-4"><i class="bi bi-file-earmark-text"></i> Raport</h2>

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
                            <a href="{{ route('wali.raport.show', $s->id) }}" class="btn btn-sm btn-primary">
                                <i class="bi bi-eye"></i> Lihat Raport
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

