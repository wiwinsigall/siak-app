<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $siswa = Student::all();
        return view('siswa.student', compact('siswa'));
    }

    public function create(Request $request)
    {
        // Jika request adalah POST, berarti user sedang menyimpan data
        if ($request->isMethod('post')) {
            $validated = $request->validate([
                'nis' => 'required|unique:siswa,nis',
                'nama' => 'required|string',
                'email' => 'nullable|email',
                'ttl' => 'nullable|string',
                'alamat' => 'nullable|string',
                'jenis_kelamin' => 'nullable|in:L,P',
                'jurusan' => 'nullable|in:AKL,DPIB,Geospasial,MPLB,PPLG,TAV,Teknik Kendaraan Ringan,Teknik Las,Teknik Mesin,Teknik Sepeda Motor,TKJT',
            ]);

            // Cek apakah sudah ada user dengan NIS yang sama
            $user = User::where('nis', $validated['nis'])->first();
            if ($user) {
                $validated['id_user'] = $user->id_user;
            }

            // Simpan data siswa ke database
            Student::create($validated);

            // Redirect kembali ke daftar siswa dengan pesan sukses
            return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil ditambahkan!');
        }
        return view('siswa.student_create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nis' => 'required|unique:siswa,nis',
            'nama' => 'required|string',
            'email' => 'nullable|email',
            'ttl' => 'nullable|string',
            'alamat' => 'nullable|string',
            'jenis_kelamin' => 'nullable|in:L,P',
            'jurusan' => 'nullable|in:AKL,DPIB,Geospasial,MPLB,PPLG,TAV,Teknik Kendaraan Ringan,Teknik Las,Teknik Mesin,Teknik Sepeda Motor,TKJT',
        ]);

        // Cek apakah sudah ada user dengan NIS yang sama
        $user = User::where('nis', $validated['nis'])->first();
        if ($user) {
            $validated['id_user'] = $user->id_user;
        }

        Student::create($validated);
        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil ditambahkan!');
    }


    public function edit($nis)
    {
        $siswa = Student::findOrFail($nis);  // Cari data siswa berdasarkan NIS
        return view('siswa.student_edit', compact('siswa'));
    }

    public function update(Request $request, $nis)
    {
        $request->validate([
            'nis' => 'required|unique:siswa,nis,' . $nis . ',nis', // NIS boleh sama dengan yang lama
            'nama' => 'required|string',
            'email' => 'nullable|email',
            'ttl' => 'nullable|string',
            'alamat' => 'nullable|string',
            'jenis_kelamin' => 'nullable|in:L,P',
            'jurusan' => 'nullable|in:AKL,DPIB,Geospasial,MPLB,PPLG,TAV,Teknik Kendaraan Ringan,Teknik Las,Teknik Mesin,Teknik Sepeda Motor,TKJT',
        ]);

        $siswa = Student::findOrFail($nis);
        $siswa->update($request->all()); // Update data langsung dari form

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil diperbarui!');
    }

    public function detail($nis)
    {
        $siswa = Student::findOrFail($nis);
        return view('siswa.student_detail', compact('siswa'));
    }

    public function delete($nis)
    {
        $siswa = Student::findOrFail($nis);
        $siswa->delete();

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil dihapus');
    }
}

