@extends('layouts.mantis')

@section('content')
<div class="">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="card-title"><strong>Form Ubah Mata Pelajaran</strong></h2>
            <a href="{{ route('mata_pelajaran.index') }}" class="btn text-primary">Kembali</a>
        </div>

        <div class="card-body">
            {{-- Tampilkan pesan error jika ada --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('mata_pelajaran.update', $mata_pelajaran->id_mapel) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="nama_mapel"><strong>Nama Mata Pelajaran</strong></label>
                    <input type="text" class="form-control" id="nama_mapel" name="nama_mapel" 
                        value="{{ old('nama_mapel', $mata_pelajaran->nama_mapel) }}" required>
                </div>

                <div class="form-group mt-3">
                    <label for="kkm"><strong>KKM</strong></label>
                    <input type="number" class="form-control" id="kkm" name="kkm" 
                        value="{{ old('kkm', $mata_pelajaran->kkm) }}" min="0" max="100" required>
                </div>

                <div class="form-group mt-3">
                    <label for="id_kelas"><strong>Kelas</strong></label>
                    <select name="id_kelas" id="id_kelas" class="form-control" required>
                        <option value="" disabled>-- Pilih Kelas --</option>
                        @foreach($kelas as $k)
                            <option value="{{ $k->id_kelas }}" {{ old('id_kelas', $mata_pelajaran->id_kelas) == $k->id_kelas ? 'selected' : '' }}>
                                {{ $k->kelas }} {{ $k->jurusan }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group mt-3">
                    <label for="nip"><strong>Guru</strong></label>
                    <select name="nip" id="nip" class="form-control" required>
                        <option value="" disabled>-- Pilih Guru --</option>
                        @foreach($guru as $g)
                            <option value="{{ $g->nip }}" {{ old('nip', $mata_pelajaran->nip) == $g->nip ? 'selected' : '' }}>
                                {{ $g->nama }}
                            </option>
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
