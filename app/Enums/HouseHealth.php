<?php

namespace App\Enums;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasColor;

enum HouseHealth: int implements HasLabel,HasColor
{
  case صحي = 1;
  case غير_صحي = 2;





  public function getLabel(): ?string
  {
    return $this->name;
  }
  public function getColor(): string | array | null
  {
    return match ($this) {
      self::صحي => 'yellow',
      self::غير_صحي => 'success',


    };
  }

}


