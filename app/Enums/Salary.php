<?php

namespace App\Enums;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasColor;

enum Salary: int implements HasLabel,HasColor
{
  case اقل_من_500_دينار = 1;
  case من_500_الي_1000_دينار = 2;
  case من_1000_الي_1500_دينار = 3;
  case اكثر_من_1500_دينار = 4;



  public function getLabel(): ?string
  {
    return $this->name;
  }
  public function getColor(): string | array | null
  {
    return match ($this) {
      self::اقل_من_500_دينار => 'yellow',
      self::من_500_الي_1000 => 'Fuchsia',
        self::من_1000_الي_1500 => 'info',
        self::انثياكثر_من_1500 => 'success',
    };
  }

}


