<?php

namespace App\Enums;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasColor;

enum How_past: int implements HasLabel,HasColor,HasIcon
{
  case ظهرت_بعض_الصعوبات = 0;
  case مثل_بقية_الاطفال_الاخرين = 1;


  public function getLabel(): ?string
  {
    return $this->name;
  }
  public function getColor(): string | array | null
  {
    return match ($this) {
      self::ظهرت_بعض_الصعوبات => 'info',
      self::مثل_بقية_الاطفال_الاخرين => 'success',
    };
  }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::ظهرت_بعض_الصعوبات => 'heroicon-m-no-symbol',
            self::مثل_بقية_الاطفال_الاخرين => 'heroicon-m-check',
        };
    }


}


