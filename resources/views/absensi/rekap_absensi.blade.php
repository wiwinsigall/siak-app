@extends('layouts.master')

@section('content')
<div class="content">
    <h3><strong>Absensi Kelas {{ $kelas->nama_kelas }}</strong></h3>

    <form method="GET" class="mb-3">
        <div class="row">
            <div class="col-md-4">
                <input type="date" name="tanggal" value="{{ $tanggal }}" class="form-control">
            </div>
            <div class="d-flex justify-content-start">
                <button type="submit" class="btn btn-outline-primary btn-sm text-small text-primary">Filter Tanggal</button>
            </div>
            <div class="col-md-2">
                <a href="{{ route('absensi.tambah', $kelas->id_kelas) }}" class="btn btn-outline-primary btn-sm text-small text-primary">Tambah Absensi</a>
            </div>
        </div>
    </form>

    <table class="table text-center">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Jumlah Hadir</th>
                <th>Jumlah Sakit</th>
                <th>Jumlah Izin</th>
                <th>Jumlah Alpa</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rekap as $index => $row)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $row->tanggal }}</td>
                <td>{{ $row->jumlah_hadir }}</td>
                <td>{{ $row->jumlah_sakit }}</td>
                <td>{{ $row->jumlah_izin }}</td>
                <td>{{ $row->jumlah_alpa }}</td>
                <td>
                    <a href="{{ route('absensi.lihatAbsensiTanggal', ['id_kelas' => $kelas->id_kelas, 'tanggal' => $row->tanggal]) }}" class="text-info">
                                        <i class="fas fa-edit"></i>
                                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
