<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $table = 'staff';

    public function guru()
    {
        return $this->hasMany(Guru::class, 'id_staff');
    }
}
