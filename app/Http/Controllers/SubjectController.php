<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index(Request $request)
    {
        // Ambil semua data mata pelajaran beserta relasinya
        $mata_pelajaran = Subject::with(['kelas', 'guru'])->get(); // pakai get() karena kamu tidak gunakan pagination di blade

        return view('mata_pelajaran.subject', compact('mata_pelajaran'));
    }

    public function create()
    {
        // Ambil semua data kelas dan guru untuk dropdown
        $kelas = Kelas::all();
        $guru = Teacher::all();

        return view('mata_pelajaran.subject_create', compact('kelas', 'guru'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'nama_mapel' => 'required|string|max:255',
            'kkm' => 'required|numeric|min:0|max:100',
            'id_kelas' => 'required|exists:kelas,id_kelas',
            'nip' => 'required|exists:guru,nip',
        ]);

        // Simpan data
        Subject::create($validated);

        return redirect()->route('mata_pelajaran.index')->with('success', 'Data mata pelajaran berhasil ditambahkan!');
    }

    public function edit($id)
    {
        // Ambil data yang akan diedit
        $mata_pelajaran = Subject::findOrFail($id);
        $kelas = Kelas::all();
        $guru = Teacher::all();

        return view('mata_pelajaran.subject_edit', compact('mata_pelajaran', 'kelas', 'guru'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $validated = $request->validate([
            'nama_mapel' => 'required|string|max:255',
            'kkm' => 'required|numeric|min:0|max:100',
            'id_kelas' => 'required|exists:kelas,id_kelas',
            'nip' => 'required|exists:guru,nip',
        ]);

        // Update data
        $mata_pelajaran = Subject::findOrFail($id);
        $mata_pelajaran->update($validated);

        return redirect()->route('mata_pelajaran.index')->with('success', 'Data mata pelajaran berhasil diperbarui!');
    }

    public function delete($id)
    {
        // Hapus data
        $mata_pelajaran = Subject::findOrFail($id);
        $mata_pelajaran->delete();

        return redirect()->route('mata_pelajaran.index')->with('success', 'Data mata pelajaran berhasil dihapus!');
    }
}
