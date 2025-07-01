@extends('layouts.mantis')

@section('content')
<div class="">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="card-title"><strong>Edit Absensi Siswa Kelas {{ $kelas->nama_kelas }}</strong></h2>
            <a href="{{ url()->previous() }}" class="btn text-primary">
                <i class="nc-icon nc-minimal-left"></i> Kembali
            </a>
        </div>

        <div class="card-body">
            {{-- Form Edit Absensi --}}
            <form action="{{ route('absensi.update', $absensi->id_absensi) }}" method="POST">
                @csrf
                @method('PUT')

                <input type="hidden" name="id_kelas" value="{{ $kelas->id_kelas }}">

                {{-- Informasi Umum --}}
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label>Tanggal</label>
                        <input type="text" class="form-control" value="{{ $tanggal }}" readonly>
                    </div>

                    <div class="form-group col-md-4">
                        <label>Kelas</label>
                        <input type="text" class="form-control" value="{{ $kelas->kelas }} {{ $kelas->jurusan }}" readonly>
                    </div>

                    <div class="form-group col-md-4">
                        <label>Mata Pelajaran</label>
                        <input type="text" class="form-control" value="{{ $absensi->mata_pelajaran->nama_mapel ?? '-' }}" readonly>
                    </div>

                    <div class="form-group col-md-4">
                        <label>Guru Mata Pelajaran</label>
                        <input type="text" class="form-control" value="{{ $absensi->mata_pelajaran->guru->nama ?? '-' }}" readonly>
                    </div>
                </div>

                {{-- Tabel Absensi --}}
                <div class="table-responsive mt-4">
                    <table class="table table-bordered">
                        <thead class="thead-dark">
                            <tr class="text-center">
                                <th>No</th>
                                <th>NIS</th>
                                <th>Nama Siswa</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($absensi_list as $a)
                                <tr class="text-center">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $a->registrasi_kelas->siswa->nis ?? '-' }}</td>
                                    <td>{{ $a->registrasi_kelas->siswa->nama ?? '-' }}</td>
                                    <td>
                                        <select class="form-control" name="absensi[{{ $a->id_absensi }}]">
                                            <option value="Hadir" {{ $a->keterangan == 'Hadir' ? 'selected' : '' }}>Hadir</option>
                                            <option value="Sakit" {{ $a->keterangan == 'Sakit' ? 'selected' : '' }}>Sakit</option>
                                            <option value="Izin" {{ $a->keterangan == 'Izin' ? 'selected' : '' }}>Izin</option>
                                            <option value="Alpa" {{ $a->keterangan == 'Alpa' ? 'selected' : '' }}>Alpa</option>
                                        </select>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Tombol --}}
                <div class="form-group mt-4 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Perbarui</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
