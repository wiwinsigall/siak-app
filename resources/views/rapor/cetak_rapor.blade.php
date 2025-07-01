<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rapor {{ $siswa->nama }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; margin: 30px; color: #000; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; vertical-align: top; }
        .no-border td { border: none; padding: 4px 2px; }
        .section-title { font-weight: bold; margin-top: 20px; }
    </style>
</head>
<body>

    <h2 style="text-align:center;">RAPOR PESERTA DIDIK</h2>

    <table class="no-border" style="width: 100%; line-height: 1.8;">
        <tr>
            <td style="width: 25%;">Nama Peserta Didik</td>
            <td style="width: 2%;">:</td>
            <td style="width: 38%;">{{ strtoupper($siswa->nama) }}</td>
            <td style="width: 15%;">Kelas</td>
            <td style="width: 2%;">:</td>
            <td>{{ $siswa->registrasi_aktif->kelas->kelas }} {{ $siswa->registrasi_aktif->kelas->jurusan }}</td>
        </tr>
        <tr>
            <td>Nomor Induk Siswa/NISN</td>
            <td>:</td>
            <td>{{ $siswa->nis }} / -</td>
            <td>Semester</td>
            <td>:</td>
            <td>{{ ucfirst($siswa->registrasi_aktif->tahun_ajaran->semester) }}</td>
        </tr>
        <tr>
            <td>Sekolah</td>
            <td>:</td>
            <td>SMK NEGERI 1 MEMPURA</td>
            <td>Tahun Pelajaran</td>
            <td>:</td>
            <td>{{ $siswa->registrasi_aktif->tahun_ajaran->tahun_ajaran }}</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>:</td>
            <td colspan="4">{{ $siswa->alamat }}</td>
        </tr>
    </table>

    <p class="section-title">A. Nilai Akademik</p>
    <table>
        <thead>
            <tr style="background-color: #f5f5f5;">
                <th style="width: 30px;">No</th>
                <th style="width: 30%;">Mata Pelajaran</th>
                <th style="width: 60px;">Nilai Akhir</th>
                <th style="text-align: center;">Capaian Kompetensi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($nilai_rapor as $i => $n)
            <tr>
                <td style="text-align: center;">{{ $i + 1 }}</td>
                <td>{{ $n->nama_mapel }}</td>
                <td style="text-align: center;">{{ $n->nilai_akhir }}</td>
                <td>{!! nl2br(e($n->des_laporan ?? '-')) !!}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <p class="section-title">B. Ekstrakurikuler</p>
    <table style="width: 100%; border: 1px solid #000; border-collapse: collapse;">
        <thead>
            <tr style="background-color: #f5f5f5;">
                <th style="width: 5%; text-align: center; border: 1px solid #000; padding: 8px;">No</th>
                <th style="width: 70%; text-align: center; border: 1px solid #000; padding: 8px;">Kegiatan Ekstrakurikuler</th>
                <th style="width: 25%; text-align: center; border: 1px solid #000; padding: 8px;">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @for ($i = 1; $i <= 2; $i++)
            <tr>
                <td style="text-align: center; border: 1px solid #000; padding: 8px;">{{ $i }}</td>
                <td style="border: 1px solid #000; padding: 8px;"></td>
                <td style="border: 1px solid #000; padding: 8px;"></td>
            </tr>
            @endfor
        </tbody>
    </table>

    <p class="section-title">C. Ketidakhadiran</p>
    <table style="width: 50%;">
        <tr><td style="width: 50%;">Sakit</td><td>: {{ $rekap_absensi['Sakit'] ?? 0 }} hari</td></tr>
        <tr><td>Izin</td><td>: {{ $rekap_absensi['Izin'] ?? 0 }} hari</td></tr>
        <tr><td>Tanpa Keterangan</td><td>: {{ $rekap_absensi['Alpa'] ?? 0 }} hari</td></tr>
    </table>

<br><br>
<table class="no-border" style="margin-top: 60px; width: 100%;">
    {{-- Baris label tanda tangan --}}
    <tr style="text-align: center;">
        <td style="width: 33%;">Orang Tua/Wali</td>
        <td></td>
        <td style="width: 33%;">
            @php
                \Carbon\Carbon::setLocale('id');
            @endphp
            Siak, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br>
            Wali Kelas
        </td>
    </tr>

    {{-- Jarak tanda tangan --}}
    <br><br><br>
    <tr style="height: 100px;">
        <td></td>
        <td></td>
        <td></td>
    </tr>

    {{-- Tanda tangan baris --}}
    <tr style="text-align: center;">
        <td>........................................................</td>
        <td></td>
        <td>
            <strong>{{ strtoupper($siswa->registrasi_aktif->guru->nama) }}</strong><br>
            NIP. {{ $siswa->registrasi_aktif->guru->nip }}
        </td>
    </tr>
</table>

{{-- Jarak untuk kepala sekolah --}}
<table class="no-border" style="width: 100%;">
    <tr style="text-align: center;">
        <td style="width: 100%;">
            Mengetahui,<br>
            Plt. Kepala Sekolah
        </td>
    </tr>
    <br><br><br>
    <tr style="text-align: center;">
        <td>
            <strong>ROZIAN ELFIS, S.Pd., M.Pd.</strong><br>
            NIP. 197403282003122003
        </td>
    </tr>
</table>

</body>
</html>
