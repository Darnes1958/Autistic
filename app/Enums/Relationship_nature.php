<?php

namespace App\Enums;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasColor;

enum Relationship_nature: int implements HasLabel,HasColor
{

  case علاقة_زوجية_جيدة = 1;
    case علاقة_زوجية_جيدة_مع_وجود_بعض_الخلافات = 2;
    case اضطرابات_في_العلاقة_الزوجية = 3;
    case الزوجين_منفصلين = 4;


  public function getLabel(): ?string
  {
    return $this->name;
  }
  public function getColor(): string | array | null
  {
    return match ($this) {
        self::علاقة_زوجية_جيدة => 'success',
        self::علاقة_زوجية_جيدة_مع_وجود_بعض_الخلافات => 'blue',
        self::اضطرابات_في_العلاقة_الزوجية => 'yellow',
        self::الزوجين_منفصلين => 'gray',
    };
  }

}


