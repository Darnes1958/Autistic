<?php

namespace App\Enums\Contact;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasColor;

enum ContactType: int implements HasLabel,HasColor
{
  case تقني_حول_تشغيل_المنظومة = 0;
  case إداري = 1;
  case مالي = 2;



  public function getLabel(): ?string
  {
      return str_replace('_', ' ',  $this->name);
  }
  public function getColor(): string | array | null
  {
    return match ($this) {
      self::تقني_حول_تشغيل_المنظومة => 'danger',
      self::إداري => 'success',
        self::مالي => 'info',

    };
  }

}


