<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mata_pelajaran extends Model
{
    use HasFactory;
    protected $table = 'mata_pelajaran';
    protected $primaryKey = 'id_mapel';
    public $timestamps = true; // Mengaktifkan created_at & updated_at
    public $incrementing = true; // Jika id_mapel auto-increment
    protected $keyType = 'int';  // Tipe dari id_mapel

    protected $fillable = [
        'nama_mapel'
    ];

    public function guru()
    {
        return $this->hasMany(Guru::class, 'id_mapel');
    }
   
}
