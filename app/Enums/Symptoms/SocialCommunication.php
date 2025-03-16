<?php

namespace App\Enums\Symptoms;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum SocialCommunication: int implements HasLabel
{

    case ضعف_في_القدرة_على_إجراء_المحادثات_أو_الاستجابة_للآخرين = 1;
    case قلة_أو_انعدام_استخدام_تعابير_الوجه_والإيماءات_أثناء_التحدث = 2;
    case صعوبة_في_فهم_مشاعر_الآخرين = 3;
    case تجنب_أو_ضعف_الاتصال_البصري = 4;
    case عدم_الاستجابة_عند_مناداته_باسمه = 5;
    case صعوبة_في_تكوين_الصداقات_أو_اللعب_مع_الآخرين_بطريقة_مناسبة = 6;



    public function getLabel(): ?string
    {
        return str_replace('_', ' ',  $this->name);
    }


}


