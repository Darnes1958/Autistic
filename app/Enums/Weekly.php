<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum Weekly: int implements HasLabel
{
    case لا_يوجد = 1;
    case جلسة_واحدة = 2;
    case جلستان = 3;
    case ثلاث_جلسات_فأكثر = 4;



    public function getLabel(): ?string
    {
        return str_replace('_', ' ',  $this->name);
    }


}


