<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;
    use HasRoles;
    public function canAccessPanel(Panel $panel): bool
    {
        if ($panel->getId() === 'admin') {
            return Auth::user()->is_employee;
        }


        return true;
    }

    protected $appends = ['has_aut','has_fam','has_grow','has_boy','has_med'];
    public function getHasAutAttribute(){
        return autistic::where('user_id',$this->id)->exists();
    }
    public function getHasFamAttribute(){
        return Family::where('user_id',$this->id)->exists();
    }
    public function getHasGrowAttribute(){
        return Growth::where('user_id',$this->id)->exists();
    }
    public function getHasBoyAttribute(){
        return Boy::where('user_id',$this->id)->exists();
    }
    public function getHasMedAttribute(){
        return Medicine::where('user_id',$this->id)->exists();
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
            'is_employee' => 'boolean',
            'is_admin' => 'boolean',
            'has_aut' => 'boolean',
            'has_fam' => 'boolean',
            'has_boy' => 'boolean',
            'has_grow' => 'boolean',
            'has_med' => 'boolean',
        ];
    }

    public function Autistic(){
        return $this->hasOne(autistic::class);
    }

    public function Family(){
        return $this->hasOne(Family::class);
    }

    public function Boy(){
        return $this->hasOne(Boy::class);
    }
    public function Growth(){
        return $this->hasOne(Growth::class);
    }
    public function Medicine(){
        return $this->hasOne(Medicine::class);
    }
    public function Center()
    {
        return $this->belongsTo(Center::class);
    }

}
