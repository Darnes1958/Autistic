<?php

namespace App\Enums;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasColor;

enum Salary: int implements HasLabel,HasColor
{
  case اقل_من_1000_دينار = 1;
  case من_1000_الي_2000_دينار = 2;
  case من_2000_الي_3000_دينار = 3;
    case من_3000_الي_4000_دينار = 4;
    case من_4000_الي_5000_دينار = 5;
  case اكثر_من_5000_دينار = 6;



  public function getLabel(): ?string
  {
    return $this->name;
  }
  public function getColor(): string | array | null
  {
    return match ($this) {
      self::اقل_من_1000_دينار => 'yellow',
      self::من_1000_الي_2000_دينار => 'Fuchsia',
        self::من_2000_الي_3000_دينار=> 'info',
        self::من_3000_الي_4000_دينار => 'primary',
        self::من_4000_الي_5000_دينار => 'danger',
        self::اكثر_من_5000_دينار => 'success',
    };
  }

}


