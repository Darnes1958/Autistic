<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum BreastPeriod: int implements HasLabel
{
    case اقل_من_سنه = 1;
    case بعد_سنه = 2;
    case بعد_سنتين = 3;


    public function getLabel(): ?string
    {
        return match ($this) {
          self::اقل_من_سنه  =>'اقل من سنه',
        self::بعد_سنه  =>'بعد سنه',
        self::بعد_سنتين  =>'بعد سنتين',
        };
    }


}


