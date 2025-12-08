@extends('layouts.app')

@section('title', 'Edit Mapel - Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold text-primary-custom"><i class="bi bi-book"></i> Edit Mata Pelajaran</h2>
    <a href="{{ route('admin.mapel.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.mapel.update', $mapel->id) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label">Kode Mapel <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('kode_mapel') is-invalid @enderror" name="kode_mapel" value="{{ old('kode_mapel', $mapel->kode_mapel) }}" required>
                @error('kode_mapel')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Nama Mapel <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('nama_mapel') is-invalid @enderror" name="nama_mapel" value="{{ old('nama_mapel', $mapel->nama_mapel) }}" required>
                @error('nama_mapel')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Update</button>
        </form>
    </div>
</div>
@endsection

