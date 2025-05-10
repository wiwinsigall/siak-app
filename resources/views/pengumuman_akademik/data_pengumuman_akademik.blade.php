@extends('layouts.master')

@section('content')
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><strong>Pengumuman Akademik</strong></h3>
                </div>
                <div class="d-flex justify-content-start">
                    <a href="{{ route('pengumuman_akademik.tambah') }}" class="btn btn-outline-primary btn-sm ml-3 mr-2 text-small text-primary">Tambah</a>
                </div>
                <div class="card-body">

                @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <div class="row">
                        @foreach ($pengumuman_akademik as $p)
                        <div class="col-md-12 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <iframe src="{{ asset('storage/pengumuman_akademik/' . $p->file) }}" width="100%" height="500px"></iframe>
                                </div>
                                <div class="card-footer text-right">
                                    <a href="{{ route('pengumuman_akademik.ubah', $p->id_pengumuman) }}" class="btn btn-info btn-sm">Ubah</a>
                                    <form action="{{ route('pengumuman_akademik.hapus', $p->id_pengumuman) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Yakin ingin menghapus pengumuman ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
