<?php

namespace App\Livewire\AutisticWidget;

use App\Models\Autistic;
use App\Models\City;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Livewire;

class ChartYearOfBirthWidget extends ChartWidget
{
    protected ?string $heading = 'رسم بياني بحسب سنة الميلاد';
    protected int | string | array $columnSpan = 'full';


    protected function getData(): array
    {   $res=Autistic::query()->selectRaw('year(birthday) as year,count(*) as count')
        ->groupBy(DB::raw('year(birthday)'))->orderBy('year')->get();
        $theLabels=$res->pluck('year');
        $theData=$res->pluck('count');

        return [
            'datasets' => [
                [
                    'label' => 'السنوات',
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
