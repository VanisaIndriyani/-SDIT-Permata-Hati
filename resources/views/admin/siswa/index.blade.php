@extends('layouts.app')

@section('title', 'Kelola Siswa - Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4" style="padding-top: 10px;">
    <h2 class="fw-bold text-primary-custom"><i class="bi bi-person-badge"></i> Kelola Siswa</h2>
    <a href="{{ route('admin.siswa.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Tambah Siswa</a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIS</th>
                        <th>Nama Siswa</th>
                        <th>Jenis Kelamin</th>
                        <th>Kelas</th>
                        <th>Tahun Ajaran</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($siswa as $index => $s)
                    <tr>
                        <td>{{ $siswa->firstItem() + $index }}</td>
                        <td>{{ $s->nis }}</td>
                        <td>{{ $s->nama_siswa }}</td>
                        <td>{{ $s->jenis_kelamin ?? '-' }}</td>
                        <td>{{ $s->kelas->nama_kelas ?? '-' }}</td>
                        <td>{{ $s->tahunAjaran->tahun_ajaran ?? '-' }}</td>
                        <td>
                            <a href="{{ route('admin.siswa.edit', $s->id) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('admin.siswa.destroy', $s->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus siswa ini?')"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center">Tidak ada data</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3 d-flex justify-content-center">
            {{ $siswa->links() }}
        </div>
    </div>
</div>
@endsection

