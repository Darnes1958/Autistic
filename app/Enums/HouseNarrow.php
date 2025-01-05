<?php

namespace App\Enums;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasColor;

enum HouseNarrow: int implements HasLabel,HasColor
{
  case متسع = 1;
  case ضيق = 2;





  public function getLabel(): ?string
  {
    return $this->name;
  }
  public function getColor(): string | array | null
  {
    return match ($this) {
      self::متسع => 'yellow',
      self::ضيق => 'Fuchsia',


    };
  }

}


