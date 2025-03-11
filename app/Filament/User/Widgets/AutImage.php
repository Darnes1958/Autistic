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
        $aut=autistic::where('user_id',Auth::id())->first();
      if ($aut)  $this->image=$aut->image; else $this->image=null;
    }
}
