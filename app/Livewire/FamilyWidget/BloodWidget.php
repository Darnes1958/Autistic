<?php

namespace App\Livewire\FamilyWidget;

use App\Models\Family;
use Filament\Widgets\Widget;

class BloodWidget extends Widget
{
    protected string $view = 'livewire.family-widget.blood-widget';
   public $fathers;
    public $mothers;
    public $label1='فصيلة دم الأب';
    public $label2='فصيلة دم الأم';
    protected int | string | array $columnSpan='full';

   public function mount(){

       $this->fathers=Family::selectRaw('father_blood_type,count(*) as count')
           ->groupBy('father_blood_type')
           ->get();
       $this->mothers=Family::selectRaw('mother_blood_type,count(*) as count')
           ->groupBy('mother_blood_type')
           ->get();

   }
}
