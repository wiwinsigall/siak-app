@extends('layouts.master')

@section('content')
<div class="content">
    <h3><strong>Daftar Kelas</strong></h3>
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Kelas</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($kelas as $k)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $k->nama_kelas }}</td>
                <td>
                    <a href="{{ route('absensi.rekapAbsensi', $k->id_kelas) }}" 
                    class="btn btn-outline-primary btn-sm mr-2 text-small text-primary">Lihat Absensi</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
