<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\MataPelajaranController;
use App\Http\Controllers\PengumumanAkademikController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Rute default
Route::get('/', function () {
    return redirect()->route('login'); // Arahkan ke halaman login
});

// Rute yang memerlukan autentikasi
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard/staff', [DashboardController::class, 'staff'])->name('dashboard.staff');
    Route::get('/dashboard/guru', [DashboardController::class, 'guru'])->name('dashboard.guru');
    Route::get('/dashboard/siswa', [DashboardController::class, 'siswa'])->name('dashboard.siswa');
    Route::get('/dashboard/wali_kelas', [DashboardController::class, 'wali_kelas'])->name('dashboard.wali_kelas');
    Route::get('/dashboard/kepsek', [DashboardController::class, 'kepsek'])->name('dashboard.kepsek');
});

// Rute untuk UserController
Route::controller(UserController::class)->group(function(){
    // Registrasi
    Route::get('/register', 'register')->name('register'); 
    Route::post('/register', 'register_action')->name('register.action'); 

    // Login
    Route::get('/login', 'login')->name('login');
    Route::post('/login', 'login_action')->name('login.action'); 

    // Logout
    Route::get('/logout', 'logout')->name('logout');
});

// Rute untuk Data Guru
Route::get('/guru', [GuruController::class, 'index'])->name('guru.index');
Route::get('/guru/tambah', [GuruController::class, 'tambah'])->name('guru.tambah');
Route::post('/guru/tambah', [GuruController::class, 'tambah'])->name('guru.tambah');
Route::get('/guru/{nip}/detail', [GuruController::class, 'detail'])->name('guru.detail');
Route::get('/guru/{nip}/ubah', [GuruController::class, 'ubah'])->name('guru.ubah');
Route::put('/guru/{nip}', [GuruController::class, 'update'])->name('guru.update');
Route::delete('/guru/{nip}', [GuruController::class, 'hapus'])->name('guru.hapus');

// Rute untuk Data Siswa
Route::get('/siswa', [SiswaController::class, 'index'])->name('siswa.index');
Route::get('/siswa/tambah', [SiswaController::class, 'tambah'])->name('siswa.tambah');
Route::post('/siswa/tambah', [SiswaController::class, 'tambah'])->name('siswa.tambah');
Route::get('/siswa/{nis}/detail', [SiswaController::class, 'detail'])->name('siswa.detail');
Route::get('/siswa/{nis}/ubah', [SiswaController::class, 'ubah'])->name('siswa.ubah');
Route::put('/siswa/{nis}', [SiswaController::class, 'update'])->name('siswa.update');
Route::delete('/siswa/{nis}', [SiswaController::class, 'hapus'])->name('siswa.hapus');

// Rute untuk Kelas
Route::get('/kelas', [KelasController::class, 'index'])->name('kelas.index');
Route::get('/kelas/tambah', [KelasController::class, 'tambah'])->name('kelas.tambah');
Route::post('/kelas/tambah', [KelasController::class, 'tambah'])->name('kelas.tambah');
Route::get('/kelas/{id}/ubah', [KelasController::class, 'ubah'])->name('kelas.ubah');
Route::put('/kelas/{id}', [KelasController::class, 'update'])->name('kelas.update');
Route::delete('/kelas/{id}', [KelasController::class, 'hapus'])->name('kelas.hapus');

//Rute untuk Mata Pelajaran
Route::get('/mata_pelajaran', [MataPelajaranController::class, 'index'])->name('mata_pelajaran.index');
Route::get('/mata_pelajaran/tambah', [MataPelajaranController::class, 'tambah'])->name('mata_pelajaran.tambah');
Route::post('/mata_pelajaran/tambah', [MataPelajaranController::class, 'tambah'])->name('mata_pelajaran.tambah');
Route::get('/mata_pelajaran/{id}/ubah', [MataPelajaranController::class, 'ubah'])->name('mata_pelajaran.ubah');
Route::put('/mata_pelajaran/{id}', [MataPelajaranController::class, 'update'])->name('mata_pelajaran.update');
Route::delete('/mata_pelajaran/{id}', [MataPelajaranController::class, 'hapus'])->name('mata_pelajaran.hapus');

// Rute untuk pengumuman akademik
Route::get('/pengumuman_akademik', [PengumumanAkademikController::class, 'index'])->name('pengumuman_akademik.index');
Route::get('/pengumuman_akademik/tambah', [PengumumanAkademikController::class, 'tambah'])->name('pengumuman_akademik.tambah');
Route::post('/pengumuman_akademik/tambah', [PengumumanAkademikController::class, 'tambah'])->name('pengumuman_akademik.tambah');
Route::get('/pengumuman_akademik/{id}/ubah', [PengumumanAkademikController::class, 'ubah'])->name('pengumuman_akademik.ubah');
Route::put('/pengumuman_akademik/{id}', [PengumumanAkademikController::class, 'update'])->name('pengumuman_akademik.update');
Route::delete('/pengumuman_kademik/{id}', [PengumumanAkademikController::class, 'hapus'])->name('pengumuman_akademik.hapus');

// Rute untuk profile
Route::get('/profile', [ProfileController::class, 'index'])->name('profile');

//Rute untuk Absensi Siswa
Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi.index');
Route::get('/absensi/rekapAbsensi/{id_kelas}', [AbsensiController::class, 'rekapAbsensi'])->name('absensi.rekapAbsensi');
Route::get('/absensi/{id_kelas}', [AbsensiController::class, 'lihatAbsensi'])->name('absensi.lihatAbsensi');
Route::get('/absensi/{id_kelas}/tanggal/{tanggal}', [AbsensiController::class, 'lihatAbsensiTanggal'])->name('absensi.lihatAbsensiTanggal');
Route::get('/absensi/tambah/{id_kelas}', [AbsensiController::class, 'tambah'])->name('absensi.tambah');
Route::post('/absensi/tambah/{id_kelas}', [AbsensiController::class, 'tambah'])->name('absensi.tambah');
Route::post('/absensi/simpan', [AbsensiController::class, 'simpan'])->name('absensi.simpan');
