<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum TherapeuticDetails: int implements HasLabel
{

    case تحليل_السلوك_التطبيقي_ABA = 1;
    case العلاج_الوظيفي = 2;
    case العلاج_الحسي = 3;
    case علاج_النطق = 4;
    case تدخلات_اخري = 5;


    public function getLabel(): ?string
    {
        return str_replace('_', ' ',  $this->name);
    }


}


