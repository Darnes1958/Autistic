<?php

namespace App\Enums;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasColor;

enum With_mind: int implements HasLabel,HasColor
{

    case يفهم_بسهولة_ويتصرف_بوعي = 1;
    case يفهم_ببطء_ويتصرف_أحياناً_بوعي = 2;
    case لا_يفهم_ولا_يتصرف_بوعي = 3;



  public function getLabel(): ?string
  {
      return str_replace('_', ' ',  $this->name);
  }
  public function getColor(): string | array | null
  {
    return match ($this) {
      self::يفهم_بسهولة_ويتصرف_بوعي => 'success',
      self::يفهم_ببطء_ويتصرف_أحياناً_بوعي => 'info',
        self::لا_يفهم_ولا_يتصرف_بوعي => 'gray',
    };
  }




}


