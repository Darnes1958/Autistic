<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiseaseMenu extends Model
{
    public function  BoyDisease()
    {
        return $this->hasMany(BoyDisease::class);
    }
}
