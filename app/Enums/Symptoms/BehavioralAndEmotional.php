<?php

namespace App\Enums\Symptoms;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum BehavioralAndEmotional: int implements HasLabel
{
    case نوبات_غضب_شديدة = 1;
    case سلوك_عدواني = 2;
    case القلق_أو_التوتر_عند_التغيير_في_الروتين = 3;
    case فرط_النشاط=4;
    case خمول_شديد=5;
    case صعوبة_في_النوم=6;
    case أنماط_نوم_غير_منتظمة=7;

    public function getLabel(): ?string
    {

        return str_replace('_', ' ',  $this->name);
    }

}


