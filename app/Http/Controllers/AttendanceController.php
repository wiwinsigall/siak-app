<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\Attendance;
use App\Models\ClassRegistration;
use App\Models\Kelas;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
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

        return view('absensi.class', compact('kelas'));
    }

    public function showBySubject($id_kelas)
    {
        $user = Auth::user();

        // Validasi akses untuk guru/wali kelas
        if (in_array($user->role, ['guru', 'wali_kelas'])) {
            $allowed = Subject::where('id_kelas', $id_kelas)
                ->where('nip', $user->nip)
                ->exists();

            if (!$allowed) {
                abort(403, 'Anda tidak memiliki akses ke kelas ini.');
            }
        }

        // Ambil registrasi aktif berdasarkan kelas
        $registrasiQuery = ClassRegistration::with(['guru', 'tahun_ajaran'])
            ->where('id_kelas', $id_kelas)
            ->whereHas('tahun_ajaran', fn($q) => $q->where('status', 'Aktif'));

        if (in_array($user->role, ['guru', 'wali_kelas'])) {
            // Filter berdasarkan guru yang sedang login
            $registrasiQuery->where('nip', $user->nip);
        }

        $registrasi = $registrasiQuery->get();

        // Ambil daftar mapel
        if (in_array($user->role, ['guru', 'wali_kelas'])) {
            $mapel = Subject::where('id_kelas', $id_kelas)
                ->where('nip', $user->nip)
                ->get();

            // Jika hanya satu mapel, langsung redirect ke attendance recap
            if ($mapel->count() === 1) {
                return redirect()->route('absensi.attendanceRecap', [$id_kelas, $mapel->first()->id_mapel]);
            }

            // Jika ada banyak mapel, tampilkan view pilihan
            return view('absensi.attendance', compact('registrasi', 'mapel'));
        } else {
            // Staff melihat semua mapel
            $mapel = Subject::where('id_kelas', $id_kelas)->get();
            return view('absensi.attendance', compact('registrasi', 'mapel'));
        }
    }

    public function attendanceRecap($id_kelas, $id_mapel, Request $request)
    {
        $user = Auth::user();

        if ($user->role !== 'staff' && !Subject::where('nip', $user->nip)->where('id_kelas', $id_kelas)->where('id_mapel', $id_mapel)->exists()) {
            abort(403, 'Anda tidak berhak mengakses kelas/mapel ini.');
        }

        $kelas = Kelas::findOrFail($id_kelas);
        $tanggal = $request->input('tanggal');

        $rekap = DB::table('absensi')
            ->join('registrasi_kelas', 'absensi.id_registrasi', '=', 'registrasi_kelas.id_registrasi')
            ->join('mata_pelajaran', 'absensi.id_mapel', '=', 'mata_pelajaran.id_mapel')
            ->select(
                'absensi.tanggal',
                'mata_pelajaran.nama_mapel',
                'absensi.id_mapel',
                DB::raw("SUM(CASE WHEN absensi.keterangan = 'Hadir' THEN 1 ELSE 0 END) as jumlah_hadir"),
                DB::raw("SUM(CASE WHEN absensi.keterangan = 'Sakit' THEN 1 ELSE 0 END) as jumlah_sakit"),
                DB::raw("SUM(CASE WHEN absensi.keterangan = 'Izin' THEN 1 ELSE 0 END) as jumlah_izin"),
                DB::raw("SUM(CASE WHEN absensi.keterangan = 'Alpa' THEN 1 ELSE 0 END) as jumlah_alpa")
            )
            ->where('registrasi_kelas.id_kelas', $id_kelas)
            ->where('absensi.id_mapel', $id_mapel) // <-- BATASI DENGAN id_mapel YANG DIPILIH
            ->when($tanggal, fn($query) => $query->whereDate('absensi.tanggal', $tanggal))
            ->groupBy('absensi.tanggal', 'absensi.id_mapel', 'mata_pelajaran.nama_mapel')
            ->orderByDesc('absensi.tanggal')
            ->get();

        return view('absensi.attendance_recap', compact('rekap', 'kelas', 'tanggal'));
    }

    public function showByDate($id_kelas, $tanggal, Request $request)
    {
        $id_mapel = $request->input('id_mapel'); // Ambil dari query string
        $user = Auth::user();

        // Validasi hak akses untuk guru atau wali_kelas
        if ($user->role !== 'staff') {
            $isAuthorized = Subject::where('id_kelas', $id_kelas)
                ->where('id_mapel', $id_mapel)
                ->where('nip', $user->nip)
                ->exists();

            if (!$isAuthorized) {
                abort(403, 'Anda tidak berhak mengakses data absensi ini.');
            }
        }

        $kelas = Kelas::findOrFail($id_kelas);

        $absensiQuery = Attendance::with([
            'registrasi_kelas.kelas', 
            'siswa', 
            'mata_pelajaran.guru'
        ])
        ->whereDate('tanggal', $tanggal)
        ->where('id_mapel', $id_mapel)
        ->whereHas('registrasi_kelas', fn($q) => $q->where('id_kelas', $id_kelas));

        if ($user->role !== 'staff') {
            $absensiQuery->where('nip', $user->nip);
        }

        $absensi = $absensiQuery->get();

        $mapel = Subject::where('id_kelas', $id_kelas)->get();

        return view('absensi.attendance_detail', [
            'absensi' => $absensi,
            'kelas' => $kelas,
            'dataAbsensi' => $absensi->first(),
            'mapel' => $mapel,
            'tanggal' => $tanggal,
            'id_mapel' => $id_mapel,
        ]);
    }

    public function attendance(Request $request, $id_kelas)
    {
        $user = Auth::user();

        if ($user->role !== 'staff' && !Subject::where('nip', $user->nip)->where('id_kelas', $id_kelas)->exists()) {
            abort(403, 'Anda tidak berhak mengakses kelas ini.');
        }

        $kelas = Kelas::with('guru')->findOrFail($id_kelas);

        $absensi = Attendance::whereHas('registrasi_kelas', fn($q) => $q->where('id_kelas', $id_kelas))
            ->with([
                'siswa',
                'mata_pelajaran.guru',
                'registrasi_kelas.kelas'
            ])
            ->orderByDesc('tanggal')
            ->get();

        // Tambahkan baris ini:
        $mapel = Subject::where('id_kelas', $id_kelas)->get();

        return view('absensi.attendance', compact('kelas', 'absensi', 'user', 'mapel'));
    }

    public function create($id_kelas)
    {
        $user = Auth::user();

        if ($user->role !== 'staff' && !Subject::where('nip', $user->nip)->where('id_kelas', $id_kelas)->exists()) {
            abort(403, 'Anda tidak berhak mengakses kelas ini.');
        }

        $kelas = Kelas::findOrFail($id_kelas);

        $siswa = ClassRegistration::with('siswa')
            ->where('id_kelas', $id_kelas)
            ->whereHas('tahun_ajaran', fn($q) => $q->where('status', 'Aktif'))
            ->get();

        $mata_pelajaran = Subject::where('id_kelas', $id_kelas)
            ->when($user->role !== 'staff', fn($q) => $q->where('nip', $user->nip))
            ->get();

        return view('absensi.attendance_create', compact('kelas', 'siswa', 'mata_pelajaran'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'id_kelas' => 'required|exists:kelas,id_kelas',
            'id_mapel' => 'required|exists:mata_pelajaran,id_mapel',
            'tanggal' => 'required|date',
            'absensi' => 'required|array',
            'absensi.*' => 'required|in:Hadir,Sakit,Izin,Alpa',
        ]);

        // Ambil tahun ajaran aktif
        $tahunAjaranAktif = AcademicYear::where('status', 'Aktif')->first();
        if (!$tahunAjaranAktif) {
            return back()->with('error', 'Tahun ajaran aktif tidak ditemukan.');
        }

        // Tentukan NIP guru pengampu
        $nip = $user->role === 'staff'
            ? Subject::where('id_mapel', $data['id_mapel'])
                ->where('id_kelas', $data['id_kelas'])
                ->value('nip')
            : $user->nip;

        if (!$nip) {
            return back()->with('error', 'Guru pengampu tidak ditemukan.');
        }

        // Ambil ID registrasi dan NIS siswa aktif
        $registrasiMap = ClassRegistration::where('id_kelas', $data['id_kelas'])
            ->where('id_tahun_ajaran', $tahunAjaranAktif->id_tahun_ajaran)
            ->pluck('id_registrasi', 'nis'); // key = nis, value = id_registrasi

        // Cegah duplikasi absensi
        $sudahAda = Attendance::whereDate('tanggal', $data['tanggal'])
            ->whereIn('id_registrasi', $registrasiMap->values())
            ->where('id_mapel', $data['id_mapel'])
            ->where('nip', $nip)
            ->exists();

        if ($sudahAda) {
            return back()->with('error', 'Absensi sudah pernah dibuat untuk tanggal dan mata pelajaran ini.');
        }

        $jumlahDisimpan = 0;

        foreach ($data['absensi'] as $nis => $keterangan) {
            $id_registrasi = $registrasiMap[$nis] ?? null;

            if (!$id_registrasi) {
                // NIS tidak cocok dengan siswa aktif
                continue;
            }

            Attendance::create([
                'id_registrasi' => $id_registrasi,
                'nis' => $nis, // ✅ Perbaikan: simpan NIS agar tidak NULL
                'tanggal' => $data['tanggal'],
                'keterangan' => $keterangan,
                'id_mapel' => $data['id_mapel'],
                'nip' => $nip,
                'id_tahun_ajaran' => $tahunAjaranAktif->id_tahun_ajaran,
            ]);

            $jumlahDisimpan++;
        }

        if ($jumlahDisimpan === 0) {
            return back()->with('error', 'Tidak ada data absensi yang valid disimpan. Pastikan NIS sesuai.');
        }

        return redirect()->route('absensi.attendanceRecap', [
            'id_kelas' => $data['id_kelas'],
            'id_mapel' => $data['id_mapel'],
        ])->with('success', "Absensi berhasil disimpan untuk $jumlahDisimpan siswa.");
    }

     public function deleteByDate($id_kelas, $tanggal)
    {
         $user = Auth::user();

        // Periksa apakah role pengguna adalah guru atau wali kelas
        if (!in_array($user->role, ['guru', 'wali_kelas'])) {
                abort(403, 'Anda tidak memiliki akses untuk menghapus data ini.');
            }

        Attendance::whereHas('registrasi_kelas', fn($q) => $q->where('id_kelas', $id_kelas))
            ->whereDate('tanggal', $tanggal)
            ->delete();

        return back()->with('success', "Absensi tanggal $tanggal berhasil dihapus.");
    }

    public function edit($id_absensi)
    {
        $absensi = Attendance::with([
            'siswa',
            'mata_pelajaran',              // relasi ke mata_pelajaran
            'mata_pelajaran.guru',         // guru pengampu mapel
            'registrasi_kelas.kelas',      // kelas siswa
            'registrasi_kelas.tahun_ajaran'
        ])->findOrFail($id_absensi);

        $kelas     = optional($absensi->registrasi_kelas)->kelas;
        $tanggal   = $absensi->tanggal;
        $id_mapel  = $absensi->id_mapel;
        $user      = Auth::user();
        $nip_user  = $user->nip;

        if (!$kelas) {
            abort(404, 'Data kelas tidak ditemukan.');
        }

        // Cek apakah user ini guru pengampu mapel tsb
        $isGuruMapel = Subject::where('id_mapel', $id_mapel)
            ->where('id_kelas', $kelas->id_kelas)
            ->where('nip', $nip_user)
            ->exists();

        // Cek apakah user ini wali kelas dari kelas tersebut (via registrasi_kelas)
        $isWaliKelas = \App\Models\ClassRegistration::where('id_kelas', $kelas->id_kelas)
            ->where('nip', $nip_user)
            ->where('status', 'Aktif')
            ->whereHas('guru', function ($query) {
                $query->where('jabatan', 'wali_kelas');
            })
            ->whereHas('tahun_ajaran', function ($q) {
                $q->where('status', 'aktif');
            })
            ->exists();

        // Jika bukan guru mapel & bukan wali kelas, tolak akses
        if (!$isGuruMapel && !$isWaliKelas) {
            abort(403, 'Anda tidak berhak mengedit absensi ini.');
        }

        // mbil daftar absensi untuk tanggal & mapel yg sama di kelas tsb
        $absensi_list = Attendance::where('id_mapel', $id_mapel)
            ->whereDate('tanggal', $tanggal)
            ->whereHas('registrasi_kelas', fn($q) => $q->where('id_kelas', $kelas->id_kelas))
            ->orderBy('nis')
            ->get();

        // Ambil mapel di kelas tsb yang diajar oleh guru ini (untuk dropdown)
        $mata_pelajaran = Subject::where('id_kelas', $kelas->id_kelas)
            ->where('nip', $nip_user)
            ->get();

        // Kirim ke view
        return view('absensi.attendance_edit', compact(
            'absensi', 'kelas', 'tanggal', 'mata_pelajaran', 'id_mapel', 'absensi_list'
        ));
    }

    public function update(Request $request)
    {
        $request->validate([
            'absensi' => 'required|array',
        ]);

        $kelas_id = null;
        $tanggal = null;
        $mapel_id = null;

        foreach ($request->absensi as $id_absensi_item => $keterangan) {
            $absensi = Attendance::find($id_absensi_item);
            if ($absensi) {
                $absensi->keterangan = $keterangan;
                $absensi->save();

                // Ambil data untuk redirect hanya sekali (dari salah satu absensi)
                if (!$kelas_id) {
                    $kelas_id = optional($absensi->registrasi_kelas)->id_kelas;
                    $tanggal = $absensi->tanggal;
                    $mapel_id = $absensi->id_mapel;
                }
            }
        }

        if (!$kelas_id || !$tanggal) {
            return redirect()->route('absensi.index')->with('error', 'Data absensi tidak ditemukan.');
        }

        return redirect()->route('absensi.showByDate', [
            'id_kelas' => $kelas_id,
            'tanggal' => $tanggal,
            'id_mapel' => $mapel_id,
        ])->with('success', 'Absensi berhasil diperbarui.');
    }

   public function studentAttendance(Request $request)
    {
        $user = Auth::user();
        $siswa = Student::where('nis', $user->nis)->first();

        if (!$siswa) {
            return redirect()->route('dashboard')->with('error', 'Data siswa tidak ditemukan.');
        }

        // Ambil parameter dari URL atau default ke X dan ganjil
        $kelasSekarang = $request->get('kelas', 'X');
        $semesterSekarang = $request->get('semester', 'ganjil');

        // Ambil semua registrasi milik siswa
        $registrasi = $siswa->registrasi_kelas()->with(['kelas', 'tahun_ajaran'])->get();

        // Filter registrasi sesuai kelas dan semester aktif
        $registrasiFiltered = $registrasi->filter(function ($reg) use ($kelasSekarang, $semesterSekarang) {
            return strtolower(optional($reg->kelas)->kelas) === strtolower($kelasSekarang)
                && strtolower(optional($reg->tahun_ajaran)->semester) === strtolower($semesterSekarang)
                && strtolower(optional($reg->tahun_ajaran)->status) === 'aktif'
                && strtolower(optional($reg)->status) === 'aktif';
        });

        // Ambil data absensi berdasarkan id_registrasi
        $absensi = Attendance::with(['mata_pelajaran'])
            ->whereIn('id_registrasi', $registrasiFiltered->pluck('id_registrasi'))
            ->where('nis', $siswa->nis)
            ->get()
            ->groupBy('id_mapel');

        return view('absensi.student_attendance', [
            'absensi' => $absensi,
            'kelasAktif' => strtoupper($kelasSekarang),
            'semesterAktif' => strtolower($semesterSekarang),
        ]);
    }

    public function studentAttendanceDetail($id_mapel)
    {
        $user = Auth::user();
        $siswa = Student::where('nis', $user->nis)->first();

        if (!$siswa) {
            return redirect()->route('dashboard')->with('error', 'Data siswa tidak ditemukan.');
        }

        // Ambil data absensi untuk mapel tertentu
        $absensi = Attendance::with(['mata_pelajaran.guru'])
            ->where('nis', $siswa->nis)
            ->where('id_mapel', $id_mapel)
            ->orderByDesc('tanggal')
            ->get();

        $mapel = optional($absensi->first()->mata_pelajaran)->nama_mapel ?? '-';
        $guru = optional($absensi->first()->mata_pelajaran->guru)->nama ?? '-';

        return view('absensi.student_attendance_detail', compact('absensi', 'mapel', 'guru'));
    }

}
