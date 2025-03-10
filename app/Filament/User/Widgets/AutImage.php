<?php

namespace App\Filament\User\Widgets;

use App\Models\autistic;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class AutImage extends Widget
{
    public $image;
    protected static string $view = 'filament.user.widgets.aut-image';
    public function mount(): void{
        $this->image=autistic::where('nat_id',Auth::user()->nat)->first()->image;
    }
}
