<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    public function GrowMedicine()
    {
        return $this->hasMany(GrowMedicine::class);
    }
}
