@extends('layouts.mantis')

@section('content')
<div class="">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="card-title"><strong>Edit Data Siswa</strong></h2>
            <a href="{{ route('siswa.index') }}">Kembali</a>
        </div>

        <div class="card-body">
            <form action="{{ route('siswa.update', $siswa->nis) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="nis">NIS</label>
                    <input type="text" class="form-control" id="nis" name="nis" value="{{ $siswa->nis }}" required>
                </div>

                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="{{ $siswa->nama }}" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ $siswa->email }}" required>
                </div>

                <div class="form-group">
                    <label for="ttl">Tempat, Tanggal Lahir</label>
                    <input type="text" class="form-control" id="ttl" name="ttl" value="{{ $siswa->ttl }}" required>
                </div>

                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <textarea class="form-control" id="alamat" name="alamat" rows="2" required>{{ $siswa->alamat }}</textarea>
                </div>

                <div class="form-group">
                    <label for="jenis_kelamin">Jenis Kelamin</label>
                    <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                        <option value="">-- Pilih --</option>
                        <option value="P" {{ $siswa->jenis_kelamin == 'P' ? 'selected' : '' }}>P</option>
                        <option value="L" {{ $siswa->jenis_kelamin == 'L' ? 'selected' : '' }}>L</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="jurusan">Jurusan</label>
                    <select class="form-control" id="jurusan" name="jurusan" required>
                        <option value="">-- Pilih --</option>
                        @foreach (['AKL','DPIB','Geospasial','MPLB','PPLG','TAV','Teknik Kendaraan Ringan','Teknik Las','Teknik Mesin','Teknik Sepeda Motor','TKJT'] as $jrs)
                            <option value="{{ $jrs }}" {{ $siswa->jurusan == $jrs ? 'selected' : '' }}>{{ $jrs }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group mt-4 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Perbarui</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
