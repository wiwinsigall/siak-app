@extends('layouts.master')

@section('content')
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><strong>Data Siswa</strong></h3>
                </div>
                <div class="d-flex justify-content-start">
                    <a href="{{ route('siswa.tambah')}}" class="btn btn-outline-primary btn-sm ml-3 mr-2 text-small text-primary">Tambah</a>
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
                                    <th>NIS</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>TTL</th>
                                    <th>Alamat</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Jurusan</th>
                                    <th>Kelas</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($siswa as $s)
                            <tr class="text-center">
                                <td>{{ $loop->iteration }}</td> 
                                <td>{{ $s->nis }}</td>
                                <td>{{ $s->nama }}</td>
                                <td>{{ $s->email }}</td>
                                <td>{{ $s->ttl }}</td>
                                <td>{{ $s->alamat }}</td>
                                <td>{{ $s->jenis_kelamin }}</td>
                                <td>{{ $s->jurusan }}</td>
                                <td>{{ $s->kelas ? $s->kelas->nama_kelas : '-' }}</td>
                                <td>
                                    <a href="{{ route('siswa.detail', $s->nis) }}" class="text-white">
                                        <i class="fas fa-info-circle"></i>
                                    </a>
                                    <a href="{{ route('siswa.ubah', $s->nis) }}" class="text-info">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('siswa.hapus', $s->nis) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
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
