<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\Attendance;
use App\Models\ClassRegistration;
use App\Models\Score;
use App\Models\Student;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');
        $siswa = null;
        $riwayat_kelas = collect();
        $riwayat_absensi = collect();
        $riwayat_nilai = collect();

        if ($keyword) {
            $siswa = Student::where('nis', $keyword)
                ->orWhere('nama', 'like', "%$keyword%")
                ->first();

            if ($siswa) {
                $riwayat_kelas = ClassRegistration::with(['kelas', 'tahun_ajaran', 'guru'])
                    ->where('nis', $siswa->nis)
                    ->orderByDesc('id_tahun_ajaran')
                    ->get();

                $riwayat_absensi = Attendance::with(['tahun_ajaran'])
                    ->selectRaw('id_tahun_ajaran, COUNT(IF(keterangan="Sakit",1,NULL)) as sakit, COUNT(IF(keterangan="Izin",1,NULL)) as izin, COUNT(IF(keterangan="Alpa",1,NULL)) as alpa')
                    ->where('nis', $siswa->nis)
                    ->groupBy('id_tahun_ajaran')
                    ->get();

                $riwayat_nilai = Score::with(['mata_pelajaran', 'registrasi_kelas', 'registrasi_kelas.tahun_ajaran'])
                    ->where('nis', $siswa->nis)
                    ->get()
                    ->groupBy('id_registrasi');
            }
        }

        $semesters = AcademicYear::orderByDesc('id_tahun_ajaran')->get();

        return view('riwayat.history', compact('siswa', 'riwayat_kelas', 'riwayat_absensi', 'riwayat_nilai', 'semesters'));
    }
}

