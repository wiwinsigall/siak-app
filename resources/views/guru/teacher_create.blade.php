@extends('layouts.mantis')

@section('content')
<div class="">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="card-title"><strong>Form Data Guru</strong></h2>
            <a href="{{ route('guru.index') }}">Kembali</a>
        </div>

        <div class="card-body">
            <form action="{{ route('guru.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="nip">NIP</label>
                    <input type="text" class="form-control" id="nip" name="nip" required>
                </div>

                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="ttl">Tempat, Tanggal Lahir</label>
                    <input type="text" class="form-control" id="ttl" name="ttl" placeholder="Contoh: Pekanbaru, 12 Januari 1980" required>
                </div>

                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <textarea class="form-control" id="alamat" name="alamat" rows="2" required></textarea>
                </div>

                <div class="form-group">
                    <label for="jenis_kelamin">Jenis Kelamin</label>
                    <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                        <option value="">-- Pilih --</option>
                        <option value="L">L</option>
                        <option value="P">P</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="jabatan">Jabatan</label>
                    <select class="form-control" id="jabatan" name="jabatan" required>
                        <option value="">-- Pilih --</option>
                        <option value="Guru">Guru</option>
                        <option value="Kepala Sekolah">Kepala Sekolah</option>
                        <option value="Staff">Staff</option>
                        <option value="Wali Kelas">Wali Kelas</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="golongan">Golongan</label>
                    <input type="text" class="form-control" id="no_hp" name="no_hp" required>
                </div>

                <div class="form-group mt-4 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
