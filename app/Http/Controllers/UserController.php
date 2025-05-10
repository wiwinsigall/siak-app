<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function login()
    {
        $data['title'] = 'Login';
        return view('auth.login', $data);
    }

    public function login_action(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate(); // Regenerasi session

            $user = Auth::user(); // Ambil user yang login

            // Tambahkan debug
            Log::info('User Login:', ['id' => $user->id, 'role' => $user->role]);

            // Redirect otomatis berdasarkan role
            switch ($user->role) {
                case 'staff':
                    return redirect()->route('dashboard.staff');
                case 'guru':
                    return redirect()->route('dashboard.guru');
                case 'siswa':
                    return redirect()->route('dashboard.siswa');
                case 'wali_kelas':
                    return redirect()->route('dashboard.wali_kelas');
                case 'kepsek':
                    return redirect()->route('dashboard.kepsek');
                default:
                    return redirect()->route('login')->with('error', 'Role tidak dikenali.');
            }
        }

        return back()->with('error', 'Email atau password salah.');
    }
        

    public function register()
    {

        $data['title'] = 'Register';
        return view('auth.register', $data); 
    }

    public function register_action(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:user,email',
            'password' => 'required',
            'password_confirmation' => 'required|same:password',
            'role' => 'required|in:staff,guru,wali_kelas,siswa,kepsek',
        ]);

       $user = new User([
        'nama' => $request->nama,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => $request->role,
        ]);

        $user->save();

        return redirect()->route('login')->with('success', "Registration
        Success, Please Login");
    }

    public function logout(Request $request)
    {
        Auth::logout(); // Logout user
    
        $request->session()->invalidate(); // Hapus semua session
        $request->session()->regenerateToken(); // Regenerasi token CSRF
    
        return redirect()->route('login')->with('success', 'Logout berhasil.');
    }
    

}
