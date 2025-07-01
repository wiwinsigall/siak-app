@extends('layouts.mantis')

@section('content')
<div>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="card-title"><strong>Detail Data Guru</strong></h2>
            <a href="{{ route('guru.index') }}">Kembali</a>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>NIP</th>
                    <td>{{ $guru->nip }}</td>
                </tr>
                <tr>
                    <th>Nama</th>
                    <td>{{ $guru->nama }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $guru->email ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Tempat Tanggal Lahir</th>
                    <td>{{ $guru->ttl ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Alamat</th>
                    <td>{{ $guru->alamat ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Jenis Kelamin</th>
                    <td>{{ $guru->jenis_kelamin }}</td>
                </tr>
                <tr>
                    <th>Jabatan</th>
                    <td>{{ $guru->jabatan ?? '-' }}</td>
                </tr>
                <tr>
                    <th>No HP</th>
                    <td>{{ $guru->no_hp ?? '-' }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>
@endsection
