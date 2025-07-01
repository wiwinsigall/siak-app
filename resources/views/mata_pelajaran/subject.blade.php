@extends('layouts.mantis')

@section('content')
<div>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="card-title"><strong>Data Mata Pelajaran</strong></h2>
            <a href="{{ route('mata_pelajaran.create') }}" class="btn btn-primary">Tambah Data</a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="table">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Mata Pelajaran</th>
                            <th class="text-center">KKM</th>
                            <th class="text-center">Kelas</th>
                            <th class="text-center">Nama Guru</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($mata_pelajaran as $m)
                            <tr class="text-center">
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $m->nama_mapel }}</td>
                                <td class="text-center">{{ $m->kkm }}</td>
                                <td>{{ $m->kelas->kelas }} {{ $m->kelas->jurusan }}</td>
                                <td>{{ $m->guru->nama ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('mata_pelajaran.edit', $m->id_mapel) }}" class="text-blue-500 mr-2">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('mata_pelajaran.delete', $m->id_mapel) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
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
