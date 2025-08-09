<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    public function Street(){
        return $this->hasMany(Street::class);
    }
    public function Center(){
        return $this->hasMany(Center::class);
    }
    public function Near(){
        return $this->hasManyThrough(Near::class, Street::class);
    }
}
