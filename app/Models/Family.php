<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    public function Autistic()
    {
        return $this->belongsTo(Autistic::class);
    }
    public function City()
    {
        return $this->belongsTo(City::class);
    }

}
