<?php

namespace App\Filament\User\Pages;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Actions;
use Filament\Actions\Action;
use App\Livewire\Traits\PublicTrait;
use App\Models\Boy;
use App\Models\Medicine;
use Awcodes\TableRepeater\Components\TableRepeater;
use Awcodes\TableRepeater\Header;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Set;
use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Auth;

class createMedicine extends Page implements HasForms
{
    use InteractsWithForms,PublicTrait;
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-document-text';

    protected string $view = 'filament.user.pages.create-medicine';

    protected static ?string $navigationLabel='التدخلات العلاجية والأدوية';
    protected ?string $heading=' ';
    protected static ?int $navigationSort=5;
    public static function getNavigationIcon(): string|Htmlable|null
    {
        if (Auth::user()->has_med)
            return 'heroicon-o-check';

        return 'heroicon-o-x-mark';

    }

    public ?array $data = [];
    public  $med;

    public function mount(): void
    {
        $this->med=Medicine::where('user_id',Auth::id())->first();
        if ($this->med)
            $this->form->fill($this->med->toArray());
        else
        {

            $this->form->fill(['user_id'=>Auth::id()]);
        }

    }
    public function form(Schema $schema): Schema
    {
        return $schema
            ->model(Medicine::class)
            ->statePath('data')
            ->components([
                Grid::make()
                    ->schema([
                        Section::make()

                          ->heading(self::ret_html(' العلاج الدوائي','my-yellow text-2xl font-black  ') )
                          ->schema([
                               self::getSelectEnum('is_take_medicine','هل يتناول الحالة دواء'),
                               Fieldset::make(' ')
                                ->visible(fn(Get $get):bool=> $get('is_take_medicine')!=NULL && $get('is_take_medicine')->value==1)
                                ->schema([
                                    self::getDate('when_take_medicine','متى بدأ تناول الدواء'),
                                    Textarea::make('medicine')
                                        ->label(self::ret_html('قائمة بالادوية التي يتناولها '))
                                        ->required()
                                        ->validationMessages([
                                            'required' => 'يجب ادخال الأدوية التي يتناولها ',

                                        ])

                                        ->inlineLabel(),
                                    self::getCheck('why_take_medicine','الغرض من تناول الدواء'),

                                    self::getInput('other_reason_take_medicine','أرجو التوضيح')
                                        ->visible(fn(Get $get):bool=>$get('why_take_medicine')!=NULL && $get('why_take_medicine')->value==6),
                                    self::getSelectEnum('is_still_take_medicine','هل مازال التدخل الدوائي مستمر ؟'),
                                    self::getInput('why_he_stop_medicine','لماذا توقف العلاج')
                                        ->visible(fn(Get $get):bool=>$get('is_still_take_medicine')!=NULL &&
                                            $get('is_still_take_medicine')->value==0),
                                    self::getSelectEnum('is_there_symptoms','هل هناك آثار جانبية ملحوظة ؟ '),
                                    self::getInput('what_are_symptoms','ما هي الآثار الجانبية ?')
                                        ->visible(fn(Get $get):bool=>$get('is_there_symptoms')!=NULL && $get('is_there_symptoms')->value==1),
                                    self::getSelectEnum('is_medicine_change','هل تم تغيير نوع أو جرعة الدواء مؤخراً ؟ '),
                                    self::getInput('why_change','ما هي التغييرات ؟')
                                        ->visible(fn(Get $get):bool=>$get('is_medicine_change')!=NULL && $get('is_medicine_change')->value==1),

                                    FileUpload::make('prescription_image')
                                        ->directory('prescription-images')
                                        ->placeholder('انقر هنا لإدراج الوصفة')
                                        ->label('take photo')
                                        ->multiple()
                                        ->label(fn()=>self::ret_html('صور وصفة الدواء إن وجدت','my-yellow text-lg')),
                                    FileUpload::make('medical_reports')
                                        ->directory('medical-reports')
                                        ->placeholder('انقر هنا لإدراج التقرير')
                                        ->multiple()
                                        ->label(fn()=>self::ret_html('صور التقارير الطبية إن وجدت','my-yellow text-lg')),
                                ])->columns(1),

                          ])
                          ->extraAttributes(['class' => 'greanbackground']),
                        Section::make()
                            ->heading(self::ret_html(' التدخلات السلوكية والعلاجية','my-yellow text-2xl font-black') )
                            ->schema([
                                self::getSelectEnum('is_take_therapeutic','هل تلقى الحالة أي تدخلات علاجية غير دوائية ؟ '),
                                Fieldset::make(' ')
                                    ->visible(fn(Get $get):bool=>$get('is_take_therapeutic')!=NULL && $get('is_take_therapeutic')->value==1)
                                    ->schema([
                                        self::getCheck('therapeutic_details',' '),
                                        self::getInput('other_therapeutic','ماهي التدخلات الاخري')
                                            ->visible(fn(Get $get):bool=>$get('therapeutic_details')!=NULL && $get('therapeutic_details')->value==5),

                                        self::getInput('age_therapeutic',' كم كان عمر الحالة عند تلقي التدخلات العلاجية ؟')
                                        ->numeric(),
                                        self::getDate('when_therapeutic','متي بدأ التدخل العلاجي ؟'),
                                        self::getSelectEnum('weekly_therapeutic','عدد الجلسات أسبوعياً ؟ '),
                                        self::getSelectEnum('is_stil_take_therapeutic','هل مازال التدخل العلاجي مستمر حتى الآن؟ '),
                                        self::getInput('why_he_stop_therapeutic','لماذا توقف التدخل العلاجي ؟')
                                            ->visible(fn(Get $get):bool=>$get('is_stil_take_therapeutic')!=NULL &&
                                                $get('is_stil_take_therapeutic')->value==0),
                                        self::getSelectEnum('is_there_any_improve','هل هناك تحسن ملحوظ ؟ '),
                                        self::getInput('what_is_improve','ما هو التحسن ?')
                                            ->visible(fn(Get $get):bool=>$get('is_there_any_improve')!=NULL && $get('is_there_any_improve')->value==1),


                                        FileUpload::make('therapeutic_reports')
                                            ->directory('therapeutic-reports')
                                            ->multiple()
                                            ->label(fn()=>self::ret_html('صور جلسات العلاج إن وجدت','my-yellow text-lg')),




                                    ])->columns(1),

                            ])
                            ->extraAttributes(['class' => 'greanbackground']),
                        Section::make()
                            ->heading(self::ret_html('التوصيات المستقبلية','my-yellow text-2xl font-black') )
                         ->schema([
                             self::getSelectEnum('is_doctor_say','هل أوصى الطبيب أو المختص بتعديل الخطة العلاجية ؟ '),
                             self::getInput('what_doctor_say','بماذا أوصى ؟')
                                 ->visible(fn(Get $get):bool=>$get('is_doctor_say')!=NULL &&  $get('is_doctor_say')->value==1),
                             self::getSelectEnum('any_problems','هل هناك صعوبات في الالتزام بالعلاج سواء الدوائي أو السلوكي؟ '),
                             self::getInput('what_is_problems','ماهي الصعوبات ؟')
                                 ->visible(fn(Get $get):bool=>$get('any_problems')!=NULL && $get('any_problems')->value==1),

                         ])
                         ->extraAttributes(['class' => 'greanbackground']),


                        Hidden::make('user_id'),

                        Actions::make([
                            Action::make('store')
                                ->requiresConfirmation()
                                ->action(function (){
                                    if ($this->med)
                                        $this->med->update($this->form->getState());

                                    else
                                        Medicine::create($this->form->getState());

                                    $this->form->model($this->med)->saveRelationships();
                                    $this->redirect(Dashboard::getUrl());

                                })
                                ->label('حفظ ومتابعة'),
                            Action::make('cancel')
                                ->action(function (){
                                    $this->redirect(Dashboard::getUrl());
                                })
                                ->label('حفظ وخروج')
                        ])
                            ->alignCenter(),
                     ])
                    ->columnSpan(3)
                    ->columns(1)
                    ->extraAttributes(['class' => 'greanbackground'])

            ])
            ->columns(5) ;

    }
}

