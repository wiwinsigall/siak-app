<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index() 
    {
        $user = Auth::user();
        $profile = null;

        // Mengambil relasi siswa jika user role adalah siswa
        if ($user->role === 'siswa') {
            $profile = $user->siswa;  // Mengambil data siswa
        } elseif (in_array($user->role, ['staff', 'guru', 'kepsek', 'wali_kelas'])) {
            $profile = $user->guru;  // Untuk guru dan kepsek
        }

        // Jika profile tidak ditemukan, fallback ke data user secara default
        if (!$profile) {
            $profile = $user;  // fallback ke data user jika profil tidak ditemukan
        }

        return view('profile', compact('user', 'profile'));
    }
}



