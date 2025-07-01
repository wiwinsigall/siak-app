<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $table = 'guru';
    protected $primaryKey = 'nip'; // NIP sebagai primary key
    public $incrementing = false; // Karena NIP bukan auto-increment
    protected $keyType = 'string'; // NIP adalah string
    public $timestamps = true; // Mengaktifkan created_at & updated_at

    protected $fillable = [
        'nip', 'nama', 'email', 'ttl', 'alamat', 
        'jenis_kelamin', 'jabatan', 'no_hp', 'id_user'
    ];

    public function mata_pelajaran()
    {
        return $this->hasMany(Subject::class, 'nip', 'nip');
    }

    public function nilai_rapor()
    {
        return $this->belongsTo(Score::class, 'id_nilai');
    }

    public function absensi()
    {
        return $this->belongsTo(Attendance::class, 'id_absensi');
    }

     public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
