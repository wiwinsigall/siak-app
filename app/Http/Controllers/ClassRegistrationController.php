<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\ClassRegistration;
use App\Models\Kelas;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClassRegistrationController extends Controller
{

    public function create(Request $request)
    {
        $tahun_ajaran = AcademicYear::where('status', 'aktif')->first();
        $kelas = Kelas::all();
        $daftar_jurusan = Student::select('jurusan')->distinct()->pluck('jurusan');
        $selectedJurusan = $request->query('jurusan');

        $siswa = Student::when($selectedJurusan, function ($query, $jurusan) {
                return $query->where('jurusan', $jurusan);
            })
            ->whereDoesntHave('registrasi_kelas', function ($query) use ($tahun_ajaran) {
                $query->where('id_tahun_ajaran', $tahun_ajaran->id_tahun_ajaran);
            })
            ->get();

        $wali_kelas = Teacher::where('jabatan', 'wali kelas')->get();

        return view('registrasi_kelas.registration_create', compact(
            'kelas',
            'siswa',
            'tahun_ajaran',
            'daftar_jurusan',
            'wali_kelas'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_kelas' => 'required|exists:kelas,id_kelas',
            'wali_kelas_id' => 'required|exists:guru,nip', // harus sesuai nama kolom
            'nis' => 'required|array',
            'status' => 'required|array',
        ]);

        $tahunAjaran = AcademicYear::where('status', 'aktif')->first();

        if (!$tahunAjaran) {
            return back()->with('error', 'Tahun ajaran aktif tidak ditemukan.');
        }

        foreach ($request->nis as $nis) {
            ClassRegistration::updateOrCreate(
                [
                    'nis' => $nis,
                    'id_tahun_ajaran' => $tahunAjaran->id_tahun_ajaran,
                ],
                [
                    'id_kelas' => $request->id_kelas,
                    'nip' => $request->wali_kelas_id, // disimpan ke kolom 'nip'
                    'status' => $request->status[$nis],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        return redirect()->route('kelas.index')->with('success', 'Registrasi siswa berhasil disimpan!');
    }
}
