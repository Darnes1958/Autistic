<?php

namespace App\Enums;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasColor;

enum PregnancyNormal: int implements HasLabel,HasColor
{
  case طبيعية = 1;
  case قيصيرية = 2;
  case قبل_الأوان = 3;





  public function getLabel(): ?string
  {
    return $this->name;
  }
  public function getColor(): string | array | null
  {
    return match ($this) {
      self::طبيعية => 'yellow',
      self::قيصيرية => 'success',
        self::قبل_الأوان => 'info',


    };
  }

}


