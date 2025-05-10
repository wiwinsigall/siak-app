<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $table = 'absensi';
    protected $primaryKey = 'id_absensi'; 
    public $timestamps = true; // Mengaktifkan created_at & updated_at
    protected $fillable = ['tanggal', 'keterangan', 'nis',
        'id_mapel', 'id_kelas'];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'nis');
    }

    public function mata_pelajaran()
    {
        return $this->belongsTo(Mata_pelajaran::class, 'id_mapel');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas');
    }
}

