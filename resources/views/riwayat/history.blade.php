@extends('layouts.mantis')

@section('content')
<div class="container">
    <h2 class="mb-4">Riwayat Siswa</h2>

    <form method="GET" action="{{ route('riwayat.siswa') }}" class="mb-4">
        <div class="input-group">
            <input type="text" name="keyword" class="form-control" placeholder="Cari Nama / NIS..." value="{{ request('keyword') }}">
            <button class="btn btn-primary" type="submit">Cari</button>
        </div>
    </form>

    @if($siswa)
        <div class="card mb-4">
            <div class="card-body">
                <table class="table table-borderless mb-0" style="width: 100%; max-width: 500px;">
                    <tr>
                        <th style="width: 150px;">Nama</th>
                        <td>: {{ $siswa->nama }}</td>
                    </tr>
                    <tr>
                        <th>NIS</th>
                        <td>: {{ $siswa->nis }}</td>
                    </tr>
                    <tr>
                        <th>Jenis Kelamin</th>
                        <td>: {{ $siswa->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                    </tr>
                    <tr>
                        <th>Jurusan</th>
                        <td>: {{ $siswa->jurusan }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <ul class="nav nav-tabs mb-3" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#kelas">Kelas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#absensi">Absensi</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#nilai">Nilai</a>
            </li>
        </ul>

        <div class="tab-content">
            <!-- Tab Kelas -->
            <div class="tab-pane fade show active" id="kelas">
                <table class="table table-bordered">
                    <thead class="text-center">
                        <tr>
                            <th>No</th>
                            <th>Kelas</th>
                            <th>Tahun Ajaran</th>
                            <th>Semester</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                            <th>Wali Kelas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($riwayat_kelas as $i => $k)
                            <tr class="text-center">
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $k->kelas->kelas }} {{ $k->kelas->jurusan }}</td>
                                <td>{{ $k->tahun_ajaran->tahun_ajaran }}</td>
                                <td>{{ ucfirst($k->tahun_ajaran->semester) }}</td>
                                <td>{{ ucfirst($k->status) }}</td>
                                <td>{{ ucfirst($k->keterangan) }}</td>
                                <td>{{ $k->guru->nama ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Tab Absensi -->
            <div class="tab-pane fade" id="absensi">
                <table class="table table-bordered">
                    <thead>
                        <tr class="text-center">
                            <th>No</th>
                            <th>Tahun Ajaran</th>
                            <th>Sakit</th>
                            <th>Izin</th>
                            <th>Alpa</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($riwayat_absensi as $i => $a)
                            <tr class="text-center">
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $a->tahun_ajaran->tahun_ajaran }} ({{ ucfirst($a->tahun_ajaran->semester) }})</td>
                                <td>{{ $a->sakit }}</td>
                                <td>{{ $a->izin }}</td>
                                <td>{{ $a->alpa }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Tab Nilai -->
            <div class="tab-pane fade" id="nilai">
                @foreach($riwayat_nilai as $reg_id => $nilai_set)
                    @php
                        $first = $nilai_set->first();
                    @endphp

                    <div class="bg-light p-2 ps-3 mb-2 border rounded">
                        <strong>
                            Kelas {{ $first->registrasi_kelas->kelas->kelas }} {{ $first->registrasi_kelas->kelas->jurusan }} -
                            {{ $first->registrasi_kelas->tahun_ajaran->tahun_ajaran }}
                            <span class="text-muted">({{ ucfirst($first->registrasi_kelas->tahun_ajaran->semester) }})</span>
                        </strong>
                    </div>

                    <table class="table table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th>No</th>
                                <th>Mata Pelajaran</th>
                                <th>Nilai Tugas</th>
                                <th>UTS</th>
                                <th>UAS</th>
                                <th>Nilai Akhir</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($nilai_set as $i => $n)
                                <tr class="text-center">
                                    <td>{{ $i + 1 }}</td>
                                    <td class="text-start">{{ $n->mata_pelajaran->nama_mapel }}</td>
                                    <td>{{ $n->nilai_tugas }}</td>
                                    <td>{{ $n->nilai_uts }}</td>
                                    <td>{{ $n->nilai_uas }}</td>
                                    <td><strong>{{ $n->nilai_akhir }}</strong></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
