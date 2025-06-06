<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum PregnancyTime: int implements HasLabel, HasColor
{
    case أقل_من_ساعة = 1;
    case ساعة = 2;
    case أكثر_من_ساعة = 3;


    public function getLabel(): ?string
    {
        return str_replace('_', ' ',  $this->name);
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::أقل_من_ساعة => 'yellow',
            self::ساعة => 'success',
            self::أكثر_من_ساعة => 'info',


        };
    }

}


