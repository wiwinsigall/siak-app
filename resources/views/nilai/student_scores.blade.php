@extends('layouts.mantis')

@section('content')
<div>
    <div class="card">
        <!-- Header -->
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="card-title mb-0"><strong>Nilai</strong></h2>
        </div>

        <div class="card-body">
            {{-- Flash Message --}}
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <!-- Navigasi Kelas & Semester Sejajar -->
            <div class="mb-4">
                <div class="d-flex flex-wrap align-items-center gap-3">
                    {{-- Tombol Kelas --}}
                    <div class="btn-group" role="group">
                        @foreach(['X', 'XI', 'XII'] as $kelasOption)
                            <a href="{{ route('nilai.siswa', ['kelas' => $kelasOption, 'semester' => request('semester', $semesterAktif)]) }}"
                            class="btn {{ $kelasAktif === $kelasOption 
                                            ? 'bg-blue-500 text-white' 
                                            : 'bg-white text-primary border border-primary' }}">
                                Kelas {{ $kelasOption }}
                            </a>
                        @endforeach
                    </div>

                    {{-- Tombol Semester --}}
                    <div class="btn-group ms-3" role="group">
                        @foreach(['ganjil', 'genap'] as $semesterOption)
                            <a href="{{ route('nilai.siswa', ['kelas' => $kelasAktif, 'semester' => $semesterOption]) }}"
                            class="btn {{ $semesterAktif === $semesterOption 
                                            ? 'bg-teal-200 text-dark border border-primary' 
                                            : 'bg-white text-teal border border-primary' }}">
                                {{ ucfirst($semesterOption) }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Tabel Nilai --}}
            @if($nilai->isEmpty())
                <div class="alert alert-info">
                    Belum ada data nilai untuk kelas <strong>{{ $kelasAktif }}</strong> semester <strong>{{ ucfirst($semesterAktif) }}</strong>.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered text-center">
                        <thead class="table-light">
                            <tr>
                                <th>No.</th>
                                <th>Mata Pelajaran</th>
                                <th>Kelas</th>
                                <th>Nilai Tugas</th>
                                <th>Nilai UTS</th>
                                <th>Nilai UAS</th>
                                <th>Nilai Akhir</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($nilai as $i => $n)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ $n->mata_pelajaran->nama_mapel ?? '-' }}</td>
                                    <td>
                                        {{ $n->registrasi_kelas->kelas->kelas ?? '-' }}
                                        {{ $n->registrasi_kelas->kelas->jurusan ?? '' }}
                                    </td>
                                    <td>{{ $n->nilai_tugas }}</td>
                                    <td>{{ $n->nilai_uts }}</td>
                                    <td>{{ $n->nilai_uas }}</td>
                                    <td><strong>{{ $n->nilai_akhir }}</strong></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
