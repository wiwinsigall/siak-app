@extends('layouts.mantis')

@section('content')
<div class="">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="card-title"><strong>Edit Data Guru</strong></h2>
            <a href="{{ route('guru.index') }}">Kembali</a>
        </div>

        <div class="card-body">
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
                    <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                        <option value="">-- Pilih --</option>
                        <option value="L" {{ $guru->jenis_kelamin == 'L' ? 'selected' : '' }}>L</option>
                        <option value="P" {{ $guru->jenis_kelamin == 'P' ? 'selected' : '' }}>P</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="jabatan">Jabatan</label>
                    <select class="form-control" id="jabatan" name="jabatan" required>
                        <option value="">-- Pilih --</option>
                        <option value="Guru" {{ $guru->jabatan == 'Guru' ? 'selected' : '' }}>Guru</option>
                        <option value="Kepala Sekolah" {{ $guru->jabatan == 'Kepala Sekolah' ? 'selected' : '' }}>Kepala Sekolah</option>
                        <option value="Staff" {{ $guru->jabatan == 'Staff' ? 'selected' : '' }}>Staff</option>
                        <option value="Wali Kelas" {{ $guru->jabatan == 'Wali Kelas' ? 'selected' : '' }}>Wali Kelas</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="no_hp">No HP</label>
                    <input type="text" class="form-control" id="no_hp" name="no_hp" value="{{ $guru->no_hp }}" required>
                </div>

                <div class="form-group mt-4 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Perbarui</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
