@extends('layouts.mantis')

@section('content')
<div>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="card-title"><strong>Profile Pengguna</strong></h2>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                {{-- Jika role adalah siswa, tampilkan NIS --}}
                @if ($user->role === 'siswa')
                    <tr>
                        <th>NIS</th>
                        <td>{{ $profile->nis ?? '-' }}</td>
                    </tr>
                @else
                    {{-- Jika role adalah guru, kepsek, atau lainnya, tampilkan NIP --}}
                    <tr>
                        <th>NIP</th>
                        <td>{{ $profile->nip ?? '-' }}</td>
                    </tr>
                @endif

                <tr>
                    <th>Nama</th>
                    <td>{{ $profile->nama ?? $user->nama }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $profile->email ?? $user->email }}</td>
                </tr>
                <tr>
                    <th>Tempat, Tanggal Lahir</th>
                    <td>{{ $profile->ttl ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Alamat</th>
                    <td>{{ $profile->alamat ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Jenis Kelamin</th>
                    <td>{{ ucfirst($profile->jenis_kelamin ?? '-') }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>
@endsection
