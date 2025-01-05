<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brother extends Model
{
    public function Autistic()
    {
        return $this->belongsTo(Autistic::class);
    }
    public function Family()
    {
        return $this->belongsTo(Family::class);
    }
}
