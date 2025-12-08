@extends('layouts.app')

@section('title', 'Rekap Nilai - Wali Kelas')

@section('content')
<h2 class="fw-bold text-primary-custom mb-4" style="padding-top: 10px;"><i class="bi bi-table"></i> Rekap Nilai</h2>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Siswa</th>
                        <th>Mapel</th>
                        <th>UH</th>
                        <th>PTS</th>
                        <th>PAS</th>
                        <th>Rata-rata</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($siswa as $index => $s)
                        @if($s->nilai->count() > 0)
                            @foreach($s->nilai as $nilai)
                            <tr>
                                @if($loop->first)
                                <td rowspan="{{ $s->nilai->count() }}">{{ $index + 1 }}</td>
                                <td rowspan="{{ $s->nilai->count() }}">{{ $s->nama_siswa }}</td>
                                @endif
                                <td>{{ $nilai->mapel->nama_mapel }}</td>
                                <td>{{ $nilai->nilai_uh ?? '-' }}</td>
                                <td>{{ $nilai->nilai_pts ?? '-' }}</td>
                                <td>{{ $nilai->nilai_pas ?? '-' }}</td>
                                <td><strong>{{ $nilai->rata_rata ?? '-' }}</strong></td>
                            </tr>
                            @endforeach
                        @else
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $s->nama_siswa }}</td>
                            <td colspan="5" class="text-center text-muted">Belum ada nilai</td>
                        </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

