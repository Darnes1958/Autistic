<?php

namespace App\Enums;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasColor;

enum Boy_response: int implements HasLabel,HasColor
{
  case مطيع = 1;
  case عنيد = 2;
    case غير_مطيع = 3;


  public function getLabel(): ?string
  {
      return match ($this) {
          self::مطيع=>'مطيع',
          self::عنيد=>'عنيد',
          self::غير_مطيع=>'غير مطيع',

      };

  }
  public function getColor(): string | array | null
  {
    return match ($this) {
      self::مطيع => 'success',
      self::عنيد => 'info',
        self::غير_مطيع => 'danger',
    };
  }



}


