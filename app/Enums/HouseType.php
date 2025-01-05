<?php

namespace App\Enums;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasColor;

enum HouseType: int implements HasLabel,HasColor
{
  case شقة = 1;
  case منزل = 2;
    case مزرعة = 3;




  public function getLabel(): ?string
  {
    return $this->name;
  }
  public function getColor(): string | array | null
  {
    return match ($this) {
      self::شقة => 'yellow',
      self::منزل => 'Fuchsia',
        self::مزرعة => 'info',

    };
  }

}


