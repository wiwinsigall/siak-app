@extends('layouts.mantis')

@section('content')
<div class="">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="card-title"><strong>Detail Presensi</strong></h2>
            <a href="{{ url()->previous() }}" class="btn text-primary">
                <i class="nc-icon nc-minimal-left"></i> Kembali
            </a>
        </div>
    <div class="card-body">
        <div class="mb-4">
            <p><strong>Mata Pelajaran:</strong> {{ $mapel }}</p>
            <p><strong>Guru Pengampu:</strong> {{ $guru }}</p>
        </div>

        @if($absensi->isEmpty())
            <div class="alert alert-info">Belum ada data presensi untuk mata pelajaran ini.</div>
        @else
            <div class="table-responsive">
                <table class="table table-bordered text-center">
                    <thead class="table-light">
                        <tr>
                            <th>No.</th>
                            <th>Tanggal</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($absensi as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}</td>
                            <td>
                                <span class="badge 
                                    @if($item->keterangan == 'Hadir') bg-success 
                                    @elseif($item->keterangan == 'Sakit') bg-warning 
                                    @elseif($item->keterangan == 'Izin') bg-info 
                                    @else bg-danger 
                                    @endif">
                                    {{ $item->keterangan }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
