<?php

namespace App\Enums\Symptoms;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum Behaviors: int implements HasLabel
{
    case القيام_بحركات_متكررة_مثل_الرفرفة_باليدين_أو_التأرجح = 1;
    case الاهتمام_المفرط_بموضوع_معين_أو_نشاط_محدد = 2;
    case الحاجة_إلى_الروتين_الصارم_وصعوبة_التعامل_مع_التغييرات_المفاجئة = 3;
    case تكرار_كلمات_أو_عبارات_بدون_فهم_معناها = 4;
    case اللعب_بطرق_غير_تقليدية_مثل_ترتيب_الألعاب_بدلاً_من_استخدامها_بشكل_خيالي = 5;


    public function getLabel(): ?string
    {
        return str_replace('_', ' ',  $this->name);
    }


}


