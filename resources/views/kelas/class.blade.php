@extends('layouts.mantis')

@section('content')
<div>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="card-title"><strong>Manajemen Kelas</strong></h2>
            <a href="{{ route('tahun_ajaran.index') }}" class="btn text-primary">Kembali</a>
        </div>

        <div class="card-body">
            <a href="{{ route('kelas.create') }}" class="btn btn-primary">Tambah Kelas</a>
            <a href="{{ route('registrasi_kelas.create') }}" class="btn btn-primary">Registrasi Siswa ke Kelas</a>
            <a href="{{ route('kelas.promotion_form') }}" class="btn btn-primary">Naik/Tinggal Kelas</a>

            <div class="table-responsive mt-3">
                <table class="table table-bordered" id="table">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Nama Kelas</th>
                            <th class="text-center">Tahun Ajaran</th>
                            <th class="text-center">Semester</th>
                            <th class="text-center">Wali Kelas</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kelas as $k)
                            <tr class="text-center">
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $k->nama_kelas }}</td>
                                <td>{{ $k->tahun_ajaran ?? '-' }}</td>
                                <td>{{ ucfirst($k->semester) ?? '-' }}</td>
                                <td>{{ $k->wali_kelas ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('kelas.detail', $k->id_kelas) }}" class="text-gray-600">
                                        <i class="fas fa-info-circle"></i>
                                    </a>
                                    <a href="{{ route('kelas.edit', $k->id_kelas) }}" class="text-info me-1">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('kelas.delete', $k->id_kelas) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Anda yakin menghapus data ini?');">
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
@endsection
