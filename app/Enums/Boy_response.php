<?php

namespace App\Enums;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasColor;

enum Boy_response: int implements HasLabel,HasColor,HasIcon
{
  case مطيع = 1;
  case عنيد = 0;


  public function getLabel(): ?string
  {
    return $this->name;
  }
  public function getColor(): string | array | null
  {
    return match ($this) {
      self::مطيع => 'success',
      self::عنيد => 'info',
    };
  }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::مطيع => 'heroicon-m-check',
            self::عنيد => 'heroicon-m-no-symbol',

        };
    }


}


