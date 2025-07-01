<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Student;
use App\Models\Kelas;
use App\Models\AcademicYear;

class ClassRegistration extends Model
{
   protected $table = 'registrasi_kelas';
    protected $primaryKey = 'id_registrasi';
    public $timestamps = true;

    protected $fillable = [
        'id_kelas',
        'id_tahun_ajaran',
        'nis',
        'nip',
        'status',
        'keterangan',
    ];

    public function siswa()
    {
        return $this->belongsTo(Student::class, 'nis', 'nis');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id_kelas');
    }

    public function tahun_ajaran()
    {
        return $this->belongsTo(AcademicYear::class, 'id_tahun_ajaran', 'id_tahun_ajaran');
    }

    public function guru()
    {
        return $this->belongsTo(Teacher::class, 'nip', 'nip');
    }

    public function mata_pelajaran()
    {
        return $this->hasMany(Subject::class, 'id_kelas', 'id_kelas')
                    ->whereColumn('mata_pelajaran.nip', 'registrasi_kelas.nip');
    }

}
