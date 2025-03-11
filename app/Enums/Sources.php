<?php

namespace App\Enums;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasColor;

enum Sources: int implements HasLabel,HasColor
{
  case العمل = 1;
  case عقارات = 2;
    case اعمال_حرة_اخري = 3;




  public function getLabel(): ?string
  {
      return str_replace('_', ' ',  $this->name);
  }
  public function getColor(): string | array | null
  {
    return match ($this) {
      self::العمل => 'yellow',
      self::عقارات => 'Fuchsia',
        self::اعمال_حرة_اخري => 'info',

    };
  }

}


