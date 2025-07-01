<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;
    protected $table = 'mata_pelajaran';
    protected $primaryKey = 'id_mapel';
    public $timestamps = true; // Mengaktifkan created_at & updated_at
    public $incrementing = true; // Jika id_mapel auto-increment
    protected $keyType = 'int';  // Tipe dari id_mapel

    protected $fillable = [
        'nama_mapel', 'kkm', 'nip', 'id_kelas'
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id_kelas');
    }

    public function guru()
    {
        return $this->belongsTo(Teacher::class, 'nip', 'nip');
    }

    public function nilai_rapor()
    {
        return $this->belongsTo(Score::class, 'id_nilai');
    }

   
}
