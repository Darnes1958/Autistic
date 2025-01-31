<?php

namespace App\Models;

use App\Enums\Health;
use App\Enums\YesNo;
use Illuminate\Database\Eloquent\Model;

class Growth extends Model
{
    protected $casts = [
        'is_play_with_other' => 'array',
        'mother_p_d_health' => Health::class,
        'is_pregnancy_planned' => YesNo::class,
        'is_p_d_followed' => YesNo::class,
        'is_p_d_good_food' => YesNo::class,
        'is_child_wanted' => YesNo::class,
        'is_p_d_disease' => YesNo::class,
        'is_pregnancy_normal' => YesNo::class,
    ];
    public function BoyDisease()
    {
        return $this->hasMany(BoyDisease::class);
    }
    public function GrowDifficult()
    {
        return $this->hasMany(GrowDifficult::class);
    }
    public function GrowMedicine()
    {
        return $this->hasMany(GrowMedicine::class);
    }
    public function Autistic()
    {
        return $this->belongsTo(Autistic::class);
    }
}
