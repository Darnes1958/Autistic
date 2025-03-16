<?php

namespace App\Models;

use App\Enums\Health;
use App\Enums\YesNo;
use Illuminate\Database\Eloquent\Model;

class Growth extends Model
{
    public function User()
    {
        return $this->belongsTo(User::class);
    }
    protected $casts = [
        'is_play_with_other' => 'array',
        'social_communication' => 'array',
        'behaviors' => 'array',
        'sensory' => 'array',
        'behavioral_and_emotional' => 'array',

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


}
