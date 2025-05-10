<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function staff()
    {
        return view('dashboard.staff');
    }

    public function guru()
    {
        return view('dashboard.guru');
    }

    public function siswa()
    {
        return view('dashboard.siswa');
    }

    public function wali_kelas()
    {
        return view('dashboard.wali_kelas');
    }

    public function kepsek()
    {
        return view('dashboard.kepsek');
    }
}
