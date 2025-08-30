<?php

namespace App\Providers;




use Filament\Actions\CreateAction;
use Filament\Auth\Http\Responses\Contracts\LogoutResponse;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentColor;
use Filament\Support\Facades\FilamentView;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\View\PanelsRenderHook;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public $singletons = [
        \Filament\Auth\Http\Responses\Contracts\LoginResponse::class => \App\Http\Responses\LoginResponse::class,
        LogoutResponse::class => \App\Http\Responses\LogoutResponse::class,
    ];

    public function register(): void
    {
        $this->app->singleton(
            LoginResponse::class,
            \App\Http\Responses\LoginResponse::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        Model::unguard();
        FilamentColor::register([
            'Fuchsia' =>  Color::Fuchsia,
            'green' =>  Color::Green,
            'blue' =>  Color::Blue,
            'gray' =>  Color::Gray,
            'yellow' =>  Color::Yellow,
        ]);
        FilamentView::registerRenderHook(
            PanelsRenderHook::GLOBAL_SEARCH_BEFORE,
            fn (): string => Blade::render('@livewire(\'top-bar\')'),

        );
        FilamentView::registerRenderHook(
            PanelsRenderHook::GLOBAL_SEARCH_BEFORE,

            fn (): string => Blade::render('@livewire(\'mail-bar\')'),
        );
        Table::configureUsing(fn(Table $table) => $table->defaultNumberLocale('nl'));
        CreateAction::configureUsing(fn(CreateAction $createAction) => $createAction->label('إضافة'));

        Radio::configureUsing(function (Radio $radio): void {
            $radio->inline()->inlineLabel()->translateLabel();
        });
        TextInput::configureUsing(function (TextInput $input): void {
            $input->translateLabel();
        });
        TextColumn::configureUsing(function (TextColumn $column): void {
            $column->translateLabel();
        });
        IconColumn::configureUsing(function (IconColumn $column): void {
            $column->translateLabel();
        });
        Select::configureUsing(function (Select $column): void {
            $column->translateLabel();
        });
        TextEntry::configureUsing(function (TextEntry $entry): void {$entry->translateLabel();});


    }

}
