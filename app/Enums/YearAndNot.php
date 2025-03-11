<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum YearAndNot: int implements HasLabel
{

    case فالعام_الأول = 1;
    case العام_الثاني = 2;
    case العام_الثالث = 3;
    case العام_الرابع = 4;
    case العام_الخامس = 5;
    case العام_السادس = 6;
    case العام_السابع = 7;
    case العام_الثامن = 8;
    case العام_التاسع = 9;
    case العام_العاشر = 10;
    case لا_يستطيع_الاعتماد_علي_نفسه = 11;


    public function getLabel(): ?string
    {
        return str_replace('_', ' ',  $this->name);
    }


}


