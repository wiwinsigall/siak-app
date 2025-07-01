@extends('layouts.mantis')

@section('content')
<div class="">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="card-title"><strong>Cetak Rapor Siswa</strong></h2>
        </div>

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="card-body">
            {{-- Form Filter --}}
            <form method="GET" action="{{ route('rapor.index') }}" id="filterForm">
                <div class="row">
                    {{-- Tahun Ajaran --}}
                    <div class="form-group col-md-4">
                        <label for="id_tahun_ajaran">Tahun Ajaran</label>
                        <select class="form-control" id="id_tahun_ajaran" name="id_tahun_ajaran" required>
                            <option value="">Pilih Tahun Ajaran</option>
                            @foreach ($tahun_ajaran as $id => $label)
                                <option value="{{ $id }}" {{ $selectedTahunAjaran == $id ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Kelas --}}
                    <div class="form-group col-md-4">
                        <label for="id_kelas">Kelas</label>
                        <select class="form-control" id="id_kelas" name="id_kelas" required>
                            <option value="">Pilih Kelas</option>
                            @foreach ($allKelas as $kls)
                                <option value="{{ $kls->id_kelas }}" {{ $selectedKelas == $kls->id_kelas ? 'selected' : '' }}>
                                    {{ $kls->kelas }} {{ $kls->jurusan }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Tombol Submit --}}
                    <div class="form-group col-md-4 align-self-end">
                        <button type="submit" class="btn btn-primary">Tampilkan Siswa</button>
                    </div>
                </div>
            </form>

            {{-- Tabel Siswa --}}
            @if ($selectedTahunAjaran && $selectedKelas)
                @if (count($siswa))
                    <div class="table-responsive mt-4">
                        <table class="table table-bordered text-center">
                            <thead class="text-primary">
                                <tr>
                                    <th>No</th>
                                    <th>NIS</th>
                                    <th>Nama</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($siswa as $s)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $s->nis }}</td>
                                    <td>{{ $s->nama }}</td>
                                    <td>
                                        <a href="{{ route('rapor.cetak', ['nis' => $s->nis, 'id_tahun_ajaran' => $selectedTahunAjaran]) }}"
                                            class="text-red-500" title="Cetak PDF"><i class="fas fa-print"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-warning mt-4">
                        Tidak ada siswa yang terdaftar di kelas dan tahun ajaran tersebut.
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>
@endsection
