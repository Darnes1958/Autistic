<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Near extends Model
{
    public function Street()
    {
        return $this->belongsTo(Street::class);
    }
}
