<?php

namespace App\Livewire\FamilyWidget;

use App\Models\Family;
use Filament\Widgets\Widget;

class FaMoWidget extends Widget
{

    protected string $view = 'livewire.family-widget.fa-mo-widget';
    public $yes;
    public $no;
    public $label='هل توجد صلة قرابة بين الأب والام ؟';
    public function mount(){
        $this->yes=Family::where('is_parent_relationship',1)->count();
        $this->no=Family::where('is_parent_relationship',0)->count();

    }
}
