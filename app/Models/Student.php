<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $table = 'siswa';
    protected $primaryKey = 'nis'; // NIS sebagai primary key
    public $incrementing = false; // Karena NIS bukan auto-increment
    protected $keyType = 'string'; // NIP adalah string
    public $timestamps = true; // Mengaktifkan created_at & updated_at

    protected $fillable = [
        'nis', 'nama', 'email', 'ttl', 'alamat', 
        'jenis_kelamin', 'jurusan', 'id_user'
    ];
    
    public function nilai_rapor()
    {
        return $this->hasMany(Score::class, 'nis', 'nis');
    }

    public function absensi()
    {
        return $this->hasMany(Attendance::class, 'nis', 'nis');
    }

     public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function registrasi_kelas()
    {
        return $this->hasMany(ClassRegistration::class, 'nis', 'nis');
    }

    // Relasi ke registrasi kelas yang aktif SAAT INI
    public function registrasi_aktif()
    {
        return $this->hasOne(ClassRegistration::class, 'nis', 'nis')
                    ->where('status', 'aktif');
    }
}
