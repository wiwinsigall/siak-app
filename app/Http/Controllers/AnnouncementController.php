<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AnnouncementController extends Controller
{
    public function index()
    {
        $pengumuman_akademik = Announcement::all();
        return view('pengumuman_akademik.announcement', compact('pengumuman_akademik'));
    }

    public function create()
    {
        return view('pengumuman_akademik.announcement_create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:pdf,doc,docx,png,jpg,jpeg|max:5120',
        ]);

        $file = $request->file('file');
        $filename = time() . '_' . $file->getClientOriginalName();

        // Simpan file ke storage/public/pengumuman_akademik
        $file->storeAs('pengumuman_akademik', $filename, 'public');

        Announcement::create([
            'file' => $filename,
        ]);

        return redirect()->route('pengumuman_akademik.index')->with('success', 'Pengumuman berhasil ditambahkan');
    }

    public function edit($id)
    {
        $pengumuman_akademik = Announcement::findOrFail($id);
        return view('pengumuman_akademik.announcement_edit', compact('pengumuman_akademik'));
    }

    public function update(Request $request, $id)
    {
        $pengumuman_akademik = Announcement::findOrFail($id);

        $request->validate([
            'file' => 'required|mimes:pdf,doc,docx,png,jpg,jpeg|max:5120',
        ]);

        // Hapus file lama
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

    public function delete($id)
    {
        $pengumuman_akademik = Announcement::findOrFail($id);

        if ($pengumuman_akademik->file && Storage::disk('public')->exists('pengumuman_akademik/' . $pengumuman_akademik->file)) {
            Storage::disk('public')->delete('pengumuman_akademik/' . $pengumuman_akademik->file);
        }

        $pengumuman_akademik->delete();

        return redirect()->route('pengumuman_akademik.index')->with('success', 'Pengumuman berhasil dihapus');
    }
}
