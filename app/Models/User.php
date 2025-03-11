<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    use HasRoles;

    protected $appends = ['has_aut','has_fam','has_grow','has_boy'];
    public function getHasAutAttribute(){
        return autistic::where('user_id',$this->id)->first();
    }
    public function getHasFamAttribute(){
        return Family::where('user_id',$this->id)->first();
    }
    public function getHasGrowAttribute(){
        return Growth::where('user_id',$this->id)->first();
    }
    public function getHasBoyAttribute(){
        return Boy::where('user_id',$this->id)->first();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
