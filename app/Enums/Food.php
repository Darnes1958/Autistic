<?php

namespace App\Enums;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasColor;

enum Food: int implements HasLabel,HasColor
{
  case جيدة = 1;
  case غير_جيدة = 2;



  public function getLabel(): ?string
  {
      return str_replace('_',' ',$this->name) ;
  }
  public function getColor(): string | array | null
  {
    return match ($this) {
      self::جيدة => 'success',
        self::غير_جيدة => 'info',

    };
  }

}


