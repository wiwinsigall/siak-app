@extends('layouts.mantis')

@section('content')
<div>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title"><strong>Data Siswa</strong></h3>
            <a href="{{ route('siswa.create') }}" class="btn btn-primary">Tambah Data</a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="table">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">NIS</th>
                            <th class="text-center">Nama</th>
                            <th class="text-center">Email</th>
                            <th class="text-center">TTL</th>
                            <th class="text-center">Alamat</th>
                            <th class="text-center">Jenis Kelamin</th>
                            <th class="text-center">Jurusan</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($siswa as $s)
                            <tr class="text-center">
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $s->nis }}</td>
                                <td>{{ $s->nama }}</td>
                                <td>{{ $s->email }}</td>
                                <td>{{ $s->ttl }}</td>
                                <td>{{ $s->alamat }}</td>
                                <td>{{ $s->jenis_kelamin }}</td>
                                <td>{{ $s->jurusan }}</td>
                                <td>
                                    <a href="{{ route('siswa.detail', $s->nis) }}" class="text-gray-600">
                                        <i class="fas fa-info-circle"></i>
                                    </a>
                                    <a href="{{ route('siswa.edit', $s->nis) }}" class="text-blue-500">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('siswa.delete', $s->nis) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
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
