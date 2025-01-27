<?php

namespace App\Enums;
use Filament\Support\Contracts\HasLabel;

use Filament\Support\Contracts\HasColor;

enum RelationsTypes: int implements HasLabel,HasColor
{
    case سيئة = 0;
  case جيدة = 1;

    case ممتازة = 2;


  public function getLabel(): ?string
  {
    return $this->name;
  }
  public function getColor(): string | array | null
  {
    return match ($this) {
        self::سيئة => 'danger',
      self::جيدة => 'success',
        self::ممتازة => 'info',

    };
  }

}


