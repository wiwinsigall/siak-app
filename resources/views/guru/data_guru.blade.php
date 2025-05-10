@extends('layouts.master')

@section('content')
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><strong>Data Guru</strong></h3>
                </div>
                <div class="d-flex justify-content-start">
                    <a href="{{ route('guru.tambah')}}" class="btn btn-outline-primary btn-sm ml-3 mr-2 text-small text-primary">Tambah</a>
                    <a href="#" class="btn btn-outline-primary btn-sm mr-2 text-small text-primary">Filter</a>
                    <a href="#" class="btn btn-outline-primary btn-sm text-small mr-2 text-primary">Clear Filter</a>
                    <a href="#" class="btn btn-outline-primary btn-sm text-small text-primary">Cari</a>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table tablesorter">
                            <thead class="text-primary text-center">
                                <tr>
                                    <th>No</th>
                                    <th>NIP</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>TTL</th>
                                    <th>Alamat</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Jabatan</th>
                                    <th>Golongan</th>
                                    <th>Mata Pelajaran</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($guru as $g)
                            <tr class="text-center">
                                <td>{{ $loop->iteration }}</td> 
                                <td>{{ $g->nip }}</td>
                                <td>{{ $g->nama }}</td>
                                <td>{{ $g->email }}</td>
                                <td>{{ $g->ttl }}</td>
                                <td>{{ $g->alamat }}</td>
                                <td>{{ $g->jenis_kelamin }}</td>
                                <td>{{ $g->jabatan }}</td>
                                <td>{{ $g->golongan }}</td>
                                <td>{{ $g->mata_pelajaran ? $g->mata_pelajaran->nama_mapel : '-' }}</td>
                                <td>
                                    <a href="{{ route('guru.detail', $g->nip) }}" class="text-white">
                                        <i class="fas fa-info-circle"></i>
                                    </a>
                                    <a href="{{ route('guru.ubah', $g->nip) }}" class="text-info">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('guru.hapus', $g->nip) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Anda yakin menghapus data ini?');">
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
