@extends('layouts.master')

@section('content')
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><strong>Edit Data Guru</strong></h3>
                </div>
                <div class="card-body">

                    {{-- Tampilkan pesan error jika ada --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('guru.update', $guru->nip) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="nip">NIP</label>
                            <input type="text" class="form-control" id="nip" name="nip" value="{{ $guru->nip }}" required>
                        </div>
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" value="{{ $guru->nama }}" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ $guru->email }}" required>
                        </div>
                        <div class="form-group">
                            <label for="ttl">Tempat, Tanggal Lahir</label>
                            <input type="text" class="form-control" id="ttl" name="ttl" value="{{ $guru->ttl }}" required>
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea class="form-control" id="alamat" name="alamat" rows="2" required>{{ $guru->alamat }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="jenis_kelamin">Jenis Kelamin</label>
                            <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required style="background-color: #1e1e2f; color: white;">
                                <option value="">-- Pilih --</option>
                                <option value="L" {{ $guru->jenis_kelamin == 'L' ? 'selected' : '' }}>L</option>
                                <option value="P" {{ $guru->jenis_kelamin == 'P' ? 'selected' : '' }}>P</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="jabatan">Jabatan</label>
                            <select class="form-control" id="jabatan" name="jabatan" required style="background-color: #1e1e2f; color: white;">
                                <option value="">-- Pilih --</option>
                                <option value="Guru" {{ $guru->jabatan == 'Guru' ? 'selected' : '' }}>Guru</option>
                                <option value="Kepala Sekolah" {{ $guru->jabatan == 'Kepala Sekolah' ? 'selected' : '' }}>Kepala Sekolah</option>
                                <option value="Wali Kelas" {{ $guru->jabatan == 'Wali Kelas' ? 'selected' : '' }}>Wali Kelas</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="golongan">Golongan</label>
                            <select class="form-control" id="golongan" name="golongan" required style="background-color: #1e1e2f; color: white;">
                                <option value="">-- Pilih --</option>
                                @foreach(['III/a', 'III/b', 'III/c', 'III/d', 'IV/a', 'IV/b', 'IV/c', 'IV/d', 'IV/e'] as $gol)
                                    <option value="{{ $gol }}" {{ $guru->golongan == $gol ? 'selected' : '' }}>{{ $gol }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="id_mapel">Mata Pelajaran</label>
                            <select class="form-control" id="id_mapel" name="id_mapel" required style="background-color: #1e1e2f; color: white;">
                                <option value="">-- Pilih --</option>
                                @foreach($mata_pelajaran as $m)
                                    <option value="{{ $m->id_mapel }}" {{ $guru->id_mapel == $m->id_mapel ? 'selected' : '' }}>
                                        {{ $m->nama_mapel }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="text-right">
                            <a href="{{ route('guru.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">Perbarui</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
