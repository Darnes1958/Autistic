<?php

namespace App\Livewire;

use App\Filament\User\Resources\ContactResource;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TopBar extends Component
{



    public function openNewUserModal()
    {


    }
    public function mount(){

    }

    public function render()
    {


        return view('livewire.top-bar');
    }
}
