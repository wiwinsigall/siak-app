@extends('layouts.master')

@section('content')
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><strong>Tambah Data Kelas</strong></h3>
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

                    <form action="{{ route('kelas.tambah') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="nama_kelas">Nama Kelas</label>
                            <input type="text" class="form-control" id="nama_kelas" name="nama_kelas" required>
                        </div>
                        <div class="form-group">
                            <label for="semester">Semester</label>
                            <select class="form-control" id="semester" name="semester" required
                                style="background-color: #1e1e2f; color: white;">
                                <option value="">-- Pilih --</option>
                                <option value="Ganjil">Ganjil</option>
                                <option value="Genap">Genap</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tahun_ajaran">Tahun Ajaran</label>
                            <select class="form-control" id="tahun_ajaran" name="tahun_ajaran" required 
                                style="background-color: #1e1e2f; color: white;">
                                <option value="">-- Pilih --</option>
                                @php
                                    $tahun_sekarang = date('Y');
                                    for ($i = -5; $i <= 5; $i++) {
                                        $tahun1 = $tahun_sekarang + $i;
                                        $tahun2 = $tahun1 + 1;
                                        echo "<option value='{$tahun1}/{$tahun2}'>{$tahun1}/{$tahun2}</option>";
                                    }
                                @endphp
                            </select>
                        </div>
                        <div class="text-right">
                            <a href="{{ route('kelas.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
