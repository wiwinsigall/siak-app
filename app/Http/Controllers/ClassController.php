<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClassController extends Controller
{
    public function index()
    {
        $kelas = DB::table('kelas')
            ->leftJoin('registrasi_kelas', function($join) {
                $join->on('kelas.id_kelas', '=', 'registrasi_kelas.id_kelas')
                    ->where('registrasi_kelas.status', 'aktif');
            })
            ->leftJoin('tahun_ajaran', 'registrasi_kelas.id_tahun_ajaran', '=', 'tahun_ajaran.id_tahun_ajaran')
            ->leftJoin('guru', 'registrasi_kelas.nip', '=', 'guru.nip')
            ->select(
                'kelas.id_kelas',
                DB::raw("CONCAT(kelas.kelas, ' ', kelas.jurusan) as nama_kelas"),
                'tahun_ajaran.tahun_ajaran',
                'tahun_ajaran.semester',
                'guru.nama as wali_kelas'
            )
            ->groupBy('kelas.id_kelas', 'kelas.kelas', 'kelas.jurusan', 'tahun_ajaran.tahun_ajaran', 'tahun_ajaran.semester', 'guru.nama')
            ->get();

        return view('kelas.class', compact('kelas'));
    }

    public function detail($id_kelas)
    {
        $kelas = DB::table('kelas')
            ->leftJoin('registrasi_kelas', function($join) {
                $join->on('kelas.id_kelas', '=', 'registrasi_kelas.id_kelas')
                    ->where('registrasi_kelas.status', 'aktif'); // tambahkan ini
            })
            ->leftJoin('tahun_ajaran', 'registrasi_kelas.id_tahun_ajaran', '=', 'tahun_ajaran.id_tahun_ajaran')
            ->leftJoin('guru', 'registrasi_kelas.nip', '=', 'guru.nip')
            ->select(
                'kelas.id_kelas',
                DB::raw("CONCAT(kelas.kelas, ' ', kelas.jurusan) as nama_kelas"),
                'tahun_ajaran.tahun_ajaran',
                'tahun_ajaran.semester',
                'guru.nama as wali_kelas'
            )
            ->where('kelas.id_kelas', $id_kelas)
            ->first();

        $siswa = DB::table('registrasi_kelas')
            ->join('siswa', 'registrasi_kelas.nis', '=', 'siswa.nis')
            ->where('registrasi_kelas.id_kelas', $id_kelas)
            ->where('registrasi_kelas.status', 'aktif') // sudah benar
            ->select('siswa.nis', 'siswa.nama', 'siswa.jenis_kelamin')
            ->get();

        return view('kelas.class_detail', compact('kelas', 'siswa'));
    }

    public function create()
    {
        return view('kelas.class_create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kelas' => 'required|in:X,XI,XII',
            'jurusan' => 'required|in:AKL,DPIB,Geospasial,MPLB,PPLG,TAV,Teknik Kendaraan Ringan,Teknik Las,Teknik Mesin,Teknik Sepeda Motor,TKJT',
        ]);

        Kelas::create($validated);

        return redirect()->route('kelas.index')->with('success', 'Data kelas berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $kelas = Kelas::findOrFail($id);
        return view('kelas.class_edit', compact('kelas'));
    }

    public function update(Request $request, $id)
    {
        $kelas = Kelas::findOrFail($id);

        $validated = $request->validate([
            'kelas' => 'required|in:X,XI,XII',
            'jurusan' => 'required|in:AKL,DPIB,Geospasial,MPLB,PPLG,TAV,Teknik Kendaraan Ringan,Teknik Las,Teknik Mesin,Teknik Sepeda Motor,TKJT',
        ]);

        $kelas->update($validated);

        return redirect()->route('kelas.index')->with('success', 'Data kelas berhasil diperbarui.');
    }

    public function delete($id)
    {
        $kelas = Kelas::findOrFail($id);
        $kelas->delete();
        return redirect()->route('kelas.index')->with('success', 'Data kelas berhasil dihapus.');
    }

    public function showPromotionForm(Request $request)
    {
        $allKelas = DB::table('kelas')->get();

        $tahun_ajaran = DB::table('tahun_ajaran')
            ->selectRaw("CONCAT(tahun_ajaran, ' - ', semester) as label, id_tahun_ajaran")
            ->pluck('label', 'id_tahun_ajaran');

        $selectedKelas = $request->input('kelas_asal');
        $tahunAjaranLama = $request->input('tahun_ajaran_lama');
        $tahunAjaranBaru = $request->input('tahun_ajaran_baru');
        $kelasTujuan = $request->input('kelas_tujuan');

        $siswa = [];
        if ($selectedKelas && $tahunAjaranLama) {
            $siswa = DB::table('registrasi_kelas')
                ->join('siswa', 'registrasi_kelas.nis', '=', 'siswa.nis')
                ->where('registrasi_kelas.id_kelas', $selectedKelas)
                ->where('registrasi_kelas.id_tahun_ajaran', $tahunAjaranLama)
                ->where('registrasi_kelas.status', 'aktif')
                ->select('siswa.nis', 'siswa.nama')
                ->get();
        }

        $waliKelas = DB::table('guru')
            ->where('jabatan', 'Wali Kelas')
            ->select('nip', 'nama')
            ->orderBy('nama')
            ->get();

        return view('kelas.promotion_form', compact(
            'allKelas',
            'tahun_ajaran',
            'selectedKelas',
            'tahunAjaranLama',
            'tahunAjaranBaru',
            'kelasTujuan',
            'siswa',
            'waliKelas'
        ));
    }

    public function promotionProcess(Request $request)
    {
        $validated = $request->validate([
            'from_class_id' => 'required|exists:kelas,id_kelas',
            'to_class_id' => 'required|exists:kelas,id_kelas',
            'tahun_ajaran_lama' => 'required|exists:tahun_ajaran,id_tahun_ajaran',
            'tahun_ajaran_baru' => 'required|exists:tahun_ajaran,id_tahun_ajaran',
            'nip_wali_kelas' => 'required|exists:guru,nip',
            'actions' => 'required|array',
        ]);

        DB::beginTransaction();
        try {
            foreach ($validated['actions'] as $nis => $aksi) {
                // Nonaktifkan registrasi lama
                DB::table('registrasi_kelas')
                    ->where('nis', $nis)
                    ->where('id_kelas', $validated['from_class_id'])
                    ->where('id_tahun_ajaran', $validated['tahun_ajaran_lama'])
                    ->update([
                        'status' => 'nonaktif',
                        'updated_at' => now()
                    ]);

                // Tambah registrasi baru jika perlu
                if (in_array($aksi, ['naik', 'tinggal', 'lulus', 'pindah'])) {
                    DB::table('registrasi_kelas')->insert([
                        'nis' => $nis,
                        'id_kelas' => $validated['to_class_id'],
                        'id_tahun_ajaran' => $validated['tahun_ajaran_baru'],
                        'status' => 'aktif',
                        'nip' => $validated['nip_wali_kelas'],
                        'keterangan' => ucfirst($aksi), // Menyimpan aksi ke kolom keterangan
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('kelas.index')->with('success', 'Proses kenaikan kelas berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

}
