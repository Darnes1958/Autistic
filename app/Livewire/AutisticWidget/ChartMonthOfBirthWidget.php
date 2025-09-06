<?php

namespace App\Livewire\AutisticWidget;

use App\Models\Autistic;
use App\Models\City;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;

class ChartMonthOfBirthWidget extends ChartWidget
{
    protected ?string $heading = 'رسم بياني بحسب شهر الميلاد';
    protected int | string | array $columnSpan = 'full';

    protected function getData(): array
    {   $res=Autistic::query()->selectRaw('month(birthday) as month,count(*) as count')
        ->groupBy(DB::raw('month(birthday)'))->orderBy('month')->get();
        $theLabels=$res->pluck('month');
        $theData=$res->pluck('count');

        return [
            'datasets' => [
                [
                    'label' => 'الأشهر',
                    'data' => $theData,
                    'backgroundColor' => [
                        "#483D8B",
                        "#FFB6C1",
                        "#7FFF00",
                        "#0000FF",
                        "#DEB887",
                        "#006400",
                        "#8B0000",
                        "#FF8C00",
                        '#483D8B',
                        '#8B008B',
                        '#2F4F4F',
                        '#00CED1',
                        '#FFD700',

                    ],
                ],
            ],
            'labels' => $theLabels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
