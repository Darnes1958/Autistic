<?php

namespace App\Enums;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasColor;

enum HouseOld: int implements HasLabel,HasColor
{
  case قديم = 1;
  case حديث = 2;





  public function getLabel(): ?string
  {
    return $this->name;
  }
  public function getColor(): string | array | null
  {
    return match ($this) {
      self::قديم => 'yellow',
      self::حديث => 'Fuchsia',


    };
  }

}


