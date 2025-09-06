<?php

namespace App\Filament\Pages\RepAutistic;

use App\Livewire\AutisticWidget\ChartCityOfBirthWidget;
use App\Livewire\AutisticWidget\ChartMonthOfBirthWidget;
use App\Livewire\AutisticWidget\ChartYearOfBirthWidget;
use App\Livewire\AutisticWidget\CityOfBirthWidget;
use App\Livewire\AutisticWidget\MonthOfBirthWidget;
use App\Livewire\AutisticWidget\YearOfBirthWidget;
use Filament\Forms\Components\Radio;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use UnitEnum;

class BirthAndCity extends Page implements HasForms
{

    use InteractsWithForms;
    protected string $view = 'filament.pages.rep-autistic.birth-and-city';
    protected ?string $heading='إحصائية  بمكان وتاريخ الميلاد';
    protected static ?string $navigationLabel='إحصائية  بمكان وتاريخ الميلاد';

    protected static string | UnitEnum | null $navigationGroup='البيانات الأولية';

    public function getFooterWidgetsColumns(): int|array
    {
        return 3;
    }

    public $show='all';
    public function mount(): void
    {
        $this->form->fill(['show'=>$this->show,]);
    }
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
               Radio::make('show')
                   ->hiddenLabel()
                ->options([
                    'all'=>'إظهار الكل',
                    'tables'=>'إظهار الجداول فقط',
                    'charts'=>'إظهار الرسوم البيانية فقط',
                ])
                ->live()
                ->afterStateUpdated(function ($state){
                    $this->show=$state;
                    $this->dispatch('take_show',show: $state);
                })
            ]);
    }

    protected function getFooterWidgets(): array
    {
        if ($this->show=='all')
        return [
            YearOfBirthWidget::class,
            MonthOfBirthWidget::class,
            CityOfBirthWidget::class,

            ChartYearOfBirthWidget::class,
            ChartMonthOfBirthWidget::class,
            ChartCityOfBirthWidget::class,

        ];
        if ($this->show=='tables')
            return [
                YearOfBirthWidget::class,
                MonthOfBirthWidget::class,
                CityOfBirthWidget::class,
            ];
        if ($this->show=='charts')
            return [
                ChartYearOfBirthWidget::class,
                ChartMonthOfBirthWidget::class,
                ChartCityOfBirthWidget::class,

            ];


    }
}
