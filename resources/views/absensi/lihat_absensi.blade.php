@extends('layouts.master')

@section('content')
<div class="content">
    <h3><strong>Daftar Absensi {{ $kelas->nama_kelas }}</strong></h3>

        <form method="GET" class="mb-3">
            <div class="row">
                <div class="col-md-3">
                    <input type="text" name="q" class="form-control" placeholder="Cari nama siswa atau mata pelajaran" value="{{ request('q') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-outline-primary btn-sm text-small text-primary">Cari</button>
                </div>
            </div>
        </form>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table tablesorter">
                    <thead class="text-primary text-center">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Nama Siswa</th>
                            <th>Mata Pelajaran</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($absensi as $a)
                        <tr class="text-center">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $a->tanggal }}</td>
                            <td>{{ $a->siswa->nama ?? '-' }}</td>
                            <td>{{ $a->mata_pelajaran->nama_mapel ?? '-' }}</td>
                            <td>{{ $a->keterangan }}</td>
                            <td>
                                    <a href="#" class="text-white">
                                        <i class="fas fa-info-circle"></i>
                                    </a>
                                    <a href="#" class="text-info">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="#" method="POST" style="display:inline-block;" onsubmit="return confirm('Anda yakin menghapus data ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn p-0 border-0 bg-transparent text-danger">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
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
