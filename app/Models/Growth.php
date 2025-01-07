<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Growth extends Model
{
    protected $casts = [
        'is_play_with_other' => 'array',
    ];
    public function BoyDisease()
    {
        return $this->hasMany(BoyDisease::class);
    }
    public function GrowDifficult()
    {
        return $this->hasMany(GrowDifficult::class);
    }
    public function Autistic()
    {
        return $this->belongsTo(Autistic::class);
    }
}
