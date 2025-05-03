<?php

namespace App\Filament\User\Widgets;

use App\Models\Customer;
use App\Models\OurCompany;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class StatsOverView extends BaseWidget
{
    protected static ?int $sort = 1;
    protected int | string | array $columnSpan = 'full';
    protected function getColumns(): int
    {
        return 1;
    }
    public static function canView(): bool
    {
        return false;
    }

    protected function getStats(): array
    {
        return [

          Stat::make('مرحباً بكم في المنظومة الخاصة بـ ','الهيئة الوطنية لعلاج وتأهيل اطفال التوحد')
            ->description('بنغازي - ليبيا')
            ->color('primary')

            ->extraAttributes([
              'class' => 'bg greanbackground w-full',
              ]),

        ];
    }

}
