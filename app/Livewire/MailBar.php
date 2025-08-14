<?php

namespace App\Livewire;

use App\Models\Contact;
use App\Models\ContactTran;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Actions\StaticAction;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class MailBar extends Component implements HasForms,HasActions
{
    use InteractsWithForms, InteractsWithActions;
    public $count;

    #[On('refreshContact')]
    public function refreshContact()
    {
        info('yes');
        $this->mount();
    }
    public function mount()
    {
        $this->count=ContactTran::where('user_receive',Auth::id())
            ->where('isRead',0)
            ->count();
        if($this->count==0) $this->count=null;
    }
    public function render()
    {
        return view('livewire.mail-bar');
    }
}
