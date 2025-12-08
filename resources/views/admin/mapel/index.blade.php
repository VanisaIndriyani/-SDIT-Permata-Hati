@extends('layouts.app')

@section('title', 'Kelola Mapel - Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4" style="padding-top: 10px;">
    <h2 class="fw-bold text-primary-custom"><i class="bi bi-book"></i> Kelola Mata Pelajaran</h2>
    <a href="{{ route('admin.mapel.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Tambah Mapel</a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Mapel</th>
                        <th>Nama Mapel</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mapel as $index => $m)
                    <tr>
                        <td>{{ $mapel->firstItem() + $index }}</td>
                        <td>{{ $m->kode_mapel }}</td>
                        <td>{{ $m->nama_mapel }}</td>
                        <td>
                            <a href="{{ route('admin.mapel.edit', $m->id) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('admin.mapel.destroy', $m->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus mapel ini?')"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center">Tidak ada data</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3 d-flex justify-content-center">
            {{ $mapel->links() }}
        </div>
    </div>
</div>
@endsection

