@extends('layouts.mantis')

@section('content')
<div>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="card-title"><strong>Detail Kelas</strong></h2>
            <a href="{{ route('kelas.index') }}" class="btn text-primary">Kembali</a>
        </div>

        <div class="card-body">
            {{-- Informasi Kelas --}}
            <table class="table table-sm table-bordered w-50 mb-4">
                <tr>
                    <th>Nama Kelas</th>
                    <td>{{ $kelas->nama_kelas }}</td>
                </tr>
                <tr>
                    <th>Tahun Ajaran</th>
                    <td>{{ $kelas->tahun_ajaran ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Semester</th>
                    <td>{{ ucfirst($kelas->semester) ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Wali Kelas</th>
                    <td>{{ $kelas->wali_kelas ?? '-' }}</td>
                </tr>
            </table>

            {{-- Daftar Siswa --}}
            <h5 class="mb-3"><strong>Daftar Siswa</strong></h5>
            @if($siswa->isEmpty())
                <p>Tidak ada siswa di kelas ini.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered" id="tableSiswa">
                        <thead>
                            <tr class="text-center">
                                <th>No</th>
                                <th>NIS</th>
                                <th>Nama Siswa</th>
                                <th>Jenis Kelamin</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($siswa as $index => $item)
                                <tr class="text-center">
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->nis }}</td>
                                    <td>{{ $item->nama }}</td>
                                    <td>{{ ucfirst($item->jenis_kelamin) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
