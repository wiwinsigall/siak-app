@extends('layouts.mantis')

@section('content')
<div class="card">
    {{-- Alert Sukses/Error --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card-header d-flex justify-content-between align-items-center">
        <h2 class="card-title"><strong>Form Kenaikan Kelas</strong></h2>
        <a href="{{ route('kelas.index') }}" class="btn btn-link text-primary">Kembali</a>
    </div>

    <div class="card-body">
        {{-- Filter Form --}}
        <form method="GET" id="filterForm">
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Tahun Ajaran Lama</label>
                <div class="col-sm-3">
                    <select name="tahun_ajaran_lama" class="form-control" required onchange="this.form.submit()">
                        <option value="">-- Pilih Tahun Lama --</option>
                        @foreach($tahun_ajaran as $id => $label)
                            <option value="{{ $id }}" {{ request('tahun_ajaran_lama') == $id ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-sm-3 text-center mt-2">
                    <strong>Tahun Ajaran Baru</strong>
                </div>

                <div class="col-sm-3">
                    <select name="tahun_ajaran_baru" class="form-control" required onchange="this.form.submit()">
                        <option value="">-- Pilih Tahun Baru --</option>
                        @foreach($tahun_ajaran as $id => $label)
                            <option value="{{ $id }}" {{ request('tahun_ajaran_baru') == $id ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row mt-3">
                <label class="col-sm-2 col-form-label">Kelas Lama</label>
                <div class="col-sm-3">
                    <select name="kelas_asal" class="form-control" required onchange="this.form.submit()">
                        <option value="">-- Pilih Kelas Lama --</option>
                        @foreach($allKelas as $kls)
                            <option value="{{ $kls->id_kelas }}" {{ request('kelas_asal') == $kls->id_kelas ? 'selected' : '' }}>
                                {{ $kls->kelas }} {{ $kls->jurusan ?? '-' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-sm-3 text-center mt-2">
                    <strong>Kelas Tujuan</strong>
                </div>

                <div class="col-sm-3">
                    <select name="kelas_tujuan" class="form-control" required onchange="this.form.submit()">
                        <option value="">-- Pilih Kelas Tujuan --</option>
                        @foreach($allKelas as $kls)
                            <option value="{{ $kls->id_kelas }}" {{ request('kelas_tujuan') == $kls->id_kelas ? 'selected' : '' }}>
                                {{ $kls->kelas }} {{ $kls->jurusan ?? '-' }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </form>

        {{-- Form Proses Kenaikan --}}
        @if($selectedKelas && $kelasTujuan && count($siswa))
            <form action="{{ route('kelas.promotion_process') }}" method="POST">
                @csrf
                <input type="hidden" name="from_class_id" value="{{ $selectedKelas }}">
                <input type="hidden" name="to_class_id" value="{{ $kelasTujuan }}">
                <input type="hidden" name="tahun_ajaran_lama" value="{{ request('tahun_ajaran_lama') }}">
                <input type="hidden" name="tahun_ajaran_baru" value="{{ request('tahun_ajaran_baru') }}">

                {{-- Form Pilih Wali Kelas --}}
                <div class="form-group mb-3">
                    <label for="nip_wali_kelas">Pilih Wali Kelas Baru</label>
                    <select name="nip_wali_kelas" id="nip_wali_kelas" class="form-control" required>
                        <option value="">-- Pilih Wali Kelas --</option>
                        @foreach ($waliKelas as $wali)
                            <option value="{{ $wali->nip }}" {{ (old('nip_wali_kelas') == $wali->nip) ? 'selected' : '' }}>
                                {{ $wali->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <table class="table table-bordered mt-4">
                    <thead class="text-center bg-light">
                        <tr>
                            <th>No</th>
                            <th>NIS</th>
                            <th>Nama Siswa</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($siswa as $sis)
                            <tr class="text-center">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $sis->nis }}</td>
                                <td class="text-left">{{ $sis->nama }}</td>
                                <td>
                                    <select name="actions[{{ $sis->nis }}]" class="form-control" required>
                                        <option value="">-- Pilih Aksi --</option>
                                        <option value="naik" selected>Naik</option>
                                        <option value="tinggal">Tinggal</option>
                                        <option value="lulus">Lulus</option>
                                        <option value="pindah">Pindah</option>
                                    </select>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        @elseif(request()->filled(['tahun_ajaran_lama', 'tahun_ajaran_baru', 'kelas_asal', 'kelas_tujuan']))
            <div class="alert alert-warning mt-4">
                Tidak ada data siswa yang ditemukan untuk kelas dan tahun ajaran yang dipilih.
            </div>
        @endif
    </div>
</div>
@endsection
