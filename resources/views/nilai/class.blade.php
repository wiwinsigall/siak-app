@extends('layouts.mantis')

@section('content')
<div>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="card-title"><strong>Nilai Siswa per Kelas</strong></h2>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered text-center" id="table">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Nama Kelas</th>
                            <th class="text-center">Tahun Ajaran</th>
                            <th class="text-center">Semester</th>
                            <th class="text-center">Wali Kelas</th>
                            <th class="text-center">Jumlah Siswa</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kelas as $k)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $k->kelas }} {{ $k->jurusan }}</td>
                            <td class="text-center">
                                {{ $k->tahun_ajaran_aktif->tahun_ajaran ?? '-' }}
                            </td>
                            <td class="text-center">
                                {{ $k->tahun_ajaran_aktif->semester ?? '-' }}
                            </td>
                            <td>{{ $k->wali_kelas ?? '-' }}</td>
                            <td class="text-center">{{ $k->jumlah_siswa_aktif }}</td>
                            <td>
                                <a href="{{ route('nilai.showBySubject', $k->id_kelas) }}" class="text-blue-500" title="Rekap Absensi">
                                    <i class="fas fa-edit"></i>
                                </a>
                                
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

