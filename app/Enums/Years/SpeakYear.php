<?php

namespace App\Enums\Years;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum SpeakYear: int implements HasLabel
{
    case لم_ينطق = 1;
    case ما_قبل_سنه = 2;
    case بعد_سنه = 3;
    case بعد_سنتين = 4;
    case بعد_ثلاث_سنوات = 5;
    case بعد_اربع_سنوات = 6;
    case بعد_خمس_سنوات = 7;


    public function getLabel(): ?string
    {
        return str_replace('_', ' ',  $this->name);
    }


}


