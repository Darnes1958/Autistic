<?php

namespace App\Livewire\FamilyWidget;

use App\Models\Family;
use Filament\Widgets\Widget;

class FaMoGoodWidget extends Widget
{
    protected string $view = 'livewire.family-widget.fa-mo-good-widget';
    public $R1,$R2,$R3,$R4;
    protected int | string | array $columnSpan=3;

    public $label='ما هي طبيعة العلاقة بين الأب والأم ؟';
    public function mount(){
        $this->R1=Family::where('parent_relationship_nature',1)->count();
        $this->R2=Family::where('parent_relationship_nature',2)->count();
        $this->R3=Family::where('parent_relationship_nature',3)->count();
        $this->R4=Family::where('parent_relationship_nature',4)->count();

    }
}
