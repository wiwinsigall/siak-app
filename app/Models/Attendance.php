<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $table = 'absensi';
    protected $primaryKey = 'id_absensi'; 
    public $timestamps = true; // Mengaktifkan created_at & updated_at
    protected $fillable = ['tanggal', 'keterangan', 'nis', 'nip',
        'id_mapel', 'id_tahun_ajaran', 'id_registrasi'
    ];

    public function siswa()
    {
        return $this->belongsTo(Student::class, 'nis','nis');
    }

    public function guru()
    {
        return $this->belongsTo(Teacher::class, 'nip', 'nip');
    }

    public function mata_pelajaran()
    {
        return $this->belongsTo(Subject::class, 'id_mapel', 'id_mapel');
    }

    public function tahun_ajaran()
    {
        return $this->belongsTo(AcademicYear::class, 'id_tahun_ajaran', 'id_tahun_ajaran');
    }

    public function registrasi_kelas()
    {
        return $this->belongsTo(ClassRegistration::class, 'id_registrasi', 'id_registrasi');
    }
}

