@extends('layouts.mantis')

@section('content')
<div>
    <div class="card">
        <!-- Header -->
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="card-title"><strong>Data Nilai Siswa</strong></h2>
            <a href="{{ route('nilai.index') }}" class="btn text-primary">Kembali</a>
        </div>

        <div class="card-body">

            {{-- Tabel Nilai --}}
            <div class="table-responsive">
                <table class="table table-bordered text-center" id="table">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">NIS</th>
                            <th class="text-center">Nama Siswa</th>
                            <th class="text-center">Nilai Tugas</th>
                            <th class="text-center">Nilai UTS</th>
                            <th class="text-center">Nilai UAS</th>
                            <th class="text-center">Nilai Akhir</th>
                            <th class="text-center">Capaian Pembelajaran</th>
                            @if(in_array(Auth::user()->role, ['guru', 'wali_kelas']))
                                <th class="text-center">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($nilai as $i => $n)
                            <tr>
                                <td class="text-center">{{ $i + 1 }}</td>
                                <td class="text-center">{{ $n->nis }}</td>
                                <td class="text-center">{{ $n->siswa->nama }}</td>
                                <td class="text-center">{{ $n->nilai_tugas }}</td>
                                <td class="text-center">{{ $n->nilai_uts }}</td>
                                <td class="text-center">{{ $n->nilai_uas }}</td>
                                <td class="text-center">{{ $n->nilai_akhir }}</td>
                                <td class="text-center">{{ $n->des_laporan }}</td>

                                @if(in_array(Auth::user()->role, ['guru', 'wali_kelas']))
                                    <td>
                                        <a href="{{ route('nilai.edit', [$n->id_registrasi, $n->id_mapel]) }}" class="text-blue-500 mr-2" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
