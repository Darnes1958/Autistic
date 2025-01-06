<?php

namespace App\Enums;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasColor;

enum With_people: int implements HasLabel,HasColor
{

    case متصل_بفاعلية = 1;
    case متصل_في_بعض_الأحيان = 2;
    case غير_متصل = 3;



  public function getLabel(): ?string
  {
    return $this->name;
  }
  public function getColor(): string | array | null
  {
    return match ($this) {
      self::متصل_بفاغلية => 'success',
      self::متصل_في_بعض_الأحيان => 'info',
        self::غير_متصل => 'gray',
    };
  }




}


