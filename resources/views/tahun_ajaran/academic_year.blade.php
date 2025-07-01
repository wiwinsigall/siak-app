@extends('layouts.mantis')

@section('content')
<div class="">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="card-title"><strong>Data Tahun Ajaran</strong></h2>
        </div>

        <div class="card-body">
        <div class="mb-3">
            <a href="{{ route('tahun_ajaran.create') }}" class="btn btn-primary">Tambah Tahun Ajaran</a>
            <a href="{{ route('kelas.index') }}" class="btn btn-primary">Manajemen Kelas</a>
        </div>

            <div class="table-responsive">
                <table class="table table-bordered" id="table">
                    <thead>
                        <tr >
                            <th class="text-center">No</th>
                            <th class="text-center">Tahun Ajaran</th>
                            <th class="text-center">Semester</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                         @foreach ($tahunAjaran as $ta)
                            <tr class="text-center">
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $ta->tahun_ajaran }}</td>
                                <td>{{ $ta->semester }}</td>
                                <td>
                                    <span class="badge {{ strtolower($ta->status) == 'aktif' ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $ta->status }}
                                    </span>
                                </td>
                                <td>
                                    @if(strtolower($ta->status) != 'aktif')
                                        <form method="POST" action="{{ route('tahun_ajaran.activate', $ta->id_tahun_ajaran) }}" style="display:inline-block;">
                                            @csrf
                                            <button class="btn btn-sm btn-success">Aktifkan</button>
                                        </form>
                                    @else
                                        <span class="text-muted">Sudah Aktif</span>
                                    @endif

                                    <a href="{{ route('tahun_ajaran.edit', $ta->id_tahun_ajaran) }}" class="text-blue-500 ms-2">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="{{ route('tahun_ajaran.delete', $ta->id_tahun_ajaran) }}" method="POST" class="d-inline ms-1" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
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
