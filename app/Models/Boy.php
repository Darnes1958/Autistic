<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Boy extends Model
{
    protected $casts=[
        'how_past'=>'array'
    ];
    public function Ambitious()
    {
       return $this->belongsTo(Ambitious::class);
    }
}
