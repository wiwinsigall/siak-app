@extends('layouts.master')

@section('content')
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><strong>Data Mata Pelajaran</strong></h3>
                </div>
                <div class="d-flex justify-content-start">
                    <a href="{{ route('mata_pelajaran.tambah')}}" class="btn btn-outline-primary btn-sm ml-3 mr-2 text-small text-primary">Tambah</a>
                    <a href="#" class="btn btn-outline-primary btn-sm text-small text-primary">Cari</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table tablesorter">
                            <thead class="text-primary text-center">
                                <tr>
                                    <th>No</th>
                                    <th>Mata Pelajaran</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($mata_pelajaran as $m)
                            <tr class="text-center">
                                <td>{{ $loop->iteration }}</td> 
                                <td>{{ $m->nama_mapel }}</td>
                                <td>
                                    <a href="{{ route('mata_pelajaran.ubah', $m->id_mapel) }}" class="text-info">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('mata_pelajaran.hapus', $m->id_mapel) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Anda yakin menghapus data ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn p-0 border-0 bg-transparent text-danger">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
