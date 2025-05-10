<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswa';
    protected $primaryKey = 'nis'; // NIS sebagai primary key
    public $incrementing = false; // Karena NIS bukan auto-increment
    protected $keyType = 'string'; // NIP adalah string
    public $timestamps = true; // Mengaktifkan created_at & updated_at

    protected $fillable = [
        'nis', 'nama', 'email', 'ttl', 'alamat', 
        'jenis_kelamin', 'jurusan', 'id_kelas'
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas');
    }
}
