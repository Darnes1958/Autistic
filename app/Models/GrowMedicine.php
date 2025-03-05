<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GrowMedicine extends Model
{
    public function Growth()
    {
        return $this->belongsTo(Growth::class);
    }
    public function Medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
}
