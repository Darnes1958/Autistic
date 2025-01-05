<?php

namespace App\Enums;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasColor;

enum Person_relationship: int implements HasLabel,HasColor
{
  case أب = 0;
  case أم = 1;
    case أخ = 2;
    case أخت = 3;
    case قريب = 4;


  public function getLabel(): ?string
  {
    return $this->name;
  }
  public function getColor(): string | array | null
  {
    return match ($this) {
      self::أب => 'gray',
      self::أم => 'Fuchsia',
        self::أخ => 'blue',
        self::أخت => 'success',
        self::قريب => 'yellow',
    };
  }

}


