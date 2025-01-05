<?php

namespace App\Enums;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasColor;

enum Academic: int implements HasLabel,HasColor
{
  case لم_يدرس = 0;
  case ابتدائي = 1;
    case اعدادي = 2;
    case ثانوي = 3;
    case جامعي = 4;


  public function getLabel(): ?string
  {
    return $this->name;
  }
  public function getColor(): string | array | null
  {
    return match ($this) {
      self::لم_يدرس => 'gray',
      self::ابتدائي => 'Fuchsia',
        self::اعددادي => 'blue',
        self::ثانوي => 'success',
        self::جامعي => 'yellow',
    };
  }

}


