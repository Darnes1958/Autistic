<?php

namespace App\Filament\Clusters\Places\Resources\Nears;

use App\Filament\Clusters\Places;
use App\Filament\Clusters\Places\Resources\Nears\Pages\CreateNear;
use App\Filament\Clusters\Places\Resources\Nears\Pages\EditNear;
use App\Filament\Clusters\Places\Resources\Nears\Pages\ListNears;
use App\Livewire\Traits\PublicTrait;
use App\Models\Autistic;
use App\Models\City;
use App\Models\Near;
use App\Models\Street;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class NearResource extends Resource
{
    use PublicTrait;
    protected static ?string $model = Near::class;
    protected static ?string $cluster=Places::class;
    protected static ?string $navigationLabel='نقاط دالة';
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?int $navigationSort=3;
protected static ?string $pluralLabel='نقاط دالة';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('city_id')
                    ->options(City::all()->pluck('name','id'))
                    ->preload()
                    ->searchable()
                    ->label('المدينه')
                    ->dehydrated(false)
                    ->inlineLabel(false),
                self::getSelect('street_id')
                    ->options(fn (Get $get): Collection => Street::query()
                        ->where('city_id', $get('city_id'))
                        ->pluck('name', 'id'))
                    ->createOptionUsing(function (array $data,Get $get) : int {
                        $data['city_id']=$get('city_id');
                        return Street::create($data)->getKey();
                    })
                    ->inlineLabel(false),
                self::getInput('name')->inlineLabel(false),

                Hidden::make('user_id')->default(Auth::id())
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('Street.City.name')->label('المدينة'),
                self::getColumn('Street.name'),
                self::getColumn('name'),

            ])
            ->filters([
                Filter::make('byAll')
                ->schema([
                    Select::make('city_id')
                        ->label('المدينة')
                        ->preload()
                        ->searchable()
                        ->required()
                        ->live()
                        ->afterStateUpdated(function (Set $set,$state){
                            $set('street_id',null);

                        })
                        ->options(City::all()->pluck('name', 'id')),
                    Select::make('street_id')
                        ->label('الحي')
                        ->preload()
                        ->searchable()
                        ->required()
                        ->live()
                        ->options(fn (Get $get): Collection => Street::query()
                            ->where('city_id', $get('city_id'))
                            ->pluck('name', 'id'))
                        ->disabled(function (Get $get){return $get('city_id')==null; }),
                ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['city_id'],
                                fn (Builder $query): Builder =>
                                $query->whereIn('street_id', Street::where('city_id', $data['city_id'])->pluck('id')),
                            )
                            ->when(
                                $data['street_id'],
                                fn (Builder $query): Builder =>
                                $query->where('street_id', $data['street_id']),
                            );
                    })
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make()->modalHeading('حذف السجل')

                    ->visible(function (Model $record){
                        return !Autistic::where('near_id',$record->id)->exists();
                    }),

            ])
            ->toolbarActions([
                //
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListNears::route('/'),
            'create' => CreateNear::route('/create'),
            'edit' => EditNear::route('/{record}/edit'),
        ];
    }
}
