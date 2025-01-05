<?php

namespace App\Enums;
use Filament\Support\Contracts\HasLabel;

enum Sym_year: int implements HasLabel
{
  case الأول = 1;
  case الثاني = 2;
    case الثالث = 3;
    case الرابع = 4;
    case الخامس = 5;
    case السادس = 6;
    case السابع = 7;
    case الثامن = 8;
    case التاسع = 9;
    case العاشر = 10;


  public function getLabel(): ?string
  {
    return $this->name;
  }


}


