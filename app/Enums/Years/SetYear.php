<?php

namespace App\Enums\Years;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum SetYear: int implements HasLabel
{
    case ما_قبل_سنه = 1;
    case بعد_سنه = 2;
    case بعد_سنتين = 3;
    case بعد_ثلاث_سنوات = 4;
    case بعد_اربع_سنوات = 5;
    case بعد_خمس_سنوات = 6;
    case بعد_ست_سنوات = 7;
    case بعد_سبع_سنوات = 8;


    public function getLabel(): ?string
    {
        return str_replace('_', ' ',  $this->name);
    }


}


