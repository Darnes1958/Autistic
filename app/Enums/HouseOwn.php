<?php

namespace App\Enums;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasColor;

enum HouseOwn: int implements HasLabel,HasColor
{
  case ملك = 1;
  case ايجار = 2;
    case ملك_ورثة = 3;





  public function getLabel(): ?string
  {
      return str_replace('_', ' ',  $this->name);
  }
  public function getColor(): string | array | null
  {
    return match ($this) {
      self::ملك => 'yellow',
      self::ايجار => 'success',
        self::ملك_ورثة => 'info',


    };
  }

}


