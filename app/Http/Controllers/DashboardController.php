<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function staff()
    {
        return view('dashboard.staff', $this->getDashboardData());
    }

    public function kepsek()
    {
        return view('dashboard.kepsek', $this->getDashboardData());
    }

    // Data untuk dashboard
    private function getDashboardData()
    {
        return [
            'jumlahGuru' => Teacher::count(),
            'jumlahSiswa' => Student::count(),
            'jumlahLaki' => Student::where('jenis_kelamin', 'L')->count(),
            'jumlahPerempuan' => Student::where('jenis_kelamin', 'P')->count(),
            'siswaPerJurusan' => Student::select('jurusan', DB::raw('count(*) as total'))->groupBy('jurusan')->get(),
        ];
    }

    public function guru()
    {
        $user = Auth::user();
        $profile = Teacher::where('nip', $user->nip)->first(); // atau berdasarkan user->id jika pakai relasi

        return view('profile', compact('user', 'profile'));
    }

    public function wali_kelas()
    {
        $user = Auth::user();
        $profile = Teacher::where('nip', $user->nip)->first(); // sesuaikan struktur user

        return view('profile', compact('user', 'profile'));
    }

    public function siswa()
    {
        $user = Auth::user();
        $profile = Student::where('nis', $user->nis)->first(); // sesuaikan dengan struktur user

        return view('profile', compact('user', 'profile'));
    }

}
