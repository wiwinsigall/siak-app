@extends('layouts.mantis')

@section('content')
<div>
    <div class="card">
        <!-- Header -->
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="card-title mb-0"><strong>Absensi</strong></h2>
        </div>

        <div class="card-body">
            {{-- Flash Message --}}
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <!-- Navigasi Kelas & Semester -->
            <div class="mb-4">
                <div class="d-flex flex-wrap align-items-center gap-3">
                    {{-- Tombol Kelas --}}
                    <div class="btn-group" role="group">
                        @foreach(['X', 'XI', 'XII'] as $kelasOption)
                            <a href="{{ url()->current() }}?kelas={{ $kelasOption }}&semester={{ $semesterAktif }}"
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
                            <a href="{{ url()->current() }}?kelas={{ $kelasAktif }}&semester={{ $semesterOption }}"
                               class="btn {{ $semesterAktif === $semesterOption 
                                            ? 'bg-teal-200 text-dark border border-primary' 
                                            : 'bg-white text-teal border border-primary' }}">
                                {{ ucfirst($semesterOption) }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Tabel Absensi --}}
            @if($absensi->isEmpty())
                <div class="alert alert-info">
                    Belum ada data absensi untuk kelas <strong>{{ $kelasAktif }}</strong> semester <strong>{{ ucfirst($semesterAktif) }}</strong>.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered text-center">
                        <thead class="table-light">
                            <tr>
                                <th>No.</th>
                                <th>Mata Pelajaran</th>
                                <th>Jumlah Hadir</th>
                                <th>Total Pertemuan</th>
                                <th>Persentase Kehadiran</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($absensi as $id_mapel => $data)
                                @php
                                    $mapel = $data->first()->mata_pelajaran->nama_mapel ?? '-';
                                    $total = $data->count();
                                    $hadir = $data->where('keterangan', 'Hadir')->count();
                                    $persen = $total > 0 ? round(($hadir / $total) * 100, 1) : 0;
                                @endphp
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $mapel }}</td>
                                    <td>{{ $hadir }}</td>
                                    <td>{{ $total }}</td>
                                    <td class="text-start align-middle">
                                        <div style="font-size: 0.9rem; font-weight: 500; color: #6c757d; margin-bottom: 4px;">
                                            {{ is_numeric($persen) ? number_format($persen, 2) : '0.00' }}%
                                        </div>
                                        <div style="height: 8px; background-color: #e6f4f1; border-radius: 4px;">
                                            <div style="height: 8px; width: {{ is_numeric($persen) ? $persen : 0 }}%; background-color: #45c9a5; border-radius: 4px;"></div>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="{{ route('absensi.siswa.detail', ['id_mapel' => $id_mapel]) }}" class="text-primary">
                                            <i class="fas fa-info-circle"></i>
                                        </a>
                                    </td>
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
