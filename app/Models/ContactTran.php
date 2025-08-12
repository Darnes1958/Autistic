<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactTran extends Model
{
    public function User()
    {
        return $this->belongsTo(User::class);
    }
    public function User_receive()
    {
        return $this->belongsTo(User::class,'user_receive','id');
    }
}
