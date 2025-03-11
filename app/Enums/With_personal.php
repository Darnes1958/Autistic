<?php

namespace App\Enums;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasColor;

enum With_personal: int implements HasLabel,HasColor
{

    case يعتني_بنفسه_دائما = 1;
    case يعتني_بنفسه_أحيانا = 2;
    case يساعد_الأخرين_في_جميع_الأحوال = 3;



  public function getLabel(): ?string
  {
      return str_replace('_', ' ',  $this->name);
  }
  public function getColor(): string | array | null
  {
    return match ($this) {
      self::يعتني_بنفسه_دائما => 'success',
      self::يعتني_بنفسه_أحيانا => 'info',
        self::يساعد_الأخرين_في_جميع_الأحوال => 'gray',
    };
  }




}


