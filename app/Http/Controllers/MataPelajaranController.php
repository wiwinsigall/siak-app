<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Mata_pelajaran;
use Illuminate\Http\Request;

class MataPelajaranController extends Controller
{
    public function index()
    {
        $mata_pelajaran = Mata_pelajaran::all();
        return view('mata_pelajaran.data_mata_pelajaran', compact('mata_pelajaran'));
    }

    public function tambah(Request $request)
    {
        // Ambil data untuk dropdown
        $mata_pelajaran = Mata_pelajaran::all();

        // Jika request adalah POST, berarti user sedang menyimpan data
        if ($request->isMethod('post')) {
            $validated = $request->validate([
                'nama_mapel' => 'required|string',
            ]);

            // Simpan data mapel ke database
            Mata_pelajaran::create($validated);

            // Redirect kembali ke halaman mapel dengan pesan sukses
            return redirect()->route('mata_pelajaran.index')->with('success', 'Data mata pelajaran berhasil ditambahkan!');
        }

        // Jika request adalah GET, tampilkan form tambah mapel
        return view('mata_pelajaran.tambah_mata_pelajaran', compact('mata_pelajaran'));
    }

    public function ubah($id)
    {
        $mata_pelajaran = Mata_pelajaran::findOrFail($id);
        return view('mata_pelajaran.ubah_mata_pelajaran', compact('mata_pelajaran'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_mapel' => 'required|string|max:255',
        ]);

        $mata_pelajaran = Mata_pelajaran::findOrFail($id);
        $mata_pelajaran->update($validated);

        return redirect()->route('mata_pelajaran.index')->with('success', 'Data mata pelajaran berhasil diperbarui!');
    }

    public function hapus($id)
    {
        $mata_pelajaran = Mata_pelajaran::findOrFail($id);
        $mata_pelajaran->delete();

        return redirect()->route('mata_pelajaran.index')->with('success', 'Data mata pelajaran berhasil dihapus');
    }

}
