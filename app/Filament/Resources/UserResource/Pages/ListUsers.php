<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Models\User;
use Filament\Actions\CreateAction;
use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;
protected ?string $heading=' ';
    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()

                ->label('اضافة حالة'),
        ];
    }
    public function getTabs(): array
    {
        return [
          'الكل'=>Tab::make()->badge(fn()=>User::query()->count()),
            'كاملة'=>Tab::make()->badge(fn()=>User::query()->whereHas('Autistic')->whereHas('Family')
                ->whereHas('Boy')->whereHas('Growth')
                ->whereHas('Medicine')->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->whereHas('Autistic')->whereHas('Family')
                    ->whereHas('Boy')->whereHas('Growth')
                    ->whereHas('Medicine')),
            'جزئية'=>Tab::make()->badge(fn()=>User::query()
                ->where(function ($q) {
                    return $q->whereHas('Autistic')->orwhereHas('Family')
                        ->orwhereHas('Boy')->orwhereHas('Growth')
                        ->orwhereHas('Medicine');
                })
                ->where(function ($q){
                    return $q->whereDoesntHave('Family')
                        ->orwhereDoesntHave('Boy')->orwhereDoesntHave('Growth')
                        ->orwhereDoesntHave('Medicine');
                })
                ->count())
                ->modifyQueryUsing(fn (Builder $query) => $query
                    ->where(function ($q) {
                        return $q->whereHas('Autistic')->orwhereHas('Family')
                            ->orwhereHas('Boy')->orwhereHas('Growth')
                            ->orwhereHas('Medicine');
                    })
                    ->where(function ($q){
                        return $q->whereDoesntHave('Family')
                            ->orwhereDoesntHave('Boy')->orwhereDoesntHave('Growth')
                            ->orwhereDoesntHave('Medicine');
                    })
                ),
            'لم يبدأ'=>Tab::make()->badge(fn()=>User::query()->whereDoesntHave('Autistic')
                ->whereDoesntHave('Family')
                ->whereDoesntHave('Boy')->whereDoesntHave('Growth')
                ->whereDoesntHave('Medicine')->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->whereDoesntHave('Autistic')
                        ->whereDoesntHave('Family')
                        ->whereDoesntHave('Boy')->whereDoesntHave('Growth')
                        ->whereDoesntHave('Medicine')),
        ];
    }
}
