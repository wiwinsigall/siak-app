<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;

    protected $table = 'guru';
    protected $primaryKey = 'nip'; // NIP sebagai primary key
    public $incrementing = false; // Karena NIP bukan auto-increment
    protected $keyType = 'string'; // NIP adalah string
    public $timestamps = true; // Mengaktifkan created_at & updated_at

    protected $fillable = [
        'nip', 'nama', 'email', 'ttl', 'alamat', 
        'jenis_kelamin', 'jabatan', 'golongan', 'id_mapel'
    ];

    public function mata_pelajaran()
    {
        return $this->belongsTo(Mata_pelajaran::class, 'id_mapel');
    }
}
