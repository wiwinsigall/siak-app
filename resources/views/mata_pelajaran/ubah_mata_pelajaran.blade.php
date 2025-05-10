@extends('layouts.master')

@section('content')
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><strong>Ubah Mata Pelajaran</strong></h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('mata_pelajaran.update', $mata_pelajaran->id_mapel) }}" method="POST">
                        @csrf
                        @method('PUT') {{-- Untuk method PUT karena update --}}
                        <div class="form-group">
                            <label for="nama_mapel">Nama Mata Pelajaran</label>
                            <input type="text" class="form-control" id="nama_mapel" name="nama_mapel" value="{{ $mata_pelajaran->nama_mapel }}" required>
                        </div>
                        <div class="text-right">
                            <a href="{{ route('mata_pelajaran.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
