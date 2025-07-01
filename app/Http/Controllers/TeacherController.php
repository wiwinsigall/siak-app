<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index(Request $request)
    {
        $guru = Teacher::query();
        $guru = $guru->get();

        return view('guru.teacher', compact('guru'));
    }

    public function create()
    {
        return view('guru.teacher_create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nip' => 'required|unique:guru,nip',
            'nama' => 'required|string',
            'email' => 'nullable|email',
            'ttl' => 'nullable|string',
            'alamat' => 'nullable|string',
            'jenis_kelamin' => 'nullable|in:L,P',
            'jabatan' => 'nullable|in:Kepala Sekolah,Guru,Staff,Wali Kelas',
            'no_hp' => 'nullable|string',
        ]);

        // Cari user dengan NIP yang sama (jika sudah ada)
        $user = User::where('nip', $validated['nip'])->first();
        if ($user) {
            $validated['id_user'] = $user->id_user;
        }

        Teacher::create($validated);

        return redirect()->route('guru.index')->with('success', 'Data guru berhasil ditambahkan!');
    }

    public function edit($nip)
    {
        $guru = Teacher::findOrFail($nip);
        return view('guru.teacher_edit', compact('guru'));
    }

    public function update(Request $request, $nip)
    {
        $request->validate([
            'nip' => 'required|unique:guru,nip,' . $nip . ',nip',
            'nama' => 'required|string',
            'email' => 'nullable|email',
            'ttl' => 'nullable|string',
            'alamat' => 'nullable|string',
            'jenis_kelamin' => 'nullable|in:L,P',
            'jabatan' => 'nullable|in:Kepala Sekolah,Guru,Staff,Wali Kelas',
            'no_hp' => 'nullable|string',
        ]);

        $guru = Teacher::findOrFail($nip);
        $guru->update($request->except(['nip'])); // Kalau mau NIP bisa juga diupdate, tapi biasanya primary key tidak diubah

        return redirect()->route('guru.index')->with('success', 'Data guru berhasil diperbarui');
    }

    public function detail($nip)
    {
        $guru = Teacher::findOrFail($nip);

        return view('guru.teacher_detail', compact('guru'));
    }

    public function delete($nip)
    {
        $guru = Teacher::findOrFail($nip);
        $guru->delete();

        return redirect()->route('guru.index')->with('success', 'Data guru berhasil dihapus');
    }
}
