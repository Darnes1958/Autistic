<?php

namespace App\Filament\Widgets;

use App\Models\Customer;
use App\Models\OurCompany;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class StatsOverView extends BaseWidget
{
  protected int | string | array $columnSpan = 4;

    protected function getStats(): array
    {
        return [
            Stat::make('مرحبا !!',Auth::user()->name)
              ->description('في منظومة طيف التوحد')
              ->descriptionIcon('heroicon-s-check')
              ->color('success'),
          Stat::make('هذه المنظومة خاصة بـ ','الهيئة الوطنية لعلاج وتأهيل اطفال التوحد')
            ->description('بنغازي - ليبيا')

            ->color('primary'),

        ];
    }
}
