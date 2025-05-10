<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index()
    {
        $siswa = Siswa::with(['kelas'])->get();
        return view('siswa.data_siswa', compact('siswa')); // Kirim ke view

        $siswa = $siswa->get();
    }
    
    public function tambah(Request $request)
    {
         // Ambil data untuk dropdown
         $kelas = Kelas::all();

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
                'id_kelas' => 'nullable|exists:kelas,id_kelas',
            ]);

            // Simpan data siswa ke database
            Siswa::create($validated);

            // Redirect kembali ke daftar siswa dengan pesan sukses
            return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil ditambahkan!');
        }

        // Jika request adalah GET, tampilkan form tambah siswa
        return view('siswa.tambah_siswa', compact('kelas'));
    }

    public function ubah($nis)
    {
        $siswa = Siswa::findOrFail($nis);  // Cari data siswa berdasarkan NIS
        $kelas = Kelas::all();             // Ambil semua data kelas untuk dropdown
        return view('siswa.ubah_siswa', compact('siswa', 'kelas'));
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
            'id_kelas' => 'nullable|exists:kelas,id_kelas',
        ]);

        $siswa = Siswa::findOrFail($nis);
        $siswa->update($request->all()); // Update data langsung dari form

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil diperbarui!');
    }

    public function detail($nis)
    {
        $siswa = Siswa::with('kelas')->findOrFail($nis);
        return view('siswa.detail_siswa', compact('siswa'));
    }

    public function hapus($nis)
    {
        $siswa = Siswa::findOrFail($nis);
        $siswa->delete();

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil dihapus');
    }


}

