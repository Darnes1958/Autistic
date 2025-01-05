<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Disease extends Model
{
    public function Family()
    {
        return $this->hasMany(Family::class);
    }
}
