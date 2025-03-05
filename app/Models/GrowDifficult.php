<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GrowDifficult extends Model
{
    public function Growth()
    {
        return $this->belongsTo(Growth::class);
    }
    public function GrowDifficultMenu()
    {
        return $this->belongsTo(GrowDifficultMenu::class);
    }

}
