@extends('layouts.mantis')

@section('content')
<div class="">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="card-title"><strong>Registrasi Siswa Baru ke Kelas</strong></h2>
            <a href="{{ route('kelas.index') }}" class="btn text-primary">Kembali</a>
        </div>

        <div class="card-body">
            @if ($tahun_ajaran)
                {{-- Alert Tahun Ajaran Aktif --}}
                <div class="alert alert-primary d-flex align-items-center justify-content-between mb-4 p-3 rounded shadow-sm">
                    <h5 class="mb-0">
                        <i class="bi bi-calendar3 me-2"></i>
                        📘 Tahun Ajaran Aktif:
                        <strong>{{ $tahun_ajaran->tahun_ajaran }} ({{ ucfirst($tahun_ajaran->semester) }})</strong>
                    </h5>
                </div>

                {{-- Form filter jurusan --}}
                <form action="{{ route('registrasi_kelas.create') }}" method="GET" class="mb-4">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="jurusan" class="form-label">Filter Jurusan</label>
                            <select name="jurusan" id="jurusan" class="form-control" onchange="this.form.submit()">
                                <option value="">-- Pilih Jurusan --</option>
                                @foreach ($daftar_jurusan as $j)
                                    <option value="{{ $j }}" {{ request('jurusan') == $j ? 'selected' : '' }}>{{ $j }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </form>

                {{-- Form utama registrasi --}}
                <form action="{{ route('registrasi_kelas.store') }}" method="POST">
                    @csrf

                    <div class="col mb-4">
                        <label for="id_kelas" class="form-label">Pilih Kelas</label>
                        <select name="id_kelas" id="id_kelas" class="form-control" required>
                            <option value="">-- Pilih Kelas --</option>
                            @foreach ($kelas as $k)
                                <option value="{{ $k->id_kelas }}">{{ $k->kelas }} {{ $k->jurusan }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col mb-4">
                        <label for="wali_kelas_id" class="form-label">Pilih Wali Kelas</label>
                        <select name="wali_kelas_id" id="wali_kelas_id" class="form-control" required>
                            <option value="">-- Pilih Wali Kelas --</option>
                            @foreach ($wali_kelas as $wali)
                                <option value="{{ $wali->nip }}">{{ $wali->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <table class="table table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th>No</th>
                                <th>Nama Siswa</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($siswa as $s)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>
                                        {{ $s->nama }}
                                        <input type="hidden" name="nis[]" value="{{ $s->nis }}">
                                    </td>
                                    <td>
                                        <select name="status[{{ $s->nis }}]" class="form-control" required>
                                            <option value="aktif">Aktif</option>
                                            <option value="nonaktif">Nonaktif</option>
                                        </select>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">Tidak ada siswa ditemukan untuk jurusan ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="form-group mt-4 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            @else
                <div class="alert alert-danger">Tidak ada tahun ajaran yang aktif. Silakan atur tahun ajaran terlebih dahulu.</div>
            @endif
        </div>
    </div>
</div>
@endsection
