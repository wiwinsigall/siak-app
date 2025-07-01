@extends('layouts.mantis')

@section('content')
<div>
    <div class="card">
        <!-- Header -->
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="card-title"><strong>Daftar Absensi per Mata Pelajaran</strong></h2>
            <a href="{{ url()->previous() }}" class="btn text-primary">
                <i class="nc-icon nc-minimal-left"></i> Kembali
            </a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="table">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Mata Pelajaran</th>
                            <th class="text-center">Nama Guru</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($mapel as $m)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center">{{ $m->nama_mapel ?? '-' }}</td>
                                <td class="text-center">{{ $m->guru->nama ?? '-' }}</td>
                                <td class="text-center">
                                    <a href="{{ route('absensi.attendanceRecap', [$m->id_kelas, $m->id_mapel]) }}" class="text-blue-500" title="Rekap Absensi">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
