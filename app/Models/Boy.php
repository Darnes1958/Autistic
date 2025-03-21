<?php

namespace App\Models;

use App\Enums\procedures;
use Illuminate\Database\Eloquent\Model;

class Boy extends Model
{
    public function User()
    {
        return $this->belongsTo(User::class);
    }
    protected $casts=[
        'how_past'=>'array',
        'father_procedure'=>procedures::class,
        'mother_procedure'=>procedures::class,
        'brother_procedure'=>procedures::class,
    ];
    public function Ambitious()
    {
       return $this->belongsTo(Ambitious::class);
    }
}
