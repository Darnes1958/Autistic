<?php

namespace App\Filament\Pages\Auth;

use Filament\Auth\Pages\EditProfile;
use Filament\Schemas\Schema;
use App\Filament\User\Pages\Dashboard;
use Filament\Forms\Components\TextInput;

class EditUserProfile extends EditProfile
{
  public function form(Schema $schema): Schema
  {
    return $schema
      ->components([
        $this->getPasswordFormComponent(),
        $this->getPasswordConfirmationFormComponent(),

      ])  ;
  }


}
