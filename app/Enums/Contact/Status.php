<?php

namespace App\Enums\Contact;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasColor;

enum Status: int implements HasLabel,HasColor
{
  case لم_تقرأ = 0;
  case تمت_القراءة = 1;
  case تحت_الإجراء =2;
  case تم_الإجراء = 3;
  case حفظت = 4;



  public function getLabel(): ?string
  {

      return str_replace('_', ' ',  $this->name);
  }
  public function getColor(): string | array | null
  {
    return match ($this) {
      self::لم_تقرأ => 'danger',
      self::تمت_القراءة => 'success',

        self::حفظت => 'gray',
        self::تم_الإجراء => 'Fuchsia',
        self::تحت_الإجراء => 'blue',




    };
  }

}


