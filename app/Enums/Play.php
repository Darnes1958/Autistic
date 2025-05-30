<?php

namespace App\Enums;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasColor;

enum Play: int implements HasLabel,HasColor
{
  case بمفرده = 1;
  case مع_إخوته = 2;
    case مع_أطفال_آخرين = 3;


  public function getLabel(): ?string
  {
      return str_replace('_', ' ',  $this->name);
  }
  public function getColor(): string | array | null
  {
    return match ($this) {
      self::بمفرده => 'success',
        self::مع_إخوته => 'info',
      self::مع_أطفال_آخرين => 'danger',
    };
  }

}


