<x-filament-widgets::widget>
    <x-filament::section @class('section_widget_amber')>
        <x-slot name="heading">
            {{$label}}
        </x-slot>
        <div class="flex  space-x-10">
            <div class="w-1/2 text-center">
               <label>{{\App\Enums\Relationship_nature::علاقة_زوجية_جيدة->getLabel()}}</label>
            </div>
            <div class="w-1/2 text-center" >
                <label>{{\App\Enums\Relationship_nature::علاقة_زوجية_جيدة_مع_وجود_بعض_الخلافات->getLabel()}}</label>
            </div>
            <div class="w-1/2 text-center">
                <label>{{\App\Enums\Relationship_nature::اضطرابات_في_العلاقة_الزوجية->getLabel()}}</label>
            </div>
            <div class="w-1/2 text-center" >
                <label>{{\App\Enums\Relationship_nature::الزوجين_منفصلين->getLabel()}}</label>
            </div>

        </div>
        <div class="flex col space-x-10">
            <div class="w-1/2 text-center">
                <span class="text-2xl text-amber-700 "> {{$R1}} </span>
            </div>
            <div class="w-1/2 text-center">
                <span class="text-2xl text-amber-700 "> {{$R2}} </span>
            </div>
            <div class="w-1/2 text-center">
                <span class="text-2xl text-amber-700 "> {{$R3}} </span>
            </div>
            <div class="w-1/2 text-center">
                <span class="text-2xl text-amber-700 "> {{$R4}} </span>
            </div>

        </div>



    </x-filament::section>
</x-filament-widgets::widget>
