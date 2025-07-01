@extends('layouts.mantis')

@section('content')
<div>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="card-title"><strong>Data Guru</strong></h2>
            <a href="{{ route('guru.create') }}" class="btn btn-primary">Tambah Data</a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="table">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">NIP</th>
                            <th class="text-center">Nama</th>
                            <th class="text-center">Email</th>
                            <th class="text-center">TTL</th>
                            <th class="text-center">Alamat</th>
                            <th class="text-center">Jenis Kelamin</th>
                            <th class="text-center">Jabatan</th>
                            <th class="text-center">No HP</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($guru as $g)
                            <tr class="text-center">
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $g->nip }}</td>
                                <td>{{ $g->nama }}</td>
                                <td>{{ $g->email }}</td>
                                <td>{{ $g->ttl }}</td>
                                <td>{{ $g->alamat }}</td>
                                <td>{{ $g->jenis_kelamin }}</td>
                                <td>{{ $g->jabatan }}</td>
                                <td>{{ $g->no_hp }}</td>
                                <td>
                                    <a href="{{ route('guru.detail', $g->nip) }}" class="text-gray-600">
                                        <i class="fas fa-info-circle"></i>
                                    </a>
                                    <a href="{{ route('guru.edit', $g->nip) }}" class="text-blue-500">
                                        <i class="fas fa-edit "></i>
                                    </a>
                                    <form action="{{ route('guru.delete', $g->nip) }}" method="POST" class="d-inline" onsubmit="return confirm('Anda yakin menghapus data ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn p-0 border-0 bg-transparent text-red-500">
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
@endsection
