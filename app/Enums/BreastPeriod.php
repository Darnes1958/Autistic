<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum BreastPeriod: int implements HasLabel
{
    case اقل_من_سنه = 1;
    case سنه = 2;
    case أكثر_من_سنه = 3;
    case أكثر_من_سنتين = 4;


    public function getLabel(): ?string
    {
        return str_replace('_',' ',$this->name);
    }


}


