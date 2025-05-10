@extends('layouts.master')

@section('content')
<div class="content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><strong>Detail Data Siswa</strong></h3>
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
                <tr>
                    <th>Kelas</th>
                    <td>{{ $siswa->kelas ? $siswa->kelas->nama_kelas : '-' }}</td>
                </tr>
            </table>

            <div class="d-flex justify-content-end mt-3">
                <a href="{{ route('siswa.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
</div>
@endsection
