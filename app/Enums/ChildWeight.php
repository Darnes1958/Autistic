<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum ChildWeight: int implements HasLabel
{
    case اقل_من_كيلو = 1;
    case كيلو = 2;
    case اثنين_كيلو = 3;
    case ثلاثة_كيلو = 4;
    case اربعة_كيلو = 5;
    case خمسة_كيلو = 6;
    case ستة_كيلو = 7;
    case سبعة_كيلو = 8;


    public function getLabel(): ?string
    {
        return match ($this) {
       self::اقل_من_كيلو => 'اقل من كيلو',
            self::كيلو => 'كيلو',
            self::اثنين_كيلو => 'اثنين كيل',
            self::ثلاثة_كيلو => 'ثلاثة كيلو',
            self::اربعة_كيلو => 'اربعة كيلو',
            self::خمسة_كيلو => 'خمسة كيلو',
            self::ستة_كيلو  => 'سته كيلو',
            self::سبعة_كيلو  => 'سبعة كيلو',
        };

    }


}


