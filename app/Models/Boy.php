<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Boy extends Model
{
    public function Ambitious()
    {
       return $this->belongsTo(Ambitious::class);
    }
}
