<?php

namespace App\Livewire\FamilyWidget;

use App\Models\Family;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\HtmlString;

class FatherMotherWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('','')
                ->label(new HtmlString('<span >توجد صلة قرابة بين الأب والأم</span>'))
                ->value(new HtmlString('<span class="text-green-700">'.Family::where('is_parent_relationship',1)->count().'</span>')),
            Stat::make('','')
                ->label(new HtmlString('<span >لا توجد صلة قرابة بين الأب والأم</span>'))
                ->value(new HtmlString('<span class="text-red-700">'.Family::where('is_parent_relationship',0)->count().'</span>')),

        ];
    }
}
