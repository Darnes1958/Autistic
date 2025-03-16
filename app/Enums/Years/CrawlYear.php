<?php

namespace App\Enums\Years;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum CrawlYear: int implements HasLabel
{
    case أقل_من_سنه = 1;
    case بعد_سنه = 2;
    case بعد_سنتين = 3;

    public function getLabel(): ?string
    {
        return str_replace('_', ' ',  $this->name);
    }


}


