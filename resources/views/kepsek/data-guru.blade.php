@extends('layouts.app')

@section('title', 'Data Guru - Kepala Sekolah')

@section('content')
<h2 class="fw-bold text-primary-custom mb-4" style="padding-top: 10px;"><i class="bi bi-people"></i> Data Guru</h2>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>NIP</th>
                        <th>Mapel yang Diampu</th>
                        <th>Kelas yang Diajar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($guru as $index => $g)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $g->name }}</td>
                        <td>{{ $g->nip ?? '-' }}</td>
                        <td>
                            @foreach($g->mapelGuru->unique('mapel_id') as $mg)
                                {{ $mg->mapel->nama_mapel }}@if(!$loop->last), @endif
                            @endforeach
                        </td>
                        <td>
                            @foreach($g->mapelGuru->unique('kelas_id') as $mg)
                                {{ $mg->kelas->nama_kelas }}@if(!$loop->last), @endif
                            @endforeach
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

