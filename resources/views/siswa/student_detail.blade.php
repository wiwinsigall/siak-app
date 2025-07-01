@extends('layouts.mantis')

@section('content')
<div>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="card-title"><strong>Detail Data Siswa</strong></h2>
            <a href="{{ route('siswa.index') }}">Kembali</a>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>NIS</th>
                    <td>{{ $siswa->nis }}</td>
                </tr>
                <tr>
                    <th>Nama</th>
                    <td>{{ $siswa->nama }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $siswa->email ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Tempat Tanggal Lahir</th>
                    <td>{{ $siswa->ttl ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Alamat</th>
                    <td>{{ $siswa->alamat ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Jenis Kelamin</th>
                    <td>{{ $siswa->jenis_kelamin }}</td>
                </tr>
                <tr>
                    <th>Jurusan</th>
                    <td>{{ $siswa->jurusan ?? '-' }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>
@endsection
