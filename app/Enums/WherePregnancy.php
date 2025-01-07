<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum WherePregnancy: int implements HasLabel, HasColor
{
    case البيت = 1;
    case مستشفي = 2;
    case عيادة_خاصة = 3;


    public function getLabel(): ?string
    {
        return $this->name;
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::البيت => 'yellow',
            self::مستشفي => 'success',
            self::عيادة_خاصة => 'info',


        };
    }

}


