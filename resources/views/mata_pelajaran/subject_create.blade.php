@extends('layouts.mantis')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h2 class="card-title"><strong>Form Tambah Mata Pelajaran</strong></h2>
        <a href="{{ route('mata_pelajaran.index') }}" class="btn text-primary">Kembali</a>
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

        <form action="{{ route('mata_pelajaran.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="nama_mapel">Nama Mata Pelajaran</label>
                <input type="text" class="form-control" id="nama_mapel" name="nama_mapel" value="{{ old('nama_mapel') }}" required>
            </div>

            <div class="form-group">
                <label for="kkm">KKM</label>
                <input type="number" class="form-control" id="kkm" name="kkm" min="0" max="100" value="{{ old('kkm') }}" required>
            </div>

            <div class="form-group">
                <label for="id_kelas">Kelas</label>
                <select name="id_kelas" id="id_kelas" class="form-control" required>
                    <option value="">-- Pilih Kelas --</option>
                    @foreach($kelas as $k)
                        <option value="{{ $k->id_kelas }}" {{ old('id_kelas') == $k->id_kelas ? 'selected' : '' }}>
                            {{ $k->kelas }} {{ $k->jurusan }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="nip">Guru</label>
                <select name="nip" id="nip" class="form-control" required>
                    <option value="">-- Pilih Guru --</option>
                    @foreach($guru as $g)
                        <option value="{{ $g->nip }}" {{ old('nip') == $g->nip ? 'selected' : '' }}>
                            {{ $g->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mt-4 d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
