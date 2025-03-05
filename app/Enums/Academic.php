<?php

namespace App\Enums;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasColor;

enum Academic: int implements HasLabel,HasColor
{
  case لم_يدرس = 0;
  case ابتدائي = 1;
    case اعدادي = 2;
    case ثانوي = 3;
    case جامعي = 4;
    case ماجستير = 5;
    case دكتوراة = 6;


  public function getLabel(): ?string
  {

      return match ($this) {
          self::لم_يدرس => 'لم يدرس',
          self::ابتدائي => 'ابتدائي',
          self::اعدادي => 'اعدادي',
          self::ثانوي => 'ثانوي',
          self::جامعي => 'جامعي',
          self::ماجستير => 'ماجستير',
          self::دكتوراة => 'دكتوراه',
      };
  }
  public function getColor(): string | array | null
  {
    return match ($this) {
      self::لم_يدرس => 'gray',
      self::ابتدائي => 'Fuchsia',
        self::اعدادي => 'blue',
        self::ثانوي => 'success',
        self::جامعي => 'yellow',
        self::ماجستير => 'info',
        self::دكتوراة => 'danger',
    };
  }

}


