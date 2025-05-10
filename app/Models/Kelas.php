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
        'id_kelas', 'nama_kelas', 'semester', 'tahun_ajaran'
    ];

    public function siswa()
    {
        return $this->hasMany(Siswa::class, 'id_kelas');
    }
}
