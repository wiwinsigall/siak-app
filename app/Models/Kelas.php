<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'kelas';
    protected $primaryKey = 'id_kelas'; 
    public $timestamps = true; // Mengaktifkan created_at & updated_at

    protected $fillable = [
         'kelas', 'jurusan' 
    ];

    public function siswa()
    {
        return $this->belongsToMany(Student::class, 'registrasi_kelas', 'id_kelas', 'nis')
                    ->withPivot(['id_tahun_ajaran', 'status', 'keterangan'])
                    ->withTimestamps();
    }

   public function guru()
    {
        return $this->belongsTo(Teacher::class, 'nip', 'nip');
    }

    public function wali_kelas()
    {
        return $this->belongsTo(Teacher::class, 'nip', 'nip');  
    }

   public function mata_pelajaran()
    {
        return $this->hasMany(Subject::class, 'id_kelas', 'id_kelas');
    }

    public function registrasi_kelas()
    {
        return $this->hasMany(ClassRegistration::class, 'id_kelas', 'id_kelas');
    }

}
