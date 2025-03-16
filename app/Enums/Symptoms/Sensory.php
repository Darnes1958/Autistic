<?php

namespace App\Enums\Symptoms;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum Sensory: int implements HasLabel
{
    case حساسية_مفرطة_في_الاستجابة_للمؤثرات_الحسية = 1;
    case ضعف_الاستجابة_للمؤثرات_الحسية = 2;
    case رفض_ارتداء_بعض_أنواع_الملابس = 3;
    case حب_قوي_لبعض_الأصوات_أو_الروائح = 4;
    case كره_قوي_لبعض_الأصوات_أو_الروائح = 5;
    case تفضيل_اللمس_للتهدئة = 6;

    public function getLabel(): ?string
    {
        if ($this->name=='حساسية_مفرطة_في_الاستجابة_للمؤثرات_الحسية')
            return 'حساسية مفرطة في الاستجابة للمؤثرات الحسية (مثل الصوت، الضوء، اللمس)';
        if ($this->name=='ضعف_الاستجابة_للمؤثرات_الحسية_')
            return 'ضعف الاستجابة للمؤثرات الحسية (مثل الصوت، الضوء، اللمس)';
        return str_replace('_', ' ',  $this->name);
    }


}


