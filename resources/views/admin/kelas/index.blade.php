@extends('layouts.app')

@section('title', 'Kelola Kelas - Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold text-primary-custom"><i class="bi bi-building"></i> Kelola Kelas</h2>
    <a href="{{ route('admin.kelas.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Tambah Kelas</a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Kelas</th>
                        <th>Wali Kelas</th>
                        <th>Jumlah Siswa</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kelas as $index => $k)
                    <tr>
                        <td>{{ $kelas->firstItem() + $index }}</td>
                        <td>{{ $k->nama_kelas }}</td>
                        <td>{{ $k->waliKelas->name ?? '-' }}</td>
                        <td>{{ $k->jumlah_siswa }}</td>
                        <td>
                            <a href="{{ route('admin.kelas.edit', $k->id) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('admin.kelas.destroy', $k->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus kelas ini?')"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center">Tidak ada data</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3 d-flex justify-content-center">
            {{ $kelas->links() }}
        </div>
    </div>
</div>
@endsection

