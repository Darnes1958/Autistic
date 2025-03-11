<?php

namespace App\Enums;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasColor;

enum BreastfeedingNatural: int implements HasLabel,HasColor
{
  case طبيعية = 1;
  case اصطناعية = 2;
  case الاثنان_معاً = 3;





  public function getLabel(): ?string
  {
    return match ($this) {
      self::طبيعية =>'طبيعية',
        self::اصطناعية=>'اصطناعية',
        self::الاثنان_معاً=>'الإثنان معاً',
    };
  }
  public function getColor(): string | array | null
  {
    return match ($this) {
      self::طبيعية => 'yellow',
      self::اصطناعية => 'success',
        self::الاثنان_معاً => 'info',


    };
  }

}


