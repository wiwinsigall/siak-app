@extends('layouts.mantis')

@section('content')
<div>
    <div class="card">
        <!-- Header -->
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="card-title"><strong>Detail Absensi {{ $kelas->nama_kelas }}</strong></h2>
            <a href="{{ url()->previous() }}" class="btn text-primary">
                <i class="nc-icon nc-minimal-left"></i> Kembali
            </a>
        </div>

        <!-- Informasi Umum -->
        <div class="card-body p-3">
            <table class="table table-bordered">
                <tr>
                    <th>Tanggal</th>
                    <td>{{ $dataAbsensi->tanggal ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Kelas</th>
                    <td>{{ $dataAbsensi->registrasi_kelas->kelas->kelas ?? '-' }} {{ $dataAbsensi->registrasi_kelas->kelas->jurusan ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Mata Pelajaran</th>
                    <td>{{ $dataAbsensi->mata_pelajaran->nama_mapel ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Guru Mata Pelajaran</th>
                    <td>{{ $dataAbsensi->mata_pelajaran->guru->nama ?? '-' }}</td>
                </tr>
            </table>
        </div>

        <!-- Tabel Absensi -->
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="table">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">NIS</th>
                            <th class="text-center">Nama Siswa</th>
                            <th class="text-center">Keterangan</th>
                            @if (in_array(auth()->user()->role, ['guru', 'wali_kelas']))
                                <th class="text-center">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($absensi as $a)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">{{ $a->registrasi_kelas->siswa->nis ?? '-' }}</td>
                            <td class="text-center">{{ $a->registrasi_kelas->siswa->nama ?? '-' }}</td>
                            <td class="text-center">{{ $a->keterangan }}</td>
                            @if (in_array(auth()->user()->role, ['guru', 'wali_kelas']))
                                <td class="text-center">
                                    <!-- Tombol Edit -->
                                    <a href="{{ route('absensi.edit', $a->id_absensi) }}" class="text-blue-500 mr-2">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
    </div>
</div>
@endsection
