<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum WhyMedicine: int implements HasLabel
{

    case تحسين_التركيز  = 1;
    case تقليل_القلق  = 2;
    case التحكم_بالسلوكيات  = 3;
    case تثبيط_النشاط_الزائد  = 4;
    case المساعدة_على_النوم = 5;
    case أخرى = 6;



    public function getLabel(): ?string
    {
        return str_replace('_', ' ',  $this->name);
    }


}


