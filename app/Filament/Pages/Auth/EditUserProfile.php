<?php

namespace App\Filament\Pages\Auth;

use App\Filament\User\Pages\Dashboard;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Auth\EditProfile as BaseEditProfile;

class EditUserProfile extends BaseEditProfile
{
  public function form(Form $form): Form
  {
    return $form
      ->schema([
        $this->getPasswordFormComponent(),
        $this->getPasswordConfirmationFormComponent(),

      ])  ;
  }


}
