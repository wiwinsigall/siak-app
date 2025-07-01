<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcademicYear extends Model
{
    protected $table = 'tahun_ajaran';
    protected $primaryKey = 'id_tahun_ajaran';
    public $timestamps = true;

    protected $fillable = [
        'tahun_ajaran',
        'semester',
        'status',
    ];
}
