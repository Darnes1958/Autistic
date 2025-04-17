<?php

namespace App\Enums\Symptoms;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum Skills: int implements HasLabel
{
    case تفاوت_في_القدرات_العقلية = 1;
    case ضعف_في_القدرة_على_حل_المشكلات_و_التخطيط = 2;
    case صعوبة_في_فهم_التعليمات_متعددة_الخطوات = 3;


    public function getLabel(): ?string
    {
        if ($this->name=='تفاوت_في_القدرات_العقلية')
            return 'تفاوت في القدرات العقلية (قد يكون متفوقاً في بعض المجالات ومتأخراً في أخرى)';
        return str_replace('_', ' ',  $this->name);
    }

}


