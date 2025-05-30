<?php

namespace App\Filament\User\Pages;

use App\Livewire\Traits\PublicTrait;
use App\Models\Boy;
use App\Models\Family;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Auth;

class createBoy extends Page implements HasForms
{
    use InteractsWithForms,PublicTrait;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';


    protected static string $view = 'filament.user.pages.create-boy';
    protected static ?string $navigationLabel='بيانات عن الحالة';
    protected ?string $heading=' ';
    protected static ?int $navigationSort=3;
    public static function getNavigationIcon(): string|Htmlable|null
    {
        if (Auth::user()->has_boy)
            return 'heroicon-o-check';
        else return 'heroicon-o-x-mark';

    }

    public ?array $data = [];
    public $boy;
    public $showPast=false;
    public function mount(): void
    {
        $this->boy=Boy::where('user_id',Auth::id())->first();
        if ($this->boy)
            $this->form->fill($this->boy->toArray());
        else
        {

             $this->form->fill(['user_id'=>Auth::id()]);
        }

    }
    public function form(Form $form): Form
    {
        return $form
            ->model(Boy::class)
            ->statePath('data')
            ->schema([
                Grid::make()
                    ->schema([
                        Section::make()
                            ->schema([


                                        self::getSelectEnumMulti('how_past',' ',false)
                                            ->label(fn()=>self::ret_html('كيف كان وضع الحالة في بداية ظهور الأعراض ؟ ','my-yellow text-2xl font-black'))
                                            ->live()
                                            ->afterStateUpdated(function ($state,Set $set){
                                                $this->showPast=false;
                                                foreach ($state as $s) if ($s==10) $this->showPast=true;
                                                if (!$this->showPast) $set('other_past',null);
                                            }),
                                        self::getArea('other_past','يرجي توضيح الاعراض الأخري التي ظهرت ')->required(false)
                                            ->visible(function (){
                                                return $this->showPast;
                                            }),
                                        Fieldset::make(self::ret_html('مدى تأثير الإضطراب على الحالة','my-yellow text-2xl font-black'))
                                         ->schema([
                                             self::getSelectEnum('with_people'),
                                             self::getSelectEnum('with_motion'),
                                             self::getSelectEnum('with_language'),
                                             self::getSelectEnum('with_personal'),
                                             self::getSelectEnum('with_mind'),

                                         ])->columns(1),

                                        self::getSelect('ambitious_id')
                                            ->label(fn()=>self::ret_html('ما هو طموح الأسرة بالنسبة للحالة ؟ ','my-yellow text-2xl font-black'))
                                            ->inlineLabel(false),
                                        self::getArea('other_boy_info','معلومات أخرى عن الحالة')
                                            ->required(false),

                                        Fieldset::make(fn()=>self::ret_html('ما أساليب التعامل مع الحالة','my-yellow text-2xl font-black'))
                                            ->schema([
                                                self::getSelectEnum('father_procedure'),
                                                self::getSelectEnum('mother_procedure'),
                                                self::getSelectEnum('brother_procedure'),
                                                self::getSelectEnum('boy_response'),
                                            ])->columns(1),

                                Hidden::make('user_id'),

                                Actions::make([
                                    Action::make('store')
                                        ->requiresConfirmation()
                                        ->action(function (){
                                            if ($this->boy)
                                                $this->boy->update($this->form->getState());

                                            else
                                                Boy::create($this->form->getState());

                                            $this->redirect(Dashboard::getUrl());

                                        })
                                        ->label('حفظ ومتابعة'),
                                    Action::make('cancel')
                                        ->action(function (){
                                            $this->redirect(Dashboard::getUrl());
                                        })
                                        ->label('حفظ وخروج')
                                ])->alignCenter(),



                            ])
                            ->columns(1)
                            ->extraAttributes(['class' => 'greanbackground'])
                    ])
                    ->columns(1)
                    ->columnSpan(3)
            ])->columns(6) ;

    }
}

