<?php

namespace App\Enums;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasColor;

enum Food: int implements HasLabel,HasColor
{
  case جيدة = 1;
  case ناقصة = 2;
    case سيئة = 3;


  public function getLabel(): ?string
  {
    return $this->name;
  }
  public function getColor(): string | array | null
  {
    return match ($this) {
      self::جيدة => 'success',
        self::ناقصة => 'info',
      self::سيئة => 'danger',
    };
  }

}


