@extends('layouts.master')

@section('content')
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><strong>Data Kelas</strong></h3>
                </div>
                <div class="d-flex justify-content-start">
                    <a href="{{ route('kelas.tambah')}}" class="btn btn-outline-primary btn-sm ml-3 mr-2 text-small text-primary">Tambah</a>
                    <a href="#" class="btn btn-outline-primary btn-sm text-small text-primary">Cari</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table tablesorter">
                            <thead class="text-primary text-center">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Kelas</th>
                                    <th>Semester</th>
                                    <th>Tahun Ajaran</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($kelas as $k)
                            <tr class="text-center">
                                <td>{{ $loop->iteration }}</td> 
                                <td>{{ $k->nama_kelas }}</td>
                                <td>{{ $k->semester }}</td>
                                <td>{{ $k->tahun_ajaran }}</td>
                                <td>
                                    <a href="{{ route('kelas.ubah', $k->id_kelas) }}" class="text-info">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('siswa.hapus', $k->id_kelas) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Anda yakin menghapus data ini?');">
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
