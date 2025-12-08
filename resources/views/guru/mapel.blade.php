@extends('layouts.app')

@section('title', 'Mata Pelajaran - Guru')

@section('content')
<h2 class="fw-bold text-primary-custom mb-4" style="padding-top: 10px;"><i class="bi bi-book"></i> Mata Pelajaran</h2>

<div class="card">
    <div class="card-body">
        <p class="text-muted">Berikut adalah mata pelajaran yang Anda ampu:</p>
        <div class="row">
            @foreach($mapelGuru as $mapelId => $items)
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $items->first()->mapel->nama_mapel }}</h5>
                        <p class="card-text">
                            <small class="text-muted">
                                Kelas: 
                                @foreach($items as $item)
                                    {{ $item->kelas->nama_kelas }}@if(!$loop->last), @endif
                                @endforeach
                            </small>
                        </p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

