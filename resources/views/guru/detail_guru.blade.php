@extends('layouts.master')

@section('content')
<div class="content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><strong>Detail Data Guru</strong></h3>
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
                    <th>Golongan</th>
                    <td>{{ $guru->golongan ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Mata Pelajaran</th>
                    <td>{{ $guru->mata_pelajaran ? $guru->mata_pelajaran->nama_mapel : '-' }}</td>
                </tr>
            </table>

            <div class="d-flex justify-content-end mt-3">
                <a href="{{ route('guru.index') }}" class="btn btn-secondary">Kembali</a>
            </div>

        </div>
    </div>
</div>
@endsection
