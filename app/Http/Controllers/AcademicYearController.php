<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use Illuminate\Http\Request;

class AcademicYearController extends Controller
{
    public function index()
    {
        $tahunAjaran = AcademicYear::query()
            /* status Aktif ditempatkan paling atas */
            ->orderByRaw("status = 'Aktif' DESC")

            /* baris-baris Nonaktif diurut ASCENDING berdasarkan tahun_ajaran (2024/2025 lebih dulu daripada 2025/2026, dsb.)                     */
            ->orderBy('tahun_ajaran', 'asc')
            ->get();

        return view('tahun_ajaran.academic_year', compact('tahunAjaran'));
    }

    public function create() {
        $currentMonth = date('n'); // 1 sampai 12
        $currentYear = date('Y');

        // Jika bulan sekarang sebelum Juli, mulai dari tahun sebelumnya (misal Januari-Juni = 2024, jadi mulai dari 2023/2024)
        if ($currentMonth < 7) {
            $startYear = $currentYear - 1;
        } else {
            $startYear = $currentYear;
        }

        $years = [];
        for ($i = 0; $i < 5; $i++) {
            $tahunMulai = $startYear + $i;
            $tahunSelesai = $tahunMulai + 1;
            $years[] = "$tahunMulai/$tahunSelesai";
        }

        return view('tahun_ajaran.academic_create', compact('years'));
    }

    public function store(Request $request) {
        $request->validate([
            'tahun_ajaran' => 'required|string|max:20',
            'semester' => 'required|in:Ganjil,Genap',
        ]);

        AcademicYear::create([
            'tahun_ajaran' => $request->tahun_ajaran,
            'semester' => $request->semester,
            'status' => 'Nonaktif', // default status
        ]);

        return redirect()->route('tahun_ajaran.index')->with('success', 'Tahun ajaran berhasil ditambahkan.');
    }

    public function activate($id) {
        AcademicYear::query()->update(['status' => 'Nonaktif']);
        AcademicYear::where('id_tahun_ajaran', $id)->update(['status' => 'Aktif']);

        return back()->with('success', 'Tahun ajaran berhasil diaktifkan.');
    }

    public function edit($id)
    {
        $tahunAjaran = AcademicYear::findOrFail($id);
        return view('tahun_ajaran.academic_edit', compact('tahunAjaran'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tahun_ajaran' => 'required|string|max:20',
            'semester' => 'required|in:Ganjil,Genap',
        ]);

        $tahunAjaran = AcademicYear::findOrFail($id);
        $tahunAjaran->update([
            'tahun_ajaran' => $request->tahun_ajaran,
            'semester' => $request->semester,
        ]);

        return redirect()->route('tahun_ajaran.index')->with('success', 'Tahun ajaran berhasil diperbarui.');
    }

    public function delete($id)
    {
        $tahunAjaran = AcademicYear::findOrFail($id);
        $tahunAjaran->delete();

        return redirect()->route('tahun_ajaran.index')->with('success', 'Tahun ajaran berhasil dihapus.');
    }
}
