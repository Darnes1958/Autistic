<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GrowDifficultMenu extends Model
{
    public function GrowDifficult()
    {
        return $this->hasMany(GrowDifficult::class);
    }
}
