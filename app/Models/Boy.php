<?php

namespace App\Models;

use App\Enums\How_past;
use App\Enums\procedures;
use Illuminate\Database\Eloquent\Casts\AsEnumCollection;
use Illuminate\Database\Eloquent\Model;

class Boy extends Model
{
    public function User()
    {
        return $this->belongsTo(User::class);
    }
    protected function casts(): array
    {
        return [

            'how_past' => AsEnumCollection::of(How_past::class),
            'father_procedure'=>procedures::class,
            'mother_procedure'=>procedures::class,
            'brother_procedure'=>procedures::class,
        ];
    }

    public function Ambitious()
    {
       return $this->belongsTo(Ambitious::class);
    }
}
