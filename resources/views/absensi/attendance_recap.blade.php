@extends('layouts.mantis')

@section('content')
<div>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="card-title"><strong>Data Absensi Kelas</strong></h2>
            <a href="{{ route('absensi.index') }}" class="btn text-primary">Kembali</a>
        </div>

        <div class="card-body">
            <div class="mb-3">
                <a href="{{ route('absensi.create', $kelas->id_kelas) }}" class="btn btn-primary">
                    Input Absensi
                </a>
            </div>
            
            <div class="table-responsive">
                <table class="table table-bordered text-center" id="table">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Tanggal</th>
                            <th class="text-center">Jumlah Hadir</th>
                            <th class="text-center">Jumlah Sakit</th>
                            <th class="text-center">Jumlah Izin</th>
                            <th class="text-center">Jumlah Alpa</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rekap as $row)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center">{{ $row->tanggal }}</td>
                                <td class="text-center">{{ $row->jumlah_hadir }}</td>
                                <td class="text-center">{{ $row->jumlah_sakit }}</td>
                                <td class="text-center">{{ $row->jumlah_izin }}</td>
                                <td class="text-center">{{ $row->jumlah_alpa }}</td>
                                <td>
                                    <a href="{{ route('absensi.showByDate', [$kelas->id_kelas, $row->tanggal, 'id_mapel' => $row->id_mapel]) }}" class="text-blue-500">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    @if(in_array(Auth::user()->role, ['guru', 'wali_kelas']))
                                        <form action="{{ route('absensi.deleteByDate', ['id_kelas' => $kelas->id_kelas, 'tanggal' => $row->tanggal]) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus absensi tanggal ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn p-0 border-0 bg-transparent text-danger" title="Hapus">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    @endif
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
