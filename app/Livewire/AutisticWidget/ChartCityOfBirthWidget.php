<?php

namespace App\Livewire\AutisticWidget;

use App\Models\City;
use Filament\Widgets\ChartWidget;
use Livewire\Attributes\On;

class ChartCityOfBirthWidget extends ChartWidget
{
    protected ?string $heading = 'رسم بياني بحسب مكان الميلاد';
    protected int | string | array $columnSpan = 'full';



    protected function getData(): array
    {   $res=City::withCount('Autistic')->has('Autistic')->get();
        $theLabels=$res->pluck('name');
        $theData=$res->pluck('autistic_count');

        return [
            'datasets' => [
                [
                    'label' => 'المدن',
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
