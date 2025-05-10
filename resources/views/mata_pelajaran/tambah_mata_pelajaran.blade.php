@extends('layouts.master')

@section('content')
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><strong>Tambah Mata Pelajaran</strong></h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('mata_pelajaran.tambah') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="nama_mapel">Nama Mata Pelajaran</label>
                            <input type="text" class="form-control" id="nama_mapel" name="nama_mapel" required>
                        </div>
                        <div class="text-right">
                            <a href="{{ route('mata_pelajaran.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
