<?php

namespace App\Models;

use App\Enums\Contact\Status;
use Illuminate\Database\Eloquent\Model;

class ContactProc extends Model
{
    protected $casts=['proc_type'=>Status::class,];
    public function User()
    {
        return $this->belongsTo(User::class);
    }
}
