<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman_akademik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengumumanAkademikController extends Controller
{
    public function index()
    {
        $pengumuman_akademik = Pengumuman_akademik::all(); // Ambil semua data pengumuman akademik dari database
        return view('pengumuman_akademik.data_pengumuman_akademik', compact('pengumuman_akademik'));
    }

    public function tambah(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'file' => 'required|mimes:pdf,doc,docx,png,jpg,jpeg|max:5120',
            ]);
    
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
    
            // Simpan ke storage/app/public/pengumuman_akademik
            $file->storeAs('pengumuman_akademik', $filename, 'public');
    
            Pengumuman_akademik::create([
                'file' => $filename,
            ]);
    
            return redirect()->route('pengumuman_akademik.index')->with('success', 'Pengumuman berhasil ditambahkan');
        }
    
        return view('pengumuman_akademik.tambah_pengumuman_akademik');
    }

    public function ubah($id)
    {
        $pengumuman_akademik = Pengumuman_akademik::findOrFail($id);
        return view('pengumuman_akademik.ubah_pengumuman_akademik', compact('pengumuman_akademik'));
    }

    public function update(Request $request, $id)
    {
        $pengumuman_akademik = Pengumuman_akademik::findOrFail($id);

        $request->validate([
            'file' => 'required|mimes:pdf,doc,docx,png,jpg,jpeg|max:5120',
        ]);

        // Hapus file lama jika ada
        if ($pengumuman_akademik->file && Storage::disk('public')->exists('pengumuman_akademik/' . $pengumuman_akademik->file)) {
            Storage::disk('public')->delete('pengumuman_akademik/' . $pengumuman_akademik->file);
        }

        $file = $request->file('file');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('pengumuman_akademik', $filename, 'public');

        $pengumuman_akademik->update([
            'file' => $filename,
        ]);

        return redirect()->route('pengumuman_akademik.index')->with('success', 'Pengumuman berhasil diperbarui');
    }

    public function hapus($id)
    {
        $pengumuman_akademik = Pengumuman_akademik::findOrFail($id);

        if ($pengumuman_akademik->file && Storage::disk('public')->exists('pengumuman_akademik/' . $pengumuman_akademik->file)) {
            Storage::disk('public')->delete('pengumuman_akademik/' . $pengumuman_akademik->file);
        }

        $pengumuman_akademik->delete();

        return redirect()->route('pengumuman_akademik.index')->with('success', 'Pengumuman berhasil dihapus');
    }
       
}
