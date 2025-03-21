<?php

namespace App\Filament\User\Widgets;

use App\Models\autistic;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class AutImage2 extends Widget
{
    public $image;
    public $name;
    protected static string $view = 'filament.user.widgets.aut-image2';
    public function mount(): void{
        $aut=autistic::where('user_id',Auth::id())->first();
        $this->image=null;
      if ($aut) {
          $this->name=$aut->fullname;
          $i=0;
          foreach ($aut->image as $image) {
              if ($i++==1) {$this->image=$image; break;}

          }
      }
      if (!$this->image) {
          $this->image=null;
          $this->name=null;
      }
    }
}
