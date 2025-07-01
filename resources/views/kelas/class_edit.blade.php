@extends('layouts.mantis')

@section('content')
<div class="">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="card-title"><strong>Form Edit Data Kelas</strong></h2>
            <a href="{{ route('kelas.index') }}">Kembali</a>
        </div>

        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('kelas.update', $kelas->id_kelas) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="kelas">Kelas</label>
                    <select class="form-control" id="kelas" name="kelas" required>
                        <option value="">-- Pilih Kelas --</option>
                        <option value="X" {{ old('kelas', $kelas->kelas) == 'X' ? 'selected' : '' }}>X</option>
                        <option value="XI" {{ old('kelas', $kelas->kelas) == 'XI' ? 'selected' : '' }}>XI</option>
                        <option value="XII" {{ old('kelas', $kelas->kelas) == 'XII' ? 'selected' : '' }}>XII</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="jurusan">Jurusan</label>
                    <select class="form-control" id="jurusan" name="jurusan" required>
                        <option value="">-- Pilih Jurusan --</option>
                        <option value="AKL" {{ old('jurusan', $kelas->jurusan) == 'AKL' ? 'selected' : '' }}>AKL</option>
                        <option value="DPIB" {{ old('jurusan', $kelas->jurusan) == 'DPIB' ? 'selected' : '' }}>DPIB</option>
                        <option value="Geospasial" {{ old('jurusan', $kelas->jurusan) == 'Geospasial' ? 'selected' : '' }}>Geospasial</option>
                        <option value="MPLB" {{ old('jurusan', $kelas->jurusan) == 'MPLB' ? 'selected' : '' }}>MPLB</option>
                        <option value="PPLG" {{ old('jurusan', $kelas->jurusan) == 'PPLG' ? 'selected' : '' }}>PPLG</option>
                        <option value="TAV" {{ old('jurusan', $kelas->jurusan) == 'TAV' ? 'selected' : '' }}>TAV</option>
                        <option value="Teknik Kendaraan Ringan" {{ old('jurusan', $kelas->jurusan) == 'Teknik Kendaraan Ringan' ? 'selected' : '' }}>Teknik Kendaraan Ringan</option>
                        <option value="Teknik Las" {{ old('jurusan', $kelas->jurusan) == 'Teknik Las' ? 'selected' : '' }}>Teknik Las</option>
                        <option value="Teknik Mesin" {{ old('jurusan', $kelas->jurusan) == 'Teknik Mesin' ? 'selected' : '' }}>Teknik Mesin</option>
                        <option value="Teknik Sepeda Motor" {{ old('jurusan', $kelas->jurusan) == 'Teknik Sepeda Motor' ? 'selected' : '' }}>Teknik Sepeda Motor</option>
                        <option value="TKJT" {{ old('jurusan', $kelas->jurusan) == 'TKJT' ? 'selected' : '' }}>TKJT</option>
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
