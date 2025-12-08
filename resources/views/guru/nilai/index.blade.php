@extends('layouts.app')

@section('title', 'Input Nilai - Guru')

@section('content')
<h2 class="fw-bold text-primary-custom mb-4" style="padding-top: 10px;"><i class="bi bi-pencil-square"></i> Input Nilai</h2>

<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('guru.nilai.index') }}">
            <div class="row">
                <div class="col-12 col-md-6">
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

@if(request('mapel_id') && $siswa->count() > 0)
<div class="card">
    <div class="card-body">
        <form action="{{ route('guru.nilai.store') }}" method="POST" id="formNilai">
            @csrf
            <input type="hidden" name="mapel_id" value="{{ request('mapel_id') }}">
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
                            <th>Deskripsi Kompetensi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($siswa as $index => $s)
                        @php
                            $nilai = $s->nilai->first() ?? null;
                        @endphp
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $s->nama_siswa }}</td>
                            <td>
                                <input type="number" 
                                       class="form-control form-control-sm nilai-input" 
                                       name="nilai[{{ $s->id }}][uh]" 
                                       value="{{ $nilai ? $nilai->nilai_uh : '' }}"
                                       min="0" max="100" step="0.01"
                                       data-siswa-id="{{ $s->id }}">
                            </td>
                            <td>
                                <input type="number" 
                                       class="form-control form-control-sm nilai-input" 
                                       name="nilai[{{ $s->id }}][pts]" 
                                       value="{{ $nilai ? $nilai->nilai_pts : '' }}"
                                       min="0" max="100" step="0.01"
                                       data-siswa-id="{{ $s->id }}">
                            </td>
                            <td>
                                <input type="number" 
                                       class="form-control form-control-sm nilai-input" 
                                       name="nilai[{{ $s->id }}][pas]" 
                                       value="{{ $nilai ? $nilai->nilai_pas : '' }}"
                                       min="0" max="100" step="0.01"
                                       data-siswa-id="{{ $s->id }}">
                            </td>
                            <td>
                                <span class="rata-rata-{{ $s->id }}">{{ $nilai && $nilai->rata_rata ? number_format($nilai->rata_rata, 2) : '-' }}</span>
                            </td>
                            <td style="min-width: 200px;">
                                <textarea 
                                    class="form-control form-control-sm" 
                                    name="nilai[{{ $s->id }}][deskripsi]" 
                                    rows="2" 
                                    style="font-size: 0.875rem; resize: vertical;"
                                    placeholder="Contoh: Siswa sudah memahami konsep dasar dengan baik">{{ $nilai ? $nilai->deskripsi_kompetensi : '' }}</textarea>
                            </td>
                            <input type="hidden" name="siswa_id[]" value="{{ $s->id }}">
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary" onclick="return confirm('Simpan semua nilai?')">
                    <i class="bi bi-save"></i> Simpan Semua Nilai
                </button>
            </div>
        </form>
    </div>
</div>
@endif

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Calculate rata-rata on input change
    document.querySelectorAll('.nilai-input').forEach(input => {
        input.addEventListener('input', function() {
            const siswaId = this.getAttribute('data-siswa-id');
            const row = this.closest('tr');
            const uh = parseFloat(row.querySelector('input[name*="[uh]"]').value) || 0;
            const pts = parseFloat(row.querySelector('input[name*="[pts]"]').value) || 0;
            const pas = parseFloat(row.querySelector('input[name*="[pas]"]').value) || 0;
            
            const nilaiArray = [uh, pts, pas].filter(v => v > 0);
            const rataRata = nilaiArray.length > 0 ? (nilaiArray.reduce((a, b) => a + b, 0) / nilaiArray.length) : 0;
            
            const rataRataSpan = row.querySelector('.rata-rata-' + siswaId);
            if (rataRataSpan) {
                rataRataSpan.textContent = rataRata > 0 ? rataRata.toFixed(2) : '-';
            }
        });
    });
});
</script>
@endpush
@endsection

