@extends('layouts.master')

@section('content')
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><strong>Tambah Absensi Siswa Kelas {{ $kelas->nama_kelas }}</strong></h3>
                </div>
                <div class="card-body">

                    {{-- Validasi Form --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Flash Message untuk error khusus (seperti duplikat absensi) --}}
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    {{-- Form Absensi --}}
                    <form action="{{ route('absensi.simpan') }}" method="POST">
                        @csrf
                        <div class="row">
                            {{-- Tanggal --}}
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="tanggal">Tanggal</label>
                                    <input type="date" class="form-control" id="tanggal" name="tanggal" required
                                    style="background-color: #1e1e2f; color: white;">
                                    @if ($errors->has('tanggal'))
                                        <div class="text-danger">{{ $errors->first('tanggal') }}</div>
                                    @endif
                                </div>
                            </div>

                            {{-- Kelas --}}
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="kelas">Kelas</label>
                                    <select class="form-control" id="id_kelas" name="id_kelas" required
                                    style="background-color: #1e1e2f; color: white;">
                                        <option value="{{ $kelas->id_kelas }}">{{ $kelas->nama_kelas }}</option>
                                    </select>
                                </div>
                            </div>

                            {{-- Mata Pelajaran --}}
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="mapel">Mata Pelajaran</label>
                                    <select class="form-control" id="id_mapel" name="id_mapel" required
                                    style="background-color: #1e1e2f; color: white;">
                                        <option value="">Pilih Mata Pelajaran</option>
                                        @foreach ($mata_pelajaran as $m)
                                            <option value="{{ $m->id_mapel }}">{{ $m->nama_mapel }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div> {{-- End Row Input --}}

                        {{-- Tabel Daftar Siswa --}}
                        <div class="table-responsive mt-4">
                            <table class="table tablesorter">
                                <thead class="text-primary">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Siswa</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody id="siswa-list">
                                    @foreach ($siswa as $s)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $s->nama }}</td>
                                        <td>
                                            <select class="form-control" name="absensi[{{ $s->nis }}]"
                                            style="background-color: #1e1e2f; color: white;">
                                                <option value="Hadir">Hadir</option>
                                                <option value="Sakit">Sakit</option>
                                                <option value="Izin">Izin</option>
                                                <option value="Alpa">Alpa</option>
                                            </select>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- Tombol --}}
                        <div class="text-right mt-3">
                            <a href="{{ route('absensi.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

{{-- SweetAlert CDN jika belum ada --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@endsection
