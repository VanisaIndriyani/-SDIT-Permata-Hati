@extends('layouts.app')

@section('title', 'Tambah Kelas - Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold text-primary-custom"><i class="bi bi-building"></i> Tambah Kelas</h2>
    <a href="{{ route('admin.kelas.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.kelas.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Nama Kelas <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('nama_kelas') is-invalid @enderror" name="nama_kelas" value="{{ old('nama_kelas') }}" required>
                @error('nama_kelas')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Wali Kelas</label>
                <select class="form-select" name="wali_kelas_id">
                    <option value="">Pilih Wali Kelas</option>
                    @foreach($waliKelas as $wk)
                    <option value="{{ $wk->id }}" {{ old('wali_kelas_id') == $wk->id ? 'selected' : '' }}>{{ $wk->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Jumlah Siswa</label>
                <input type="number" class="form-control" name="jumlah_siswa" value="{{ old('jumlah_siswa', 0) }}" min="0">
            </div>
            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Simpan</button>
        </form>
    </div>
</div>
@endsection

