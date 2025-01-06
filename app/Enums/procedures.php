<?php

namespace App\Enums;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasColor;

enum procedures: int implements HasLabel,HasColor
{

    case اللين = 1;
    case الشدة = 2;
    case الاتزان = 3;
    case التذبذب = 4;
    case العقاب = 5;



  public function getLabel(): ?string
  {
    return $this->name;
  }
  public function getColor(): string | array | null
  {
    return match ($this) {
      self::اللين => 'success',
      self::الشدة => 'info',
      self::الاتزان => 'yellow',
        self::التذبذب => 'Fuchsia',
        self::العقاب => 'danger',
    };
  }




}


