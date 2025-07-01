<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $table = 'staff';
    protected $primaryKey = 'id_staff';

    public function guru()
    {
        return $this->hasMany(Teacher::class, 'id_staff');
    }
}
