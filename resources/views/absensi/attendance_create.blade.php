@extends('layouts.mantis')

@section('content')
<div class="">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="card-title"><strong>Input Absensi Siswa Kelas</strong></h2>
            <a href="{{ url()->previous() }}" class="btn text-primary">
                <i class="nc-icon nc-minimal-left"></i> Kembali
            </a>
        </div>

        <div class="card-body">
            {{-- Form Absensi --}}
            <form action="{{ route('absensi.store') }}" method="POST">
                @csrf
                <input type="hidden" name="id_kelas" value="{{ $kelas->id_kelas }}">

                <div class="form-group col-md-4">
                    <label for="tanggal">Tanggal</label>
                    <input type="date" class="form-control" id="tanggal" name="tanggal" required value="{{ old('tanggal') }}">
                    @if ($errors->has('tanggal'))
                    <div class="text-danger">{{ $errors->first('tanggal') }}</div>
                    @endif
                </div>

                <div class="form-group col-md-4">
                    <label for="id_mapel">Mata Pelajaran</label>
                    <select class="form-control" id="id_mapel" name="id_mapel" required>
                        <option value="">Pilih Mata Pelajaran</option>
                        @foreach ($mata_pelajaran as $m)
                        <option value="{{ $m->id_mapel }}">
                            {{ $m->nama_mapel }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered text-center">
                        <thead class="text-primary">
                            <tr>
                                <th>No</th>
                                <th>NIS</th>
                                <th>Nama Siswa</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody id="siswa-list">
                            @foreach ($siswa as $s)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $s->siswa->nis }}</td>
                                <td>{{ $s->siswa->nama }}</td>
                                <td>
                                    <select class="form-control" name="absensi[{{ $s->nis }}]">
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

                <div class="form-group mt-4 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- SweetAlert CDN jika belum ada --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
