<?php

namespace App\Models;

use App\Enums\Contact\ContactType;
use App\Enums\Contact\Status;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    public function user(){
        return $this->belongsTo(User::class);
    }

    protected $casts=[
        'status'=>Status::class,
        'contactType'=>ContactType::class,
        'read_by'=>'array',
    ];
}
