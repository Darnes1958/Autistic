<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Center extends Model
{
    public function City(){
        return $this->belongsTo(City::class);
    }
    public function User(){
        return $this->belongsTo(User::class);
    }
}
