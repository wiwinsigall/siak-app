<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    use HasFactory;

    protected $table = 'nilai_rapor';
    protected $primaryKey = 'id_nilai';

    protected $fillable = [
        'nilai_tugas', 'nilai_uts', 'nilai_uas', 'nilai_akhir',
        'nip', 'nis', 'id_registrasi', 'id_mapel', 'des_laporan'
    ];

    public function siswa()
    {
        return $this->belongsTo(Student::class, 'nis', 'nis');
    }

    public function guru()
    {
        return $this->belongsTo(Teacher::class, 'nip', 'nip');
    }

    public function registrasi_kelas()
    {
        return $this->belongsTo(ClassRegistration::class, 'id_registrasi', 'id_registrasi');
    }

    public function mata_pelajaran()
    {
        return $this->belongsTo(Subject::class, 'id_mapel', 'id_mapel');
    }

}
