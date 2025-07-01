<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $table = 'pengumuman_akademik';
    protected $primaryKey = 'id_pengumuman'; 
    public $timestamps = true; // Mengaktifkan created_at & updated_at

    protected $fillable = [
        'file'
    ];
}
