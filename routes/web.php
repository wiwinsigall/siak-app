<?php

use App\Http\Controllers\AcademicYearController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\ClassRegistrationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RaporController;
use App\Http\Controllers\ScoresController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Rute default
Route::redirect('/', '/login');

// Rute autentikasi (UserController)
Route::controller(UserController::class)->group(function () {
    Route::get('/register', 'register')->name('register');
    Route::post('/register', 'registerAction')->name('registerAction');
    Route::get('/login', 'login')->name('login');
    Route::post('/login', 'loginAction')->name('loginAction');
    Route::post('/logout', 'logout')->name('logout');
    Route::get('/users', 'index')->name('users.index');
});

// Rute yang memerlukan autentikasi
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::prefix('dashboard')->controller(DashboardController::class)->group(function () {
        Route::get('/staff', 'staff')->name('dashboard.staff');
        Route::get('/kepsek', 'kepsek')->name('dashboard.kepsek');
        Route::get('/guru', 'guru')->name('dashboard.guru');
        Route::get('/wali_kelas', 'wali_kelas')->name('dashboard.wali_kelas');
        Route::get('/siswa', 'siswa')->name('dashboard.siswa');
    });

    // Siswa
    Route::prefix('siswa')->controller(StudentController::class)->group(function () {
        Route::get('/', 'index')->name('siswa.index');
        Route::get('/create', 'create')->name('siswa.create');
        Route::post('/store', 'store')->name('siswa.store');
        Route::get('/{nis}/detail', 'detail')->name('siswa.detail');
        Route::get('/{nis}/edit', 'edit')->name('siswa.edit');
        Route::put('/{nis}', 'update')->name('siswa.update');
        Route::delete('/{nis}', 'delete')->name('siswa.delete');
    });

    // Guru
    Route::prefix('guru')->controller(TeacherController::class)->group(function () {
        Route::get('/', 'index')->name('guru.index');
        Route::get('/create', 'create')->name('guru.create');
        Route::post('/store', 'store')->name('guru.store');
        Route::get('/{nip}/detail', 'detail')->name('guru.detail');
        Route::get('/{nip}/edit', 'edit')->name('guru.edit');
        Route::put('/{nip}', 'update')->name('guru.update');
        Route::delete('/{nip}', 'delete')->name('guru.delete');
    });

    // Mata Pelajaran
    Route::prefix('mata_pelajaran')->controller(SubjectController::class)->group(function () {
        Route::get('/', 'index')->name('mata_pelajaran.index');
        Route::get('/create', 'create')->name('mata_pelajaran.create');
        Route::post('/store', 'store')->name('mata_pelajaran.store');
        Route::get('/{id}/edit', 'edit')->name('mata_pelajaran.edit');
        Route::put('/{id}', 'update')->name('mata_pelajaran.update');
        Route::delete('/{id}', 'delete')->name('mata_pelajaran.delete');
    });

    // Tahun Ajaran
    Route::prefix('tahun_ajaran')->controller(AcademicYearController::class)->group(function () {
        Route::get('/',  'index')->name('tahun_ajaran.index');
        Route::get('/create', 'create')->name('tahun_ajaran.create');
        Route::post('/store', 'store')->name('tahun_ajaran.store');
        Route::post('/activate/{id}', 'activate')->name('tahun_ajaran.activate');
        Route::get('/{id}/edit', 'edit')->name('tahun_ajaran.edit');
        Route::put('/{id}', 'update')->name('tahun_ajaran.update');
        Route::delete('/{id}', 'delete')->name('tahun_ajaran.delete');
    });

    // Registrasi Siswa ke Kelas
    Route::prefix('registrasi_kelas')->controller(ClassRegistrationController::class)->group(function () {
        Route::get('/', 'create')->name('registrasi_kelas.create');
        Route::post('/', 'store')->name('registrasi_kelas.store');
    });

    // Kelas
    Route::prefix('kelas')->controller(ClassController::class)->group(function () {
        Route::get('/', 'index')->name('kelas.index');
        Route::get('/create', 'create')->name('kelas.create');
        Route::post('/store', 'store')->name('kelas.store');
        Route::get('/{id}/detail', 'detail')->name('kelas.detail');
        Route::get('/{id}/edit', 'edit')->name('kelas.edit');
        Route::put('/{id}', 'update')->name('kelas.update');
        Route::delete('/{id}', 'delete')->name('kelas.delete');
        Route::get('/promotion/form', 'showPromotionForm')->name('kelas.promotion_form');
        Route::post('/promotion/process', 'promotionProcess')->name('kelas.promotion_process');
    });

    // Pengumuman Akademik
    Route::prefix('pengumuman_akademik')->controller(AnnouncementController::class)->group(function () {
        Route::get('/', 'index')->name('pengumuman_akademik.index');
        Route::get('/create', 'create')->name('pengumuman_akademik.create');
        Route::post('/store', 'store')->name('pengumuman_akademik.store');
        Route::get('/{id}/edit', 'edit')->name('pengumuman_akademik.edit');
        Route::put('/{id}', 'update')->name('pengumuman_akademik.update');
        Route::delete('/{id}', 'delete')->name('pengumuman_akademik.delete');
    });

    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->middleware('auth')->name('profile');

    // Siswa melihat Absensi pribadi
    Route::get('/absensi/siswa', [AttendanceController::class, 'studentAttendance'])->name('absensi.siswa');
    Route::get('/absensi/siswa/mapel/{id_mapel}', [AttendanceController::class, 'studentAttendanceDetail'])->name('absensi.siswa.detail');

    // Absensi
    Route::prefix('absensi')->controller(AttendanceController::class)->group(function () {
        Route::get('/', 'index')->name('absensi.index');
        Route::get('/{id_kelas}/mapel', 'showBySubject')->name('absensi.showBySubject');
        Route::get('/attendanceRecap/{id_kelas}/{id_mapel}', 'attendanceRecap')->name('absensi.attendanceRecap');
        Route::get('/{id_kelas}/tanggal/{tanggal}', 'showByDate')->name('absensi.showByDate');
        Route::get('/{id_kelas}', 'attendance')->name('absensi.attendance');
        Route::match(['get', 'post'], '/create/{id_kelas}', 'create')->name('absensi.create');
        Route::post('/store', 'store')->name('absensi.store');
        Route::get('/{id_absensi}/edit', 'edit')->name('absensi.edit');
        Route::put('/{id_absensi}', 'update')->name('absensi.update');
        Route::delete('/{id_kelas}/{tanggal}/delete', 'deleteByDate')->name('absensi.deleteByDate');
    });

    // Nilai
    Route::prefix('nilai')->controller(ScoresController::class)->group(function () {
        Route::get('/', 'index')->name('nilai.index');
        Route::get('/rekap/{id_kelas}', 'scoresRecap')->name('nilai.scoresRecap');
        Route::get('/kelas/{id_kelas}', 'showBySubject')->name('nilai.showBySubject');
        Route::get('/kelas/{id_kelas}/mapel/{id_mapel}', 'scores')->name('nilai.scores');
        Route::get('/kelas/{id_kelas}/mapel/{id_mapel}/create', 'create')->name('nilai.create');
        Route::post('/kelas/{id_kelas}/mapel/{id_mapel}', 'store')->name('nilai.store');

        // Gunakan id_registrasi dan id_mapel untuk edit & update
        Route::get('/registrasi/{id_registrasi}/mapel/{id_mapel}/edit', 'edit')->name('nilai.edit');
        Route::put('/registrasi/{id_registrasi}/mapel/{id_mapel}', 'update')->name('nilai.update');
    });

    // Siswa melihat nilai pribadi
    Route::get('/siswa/nilai', [ScoresController::class, 'studentScores'])->name('nilai.siswa');
    
    // Cetak Rapor
     Route::prefix('rapor')->controller(RaporController::class)->group(function () {
        Route::get('/', 'index')->name('rapor.index');
        Route::get('/cetak/{nis}/{id_tahun_ajaran}', 'cetak')->name('rapor.cetak');
    });

    // Riwayat Siswa
    Route::prefix('riwayat')->controller(HistoryController::class)->group(function () {
        Route::get('/siswa', 'index')->name('riwayat.siswa');
    });


});