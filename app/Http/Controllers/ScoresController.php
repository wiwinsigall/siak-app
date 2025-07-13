<?php

namespace App\Http\Controllers;

use App\Models\ClassRegistration;
use App\Models\Kelas;
use App\Models\Score;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScoresController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $kelas = collect();

        if ($user->role === 'staff') {
            $kelas = Kelas::with(['guru', 'siswa', 'registrasi_kelas.tahun_ajaran'])->get();
        } elseif (in_array($user->role, ['guru', 'wali_kelas'])) {
            $kelas_ids = Subject::where('nip', $user->nip)->pluck('id_kelas')->unique();
            $kelas = Kelas::with(['guru', 'siswa', 'registrasi_kelas.tahun_ajaran'])
                        ->whereIn('id_kelas', $kelas_ids)
                        ->get();
        }

        foreach ($kelas as $k) {
            $aktifReg = $k->registrasi_kelas->first(fn($reg) => optional($reg->tahun_ajaran)->status === 'Aktif');
            $k->tahun_ajaran_aktif = $aktifReg?->tahun_ajaran;
            $k->wali_kelas = $aktifReg?->guru?->nama;
            $k->jumlah_siswa_aktif = $aktifReg
                ? ClassRegistration::where('id_kelas', $k->id_kelas)->where('id_tahun_ajaran', $aktifReg->id_tahun_ajaran)->count()
                : 0;
        }

        return view('nilai.class', compact('kelas'));
    }

    public function showBySubject($id_kelas)
    {
        $user = Auth::user();

        if (in_array($user->role, ['guru', 'wali_kelas'])) {
            $allowed = Subject::where('id_kelas', $id_kelas)
                ->where('nip', $user->nip)
                ->exists();

            if (!$allowed) {
                abort(403, 'Anda tidak memiliki akses ke kelas ini.');
            }
        }

        $kelas = Kelas::findOrFail($id_kelas);

        $mapel = Subject::with('guru')
            ->where('id_kelas', $id_kelas)
            ->when(in_array($user->role, ['guru', 'wali_kelas']), function ($q) use ($user) {
                $q->where('nip', $user->nip);
            })
            ->get();

        if ($mapel->count() === 1) {
            return redirect()->route('nilai.scores', [$id_kelas, $mapel->first()->id_mapel]);
        }

        return view('nilai.scores', [
            'kelas' => $kelas,
            'mapel' => $mapel,
        ]);
    }

    public function scoresRecap($id_kelas, Request $request)
    {
        $user = Auth::user();

        if (in_array($user->role, ['guru', 'wali_kelas'])) {
            $allowed = Subject::where('id_kelas', $id_kelas)
                ->where('nip', $user->nip)
                ->exists();

            if (!$allowed) {
                abort(403, 'Anda tidak berhak mengakses kelas ini.');
            }
        }

        $kelas = Kelas::findOrFail($id_kelas);

        $mata_pelajaran = Subject::where('id_kelas', $id_kelas)
            ->when(in_array($user->role, ['guru', 'wali_kelas']), fn($q) => $q->where('nip', $user->nip))
            ->get();

        $rekap = Score::whereIn('id_registrasi', function ($query) use ($id_kelas) {
            $query->select('id_registrasi')
                ->from('registrasi_kelas')
                ->where('id_kelas', $id_kelas)
                ->whereHas('tahun_ajaran', fn($q) => $q->where('status', 'Aktif'));
        })
        ->when(in_array($user->role, ['guru', 'wali_kelas']), fn($q) => $q->whereIn('id_mapel', $mata_pelajaran->pluck('id_mapel')))
        ->select('id_mapel')
        ->distinct()
        ->with('mata_pelajaran')
        ->get()
        ->map(fn($item) => (object)[
            'mata_pelajaran' => $item->mata_pelajaran->nama_mapel,
        ]);

        return view('nilai.scores_recap', compact('kelas', 'mata_pelajaran', 'rekap'));
    }

    public function create($id_kelas, $id_mapel)
    {
        $user = Auth::user();

        $kelas = Kelas::findOrFail($id_kelas);

        // Ambil siswa dari tabel registrasi_kelas yang memiliki id_kelas sesuai
        $siswa = Student::whereIn('nis', function ($query) use ($id_kelas) {
            $query->select('nis')
                ->from('registrasi_kelas')
                ->where('id_kelas', $id_kelas);
        })->get();

        $mata_pelajaran = Subject::where('id_mapel', $id_mapel)->firstOrFail();

        // Validasi akses guru
        if ($user->role !== 'staff' && $mata_pelajaran->nip !== $user->nip) {
            abort(403, 'Anda tidak berhak mengakses mapel ini.');
        }

        return view('nilai.scores_create', compact('kelas', 'siswa', 'mata_pelajaran'));
    }

    public function store(Request $request, $id_kelas)
    {
        $request->validate([
            'id_mapel'      => 'required|exists:mata_pelajaran,id_mapel',
            'nis.*'         => 'required|exists:siswa,nis',
            'nilai_tugas.*' => 'required|numeric|min:0|max:100',
            'nilai_uts.*'   => 'required|numeric|min:0|max:100',
            'nilai_uas.*'   => 'required|numeric|min:0|max:100',
            'des_laporan.*' => 'nullable|string|max:1000',
        ]);

        $user = Auth::user();

        // Validasi hak akses guru (non-staff)
        if ($user->role !== 'staff') {
            $cek = Subject::where('nip', $user->nip)
                ->where('id_kelas', $id_kelas)
                ->where('id_mapel', $request->id_mapel)
                ->exists();

            if (!$cek) {
                abort(403, 'Anda tidak memiliki hak input nilai untuk mapel ini.');
            }

            $nip_input = $user->nip;
        } else {
            // Staff: Ambil NIP dari data mapel
            $subject = Subject::where('id_kelas', $id_kelas)
                ->where('id_mapel', $request->id_mapel)
                ->first();

            $nip_input = $subject?->nip;

            if (!$nip_input) {
                return back()->with('error', 'Tidak ditemukan guru pengampu untuk mapel ini.');
            }
        }

        foreach ($request->nis as $index => $nis) {
            $nilai_tugas = $request->nilai_tugas[$index];
            $nilai_uts   = $request->nilai_uts[$index];
            $nilai_uas   = $request->nilai_uas[$index];
            $nilai_akhir = round(($nilai_tugas + $nilai_uts + $nilai_uas) / 3, 2);
            $des_laporan = $request->des_laporan[$index] ?? null;

            // Ambil id_registrasi dari registrasi_kelas
            $id_registrasi = ClassRegistration::where('nis', $nis)
                ->where('id_kelas', $id_kelas)
                ->whereHas('tahun_ajaran', fn($q) => $q->where('status', 'Aktif'))
                ->value('id_registrasi');

            if (!$id_registrasi) continue; // skip jika tidak ditemukan

            Score::updateOrCreate(
                [
                    'id_registrasi' => $id_registrasi,
                    'id_mapel'      => $request->id_mapel,
                ],
                [
                    'nilai_tugas' => $nilai_tugas,
                    'nilai_uts'   => $nilai_uts,
                    'nilai_uas'   => $nilai_uas,
                    'nilai_akhir' => $nilai_akhir,
                    'nip'         => $nip_input,
                    'nis'         => $nis,
                    'des_laporan' => $des_laporan,
                ]
            );
        }

        return redirect()->route('nilai.index')->with('success', 'Nilai berhasil disimpan.');
    }

    public function scores($id_kelas, $id_mapel)
    {
        $user = Auth::user();

        // Validasi akses guru
        if ($user->role !== 'staff') {
            $allowed = Subject::where('id_kelas', $id_kelas)
                ->where('id_mapel', $id_mapel)
                ->where('nip', $user->nip)
                ->exists();

            if (!$allowed) {
                abort(403, 'Anda tidak memiliki akses ke mata pelajaran ini.');
            }
        }

        $kelas = Kelas::findOrFail($id_kelas);
        $mata_pelajaran = Subject::findOrFail($id_mapel);

        $id_registrasi_siswa = ClassRegistration::where('id_kelas', $id_kelas)
            ->whereHas('tahun_ajaran', fn($q) => $q->where('status', 'Aktif'))
            ->pluck('id_registrasi');

        $nilai = Score::with('siswa')
            ->whereIn('id_registrasi', $id_registrasi_siswa)
            ->where('id_mapel', $id_mapel)
            ->get();

        if ($nilai->isEmpty()) {
            // Jika belum ada nilai, arahkan ke form input
            return redirect()->route('nilai.create', [$id_kelas, $id_mapel]);
        }

        // Jika sudah ada nilai, tampilkan rekap
        return view('nilai.scores_recap', compact('kelas', 'mata_pelajaran', 'nilai'));
    }

    public function edit($id_registrasi, $id_mapel)
    {
        $score = Score::where('id_registrasi', $id_registrasi)
            ->where('id_mapel', $id_mapel)
            ->firstOrFail();

        $user = Auth::user();

        // Ambil data tambahan
        $kelas = $score->registrasi_kelas->kelas;
        $nip_user = $user->nip;

        // Validasi akses edit hanya guru/wali yang mengajar mapel tsb
        $isGuruPengampu = Subject::where('id_mapel', $id_mapel)
            ->where('id_kelas', $kelas->id_kelas)
            ->where('nip', $nip_user)
            ->exists();

        if ($user->role !== 'staff' && !$isGuruPengampu) {
            abort(403, 'Anda tidak berhak mengedit nilai ini.');
        }

        $mapel = Subject::findOrFail($id_mapel);
        $nis = $score->nis;

        return view('nilai.scores_edit', compact('score', 'kelas', 'mapel', 'nis'));
    }

    public function update(Request $request, $id_registrasi, $id_mapel)
    {
        $request->validate([
            'nilai_tugas' => 'required|numeric|min:0|max:100',
            'nilai_uts'   => 'required|numeric|min:0|max:100',
            'nilai_uas'   => 'required|numeric|min:0|max:100',
            'des_laporan' => 'nullable|string|max:1000',
        ]);

        $user = Auth::user();

        $score = Score::where('id_registrasi', $id_registrasi)
            ->where('id_mapel', $id_mapel)
            ->first();

        if (!$score) {
            return back()->with('error', 'Data nilai tidak ditemukan.');
        }

        $nilai_akhir = round(($request->nilai_tugas + $request->nilai_uts + $request->nilai_uas) / 3, 2);

        // Tentukan nip yang akan disimpan
        $nip_input = $user->role === 'staff'
            ? ($score->nip ?? Subject::where('id_mapel', $id_mapel)->value('nip'))
            : $user->nip;

        if (!$nip_input) {
            return back()->with('error', 'NIP guru tidak ditemukan untuk mapel ini.');
        }

        $score->update([
            'nilai_tugas' => $request->nilai_tugas,
            'nilai_uts'   => $request->nilai_uts,
            'nilai_uas'   => $request->nilai_uas,
            'nilai_akhir' => $nilai_akhir,
            'nip'         => $nip_input,
            'des_laporan' => $request->des_laporan,
        ]);

        $id_kelas = $score->registrasi_kelas->id_kelas;

        return redirect()->route('nilai.scores', [$id_kelas, $id_mapel])
            ->with('success', 'Nilai berhasil diperbarui.');
    }

    public function studentScores(Request $request)
    {
        $user = Auth::user();
        $siswa = Student::where('nis', $user->nis)->first();

        if (!$siswa) {
            return back()->with('error', 'Data siswa tidak ditemukan.');
        }

        // Ambil parameter dari URL jika disediakan
        $kelasFilter = $request->get('kelas');
        $semesterFilter = $request->get('semester');

        // Ambil semua registrasi milik siswa (tanpa filter tahun ajaran aktif)
        $registrasi = $siswa->registrasi_kelas()->with(['kelas', 'tahun_ajaran'])->get();

        // Opsional: filter berdasarkan kelas & semester jika ada input
        if ($kelasFilter || $semesterFilter) {
            $registrasi = $registrasi->filter(function ($reg) use ($kelasFilter, $semesterFilter) {
                $kelasMatch = $kelasFilter
                    ? strtolower(optional($reg->kelas)->kelas) === strtolower($kelasFilter)
                    : true;

                $semesterMatch = $semesterFilter
                    ? strtolower(optional($reg->tahun_ajaran)->semester) === strtolower($semesterFilter)
                    : true;

                return $kelasMatch && $semesterMatch;
            });
        }

        // Ambil nilai berdasarkan semua id_registrasi hasil filter (atau semua jika tanpa filter)
        $nilai = Score::with(['mata_pelajaran', 'registrasi_kelas.kelas', 'registrasi_kelas.tahun_ajaran'])
            ->where('nis', $siswa->nis)
            ->whereIn('id_registrasi', $registrasi->pluck('id_registrasi')->toArray())
            ->get();

        return view('nilai.student_scores', [
            'nilai' => $nilai,
            'kelasAktif' => $kelasFilter,
            'semesterAktif' => $semesterFilter,
        ]);
    }


}
