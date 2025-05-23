<?php

namespace App\Enums;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasColor;

enum Sex: int implements HasLabel,HasColor
{
  case ذكر = 1;
  case أنثى = 2;


  public function getLabel(): ?string
  {
    return $this->name;
  }
  public function getColor(): string | array | null
  {
    return match ($this) {
      self::ذكر => 'success',
      self::أنثى => 'Fuchsia',
    };
  }

}


