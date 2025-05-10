<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::all(); // Ambil semua data kelas dari database
        return view('kelas.data_kelas', compact('kelas')); // Kirim ke view
    }
    
    public function tambah(Request $request)
    {
        // Ambil data untuk dropdown
        $kelas = Kelas::all();

        // Jika request adalah POST, berarti user sedang menyimpan data
        if ($request->isMethod('post')) {
            $validated = $request->validate([
                'nama_kelas' => 'required|string',
                'semester' => 'required|string',
                'tahun_ajaran' => 'required|string',
            ]);

            // Simpan data kelas ke database
            Kelas::create($validated);

            // Redirect kembali ke halaman kelas dengan pesan sukses
            return redirect()->route('kelas.index')->with('success', 'Data kelas berhasil ditambahkan!');
        }

        // Jika request adalah GET, tampilkan form tambah kelas
        return view('kelas.tambah_kelas', compact('kelas'));
    }

    public function ubah($id)
    {
        $kelas = Kelas::findOrFail($id);
        return view('kelas.ubah_kelas', compact('kelas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kelas' => 'required',
            'semester' => 'required',
            'tahun_ajaran' => 'required',
        ]);

        $kelas = Kelas::findOrFail($id);
        $kelas->update($request->all());

        return redirect()->route('kelas.index')->with('success', 'Data kelas berhasil diperbarui.');
    }

    public function hapus($id)
    {
        $kelas = Kelas::findOrFail($id);
        $kelas->delete();

        return redirect()->route('kelas.index')->with('success', 'Data kelas berhasil dihapus');
    }

}
