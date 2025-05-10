@extends('layouts.master')

@section('content')
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><strong>Ubah Data Siswa</strong></h3>
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
                            <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required style="background-color: #1e1e2f; color: white;">
                                <option value="">-- Pilih --</option>
                                <option value="P" {{ $siswa->jenis_kelamin == 'P' ? 'selected' : '' }}>P</option>
                                <option value="L" {{ $siswa->jenis_kelamin == 'L' ? 'selected' : '' }}>L</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="jurusan">Jurusan</label>
                            <select class="form-control" id="jurusan" name="jurusan" required style="background-color: #1e1e2f; color: white;">
                                <option value="">-- Pilih --</option>
                                @foreach (['AKL','DPIB','Geospasial','MPLB','PPLG','TAV','Teknik Kendaraan Ringan','Teknik Las','Teknik Mesin','Teknik Sepeda Motor','TKJT'] as $jrs)
                                    <option value="{{ $jrs }}" {{ $siswa->jurusan == $jrs ? 'selected' : '' }}>{{ $jrs }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="id_kelas">Kelas</label>
                            <select class="form-control" id="id_kelas" name="id_kelas" required style="background-color: #1e1e2f; color: white;">
                                <option value="">-- Pilih --</option>
                                @foreach($kelas as $k)
                                    <option value="{{ $k->id_kelas }}" {{ $siswa->id_kelas == $k->id_kelas ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="text-right">
                            <a href="{{ route('siswa.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
