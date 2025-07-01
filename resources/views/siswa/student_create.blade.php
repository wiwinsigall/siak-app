@extends('layouts.mantis')

@section('content')
<div class="">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="card-title"><strong>Form Data Siswa</strong></h2>
            <a href="{{ route('siswa.index') }}">Kembali</a>
        </div>

        <div class="card-body">
            <form action="{{ route('siswa.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="nis">NIS</label>
                    <input type="text" class="form-control" id="nis" name="nis" required>
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
                    <input type="text" class="form-control" id="ttl" name="ttl" placeholder="Contoh: Pekanbaru, 12 Januari 2005" required>
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
                    <label for="jurusan">Jurusan</label>
                    <select class="form-control" id="jurusan" name="jurusan" required>
                        <option value="">-- Pilih --</option>
                        <option value="AKL">AKL</option>
                        <option value="DPIB">DPIB</option>
                        <option value="Geospasial">Geospasial</option>
                        <option value="MPLB">MPLB</option>
                        <option value="PPLG">PPLG</option>
                        <option value="TAV">TAV</option>
                        <option value="Teknik Kendaraan Ringan">Teknik Kendaraan Ringan</option>
                        <option value="Teknik Las">Teknik Las</option>
                        <option value="Teknik Mesin">Teknik Mesin</option>
                        <option value="Teknik Sepeda Motor">Teknik Sepeda Motor</option>
                        <option value="TKJT">TKJT</option>
                    </select>
                </div>

                <div class="form-group mt-4 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
