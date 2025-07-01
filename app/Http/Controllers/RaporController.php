<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\Student;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RaporController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user(); // ambil user login

        // Ambil semua tahun ajaran aktif
        $tahun_ajaran = AcademicYear::where('status', 'aktif')
            ->selectRaw("CONCAT(tahun_ajaran, ' - ', semester) as label, id_tahun_ajaran")
            ->pluck('label', 'id_tahun_ajaran');

        // FILTER kelas berdasarkan role wali_kelas atau tampilkan semua jika staff
        if ($user->role === 'wali_kelas') {
            // Ambil ID kelas yang dipimpin oleh wali kelas dari tabel registrasi_kelas
            $allKelas = DB::table('registrasi_kelas')
                ->join('kelas', 'registrasi_kelas.id_kelas', '=', 'kelas.id_kelas')
                ->where('registrasi_kelas.nip', $user->nip)
                ->where('registrasi_kelas.status', 'aktif')
                ->select('kelas.id_kelas', 'kelas.kelas', 'kelas.jurusan')
                ->groupBy('kelas.id_kelas', 'kelas.kelas', 'kelas.jurusan')
                ->get();
        } else {
            $allKelas = DB::table('kelas')->get();
        }

        $selectedTahunAjaran = $request->input('id_tahun_ajaran');
        $selectedKelas = $request->input('id_kelas');

        $siswa = [];

        // Jika form sudah dipilih, ambil daftar siswa
        if ($selectedTahunAjaran && $selectedKelas) {
            // Validasi tambahan: pastikan wali kelas hanya melihat kelasnya
            if ($user->role === 'wali_kelas') {
                $kelasDipimpin = DB::table('registrasi_kelas')
                    ->where('id_kelas', $selectedKelas)
                    ->where('nip', $user->nip)
                    ->where('status', 'aktif')
                    ->exists();

                if (!$kelasDipimpin) {
                    return redirect()->route('rapor.index')->with('error', 'Anda bukan wali dari kelas tersebut.');
                }
            }

            // Ambil siswa berdasarkan filter
            $siswa = DB::table('registrasi_kelas')
                ->join('siswa', 'registrasi_kelas.nis', '=', 'siswa.nis')
                ->where('registrasi_kelas.id_kelas', $selectedKelas)
                ->where('registrasi_kelas.id_tahun_ajaran', $selectedTahunAjaran)
                ->where('registrasi_kelas.status', 'aktif')
                ->select('siswa.nis', 'siswa.nama')
                ->orderBy('siswa.nama')
                ->get();
        }

        return view('rapor.rapor', compact(
            'tahun_ajaran',
            'allKelas',
            'selectedTahunAjaran',
            'selectedKelas',
            'siswa'
        ));
    }

    public function cetak($nis, $id_tahun_ajaran)
    {
        $user = Auth::user();

        // Ambil data registrasi aktif siswa berdasarkan tahun ajaran
        $registrasi = DB::table('registrasi_kelas')
            ->where('nis', $nis)
            ->where('id_tahun_ajaran', $id_tahun_ajaran)
            ->where('status', 'aktif')
            ->first();

        if (!$registrasi) {
            abort(404, 'Data registrasi siswa tidak ditemukan.');
        }

        // Validasi wali kelas
        if ($user->role === 'wali_kelas' && $registrasi->nip !== $user->nip) {
            abort(403, 'Anda bukan wali kelas dari siswa ini.');
        }

        // Ambil data siswa dan relasi
        $siswa = Student::with([
            'registrasi_aktif.kelas',
            'registrasi_aktif.tahun_ajaran',
            'registrasi_aktif.guru',
            'absensi',
        ])->findOrFail($nis);

        $id_registrasi = $registrasi->id_registrasi;

        // Ambil nilai dan capaian pembelajaran
        $nilai_rapor = DB::table('nilai_rapor')
            ->join('mata_pelajaran', 'nilai_rapor.id_mapel', '=', 'mata_pelajaran.id_mapel')
            ->where('nilai_rapor.nis', $nis)
            ->where('nilai_rapor.id_registrasi', $id_registrasi)
            ->select('nilai_rapor.nilai_akhir', 'nilai_rapor.des_laporan', 'mata_pelajaran.nama_mapel')
            ->get();

        // Rekap absensi
        $rekap_absensi = [
            'Sakit' => DB::table('absensi')->where('nis', $nis)->where('id_tahun_ajaran', $id_tahun_ajaran)->where('keterangan', 'Sakit')->count(),
            'Izin' => DB::table('absensi')->where('nis', $nis)->where('id_tahun_ajaran', $id_tahun_ajaran)->where('keterangan', 'Izin')->count(),
            'Alpa' => DB::table('absensi')->where('nis', $nis)->where('id_tahun_ajaran', $id_tahun_ajaran)->where('keterangan', 'Alpa')->count(),
        ];

        $pdf = Pdf::loadView('rapor.cetak_rapor', compact('siswa', 'nilai_rapor', 'rekap_absensi'))->setPaper('A4', 'portrait');
        return $pdf->stream('rapor_' . $siswa->nama . '.pdf');
    }


}
