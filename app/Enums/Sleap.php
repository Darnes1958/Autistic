<?php

namespace App\Enums;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasColor;

enum Sleap: int implements HasLabel,HasColor
{
  case طبيعي = 1;
  case مضطرب = 2;



  public function getLabel(): ?string
  {
    return $this->name;
  }
  public function getColor(): string | array | null
  {
    return match ($this) {
      self::طبيعي => 'success',

      self::مضطرب => 'danger',
    };
  }

}


