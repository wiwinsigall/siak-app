<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Mata_pelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AbsensiController extends Controller
{
    // Menampilkan Daftar Kelas
    public function index()
    {
        $kelas = Kelas::all();
        return view('absensi.daftar_kelas', compact('kelas'));
    }

    public function rekapAbsensi($id_kelas, Request $request)
    {
        $kelas = Kelas::findOrFail($id_kelas);
        $tanggal = $request->input('tanggal');

        $rekap = DB::table('absensi')
            ->select('tanggal',
                DB::raw("SUM(CASE WHEN keterangan = 'Hadir' THEN 1 ELSE 0 END) as jumlah_hadir"),
                DB::raw("SUM(CASE WHEN keterangan = 'Sakit' THEN 1 ELSE 0 END) as jumlah_sakit"),
                DB::raw("SUM(CASE WHEN keterangan = 'Izin' THEN 1 ELSE 0 END) as jumlah_izin"),
                DB::raw("SUM(CASE WHEN keterangan = 'Alpa' THEN 1 ELSE 0 END) as jumlah_alpa")
            )
            ->where('id_kelas', $id_kelas)
            ->when($tanggal, fn($query) => $query->whereDate('tanggal', $tanggal))
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'DESC')
            ->get();

        return view('absensi.rekap_absensi', compact('rekap', 'kelas', 'tanggal'));
    }

    // Menampilkan absensi per kelas + filter tanggal
    public function lihatAbsensi(Request $request, $id_kelas)
    {
        $kelas = Kelas::findOrFail($id_kelas);
        // Cek filter tanggal
        $tanggal = $request->input('tanggal');
        $query = Absensi::where('id_kelas', $id_kelas);

        if ($tanggal) {
            $query->whereDate('tanggal', $tanggal);
        }

        $absensi = $query->with('siswa')->orderBy('tanggal', 'desc')->get();
        return view('absensi.lihat_absensi', compact('kelas', 'absensi', 'tanggal'));
    }

    public function lihatAbsensiTanggal(Request $request, $id_kelas, $tanggal)
    {
        // Ambil data kelas berdasarkan ID, jika tidak ditemukan maka akan error 404
        $kelas = Kelas::findOrFail($id_kelas);

        // Ambil kata kunci pencarian dari query string (?q=...)
        $keyword = $request->input('q');

        // Inisialisasi query absensi berdasarkan id_kelas dan tanggal
        $query = Absensi::where('id_kelas', $id_kelas)
                    ->whereDate('tanggal', $tanggal)
                    ->with(['siswa', 'mata_pelajaran', 'kelas']); // Eager load relasi untuk menghindari N+1 problem

        // Jika ada keyword pencarian, tambahkan filter berdasarkan nama siswa atau nama mapel
        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->whereHas('siswa', function ($q2) use ($keyword) {
                    $q2->where('nama', 'like', "%$keyword%"); // Filter nama siswa
                })->orWhereHas('mata_pelajaran', function ($q3) use ($keyword) {
                    $q3->where('nama_mapel', 'like', "%$keyword%"); // Filter nama mata pelajaran
                });
            });
        }

        // Eksekusi query dan urutkan hasil berdasarkan tanggal terbaru
        $absensi = $query->orderBy('tanggal', 'desc')->get();

        // Kirim data ke view: data absensi, kelas, tanggal, dan keyword pencarian
        return view('absensi.lihat_absensi', compact('kelas', 'absensi', 'tanggal', 'keyword'));
    }


    // Menampilkan Form tambah absensi (khusus kelas tertentu)
    public function tambah($id_kelas)
    {
        $kelas = Kelas::findOrFail($id_kelas);
        $siswa = Siswa::where('id_kelas', $id_kelas)->get();
        $mata_pelajaran = Mata_pelajaran::all();
        
        return view('absensi.tambah_absensi', compact('kelas', 'siswa', 'mata_pelajaran'));
    }

    public function simpan(Request $request)
    {
        $data = $request->validate([
            'tanggal' => 'required|date',
            'id_kelas' => 'required|exists:kelas,id_kelas',
            'id_mapel' => 'required|exists:mata_pelajaran,id_mapel',
            'absensi' => 'required|array',
        ]);

        // Cek apakah sudah ada absensi untuk tanggal dan mapel ini
        $sudahAda = Absensi::whereDate('tanggal', $data['tanggal'])
            ->where('id_kelas', $data['id_kelas'])
            ->where('id_mapel', $data['id_mapel'])
            ->exists();

        if ($sudahAda) {
            return redirect()->back()->with('error', 'Data absensi untuk tanggal dan mata pelajaran ini sudah ada.');
        }

        foreach ($data['absensi'] as $nis => $keterangan) {
            Absensi::create([
                'nis' => $nis,
                'tanggal' => $data['tanggal'],
                'keterangan' => $keterangan,
                'id_kelas' => $data['id_kelas'],
                'id_mapel' => $data['id_mapel'],
            ]);
        }

        return redirect()->route('absensi.lihatAbsensi', $data['id_kelas'])->with('success', 'Absensi berhasil disimpan.');
    }

}


