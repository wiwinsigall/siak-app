<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Mata_pelajaran;
use App\Models\Staff;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    public function index(Request $request)
    {
        $guru = Guru::with(['mata_pelajaran']);

        // Pencarian berdasarkan Nama atau NIP
        if ($request->has('search') && $request->search != '') {
            $guru->where(function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                    ->orWhere('nip', 'like', '%' . $request->search . '%');
            });
        }

        // Filter Jabatan
        if ($request->has('jabatan') && $request->jabatan != '') {
            $guru->where('jabatan', $request->jabatan);
        }

        // Filter Mata Pelajaran
        if ($request->has('mata_pelajaran') && $request->mata_pelajaran != '') {
            $guru->whereHas('mata_pelajaran', function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->mata_pelajaran . '%');
            });
        }

        // Filter Jenis Kelamin
        if ($request->has('jenis_kelamin') && $request->jenis_kelamin != '') {
            $guru->where('jenis_kelamin', $request->jenis_kelamin);
        }

        $guru = $guru->get();

        return view('guru.data_guru', compact('guru'));
    }

    public function tambah(Request $request)
    {
        // Ambil data untuk dropdown
        $mata_pelajaran = Mata_pelajaran::all();
        $staff = Staff::all();

        // Jika request adalah POST, berarti user sedang menyimpan data
        if ($request->isMethod('post')) {
            $validated = $request->validate([
                'nip' => 'required|unique:guru,nip',
                'nama' => 'required|string',
                'email' => 'nullable|email',
                'ttl' => 'nullable|string',
                'alamat' => 'nullable|string',
                'jenis_kelamin' => 'nullable|in:L,P',
                'jabatan' => 'nullable|string',
                'golongan' => 'nullable|string',
                'id_mapel' => 'nullable|exists:mata_pelajaran,id_mapel',
            ]);

            // Simpan data guru ke database
            Guru::create($validated);

            // Redirect kembali ke daftar guru dengan pesan sukses
            return redirect()->route('guru.index')->with('success', 'Data guru berhasil ditambahkan!');
        }

        // Jika request adalah GET, tampilkan form tambah guru
        return view('guru.tambah_guru', compact('mata_pelajaran'));
    }

    public function ubah($nip)
    {
        $guru = Guru::findOrFail($nip);
        $mata_pelajaran = Mata_pelajaran::all();
        return view('guru.ubah_guru', compact('guru', 'mata_pelajaran'));
    }

    public function update(Request $request, $nip)
    {
        $request->validate([
            'nip' => 'required|unique:guru,nip,' . $nip . ',nip', // pengecualian untuk NIP milik guru yang sedang diedit
            'nama' => 'required|string',
            'email' => 'nullable|email',
            'ttl' => 'nullable|string',
            'alamat' => 'nullable|string',
            'jenis_kelamin' => 'nullable|in:L,P',
            'jabatan' => 'nullable|string',
            'golongan' => 'nullable|string',
            'id_mapel' => 'nullable|exists:mata_pelajaran,id_mapel',
        ]);

        $guru = Guru::findOrFail($nip);
        $guru->update($request->all());

        return redirect()->route('guru.index')->with('success', 'Data guru berhasil diperbarui');
    }

    public function detail($nip)
    {
        $guru = Guru::with('mata_pelajaran')->findOrFail($nip);
        return view('guru.detail_guru', compact('guru'));
    }

    public function hapus($nip)
    {
        $guru = Guru::findOrFail($nip);
        $guru->delete();

        return redirect()->route('guru.index')->with('success', 'Data guru berhasil dihapus');
    }

}
