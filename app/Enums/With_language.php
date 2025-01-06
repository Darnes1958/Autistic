<?php

namespace App\Enums;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasColor;

enum With_language: int implements HasLabel,HasColor
{

    case يتحدث_بجمل_وكلمات = 1;
    case تأخر_في_تطور_اللغة = 2;
    case فقدان_اللغة_بشكل_تام = 3;



  public function getLabel(): ?string
  {
    return $this->name;
  }
  public function getColor(): string | array | null
  {
    return match ($this) {
      self::يتحدث_بجمل_وكلمات => 'success',
      self::تأخر_في_تطور_اللغة => 'info',
        self::فقدان_اللغة_بشكل_تام => 'gray',
    };
  }




}


