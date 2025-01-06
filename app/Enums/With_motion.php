<?php

namespace App\Enums;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasColor;

enum With_motion: int implements HasLabel,HasColor
{

    case أداء_حركي_عادي = 1;
    case أداء_حركي_قليل_الإتزان = 2;
    case أداء_حركي_مضطرب_وغير_متزن = 3;



  public function getLabel(): ?string
  {
    return $this->name;
  }
  public function getColor(): string | array | null
  {
    return match ($this) {
      self::أداء_حركي_عادي => 'success',
      self::أداء_حركي_قليل_الإتزان => 'info',
        self::أداء_حركي_مضطرب_وغير_متزن => 'gray',
    };
  }




}


