<?php

namespace App\Enums;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasColor;

enum YesNo: int implements HasLabel,HasColor,HasIcon
{
  case نعم = 1;
  case لا = 0;


  public function getLabel(): ?string
  {
    return $this->name;
  }
  public function getColor(): string | array | null
  {
    return match ($this) {
      self::نعم => 'success',
      self::لا => 'danger',
    };
  }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::نعم => 'heroicon-m-check',
            self::لا => 'heroicon-m-no-symbol',

        };
    }


}


