@extends('layouts.app')

@section('title', 'Kelola Mapel - Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4" style="padding-top: 10px;">
    <h2 class="fw-bold text-primary-custom"><i class="bi bi-book"></i> Kelola Mata Pelajaran</h2>
    <a href="{{ route('admin.mapel.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Tambah Mapel</a>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="bi bi-check-circle"></i> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="bi bi-exclamation-circle"></i> {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Mapel</th>
                        <th>Nama Mapel</th>
                        <th>Guru yang Mengajar</th>
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
                            @if($m->mapelGuru->count() > 0)
                                <ul class="list-unstyled mb-0">
                                    @foreach($m->mapelGuru as $mg)
                                    <li class="mb-1">
                                        <span class="badge bg-primary">{{ $mg->guru->name }}</span>
                                        <small class="text-muted">({{ $mg->kelas->nama_kelas }})</small>
                                        <form action="{{ route('admin.mapel.remove-guru', [$m->id, $mg->id]) }}" method="POST" class="d-inline ms-1">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-link text-danger p-0" onclick="return confirm('Hapus guru ini dari mapel?')" title="Hapus">
                                                <i class="bi bi-x-circle"></i>
                                            </button>
                                        </form>
                                    </li>
                                    @endforeach
                                </ul>
                            @else
                                <span class="text-muted">Belum ada guru</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <button type="button" class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#assignGuruModal{{ $m->id }}" title="Assign Guru">
                                    <i class="bi bi-person-plus"></i>
                                </button>
                                <a href="{{ route('admin.mapel.edit', $m->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.mapel.destroy', $m->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus mapel ini?')" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    
                    <!-- Modal Assign Guru -->
                    <div class="modal fade" id="assignGuruModal{{ $m->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Assign Guru ke {{ $m->nama_mapel }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ route('admin.mapel.assign-guru', $m->id) }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">Pilih Guru <span class="text-danger">*</span></label>
                                            <select name="guru_id" class="form-select" required>
                                                <option value="">-- Pilih Guru --</option>
                                                @foreach($guru as $g)
                                                <option value="{{ $g->id }}">{{ $g->name }} ({{ $g->nip ?? '-' }})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Pilih Kelas <span class="text-danger">*</span></label>
                                            <select name="kelas_id" class="form-select" required>
                                                <option value="">-- Pilih Kelas --</option>
                                                @foreach($kelas as $k)
                                                <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary">Assign Guru</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @empty
                    <tr><td colspan="5" class="text-center">Tidak ada data</td></tr>
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

