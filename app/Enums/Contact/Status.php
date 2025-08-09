<?php

namespace App\Enums\Contact;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasColor;

enum Status: int implements HasLabel,HasColor
{
  case لم_تقرأ = 0;
  case تمت_القراءة = 1;



  public function getLabel(): ?string
  {

      return match ($this) {
          self::لم_تقرأ => 'لم تقرأ',
          self::تمت_القراءة => 'تمت القراءة',

      };
  }
  public function getColor(): string | array | null
  {
    return match ($this) {
      self::لم_تقرأ => 'danger',
      self::تمت_القراءة => 'success',

    };
  }

}


