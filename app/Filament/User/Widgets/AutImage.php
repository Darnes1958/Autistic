<?php

namespace App\Filament\User\Widgets;

use App\Models\autistic;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class AutImage extends Widget

{
    public $image;
    public $name;
    protected static string $view = 'filament.user.widgets.aut-image';
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 1;
    public function mount(): void{
        $aut=autistic::where('user_id',Auth::id())->first();
      if ($aut) {
          $this->image=$aut->image;
          $this->name=$aut->fullname;
      } else {
          $this->image=null;
          $this->name=null;
      }
    }
}
