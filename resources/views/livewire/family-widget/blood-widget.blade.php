<x-filament-widgets::widget @class('flex space-x-4')>
    <x-filament::section @class('section_widget_amber w-1/2')>
        <x-slot name="heading">
            {{$label1}}
        </x-slot>
        <div class="flex  space-x-10">
        @foreach($fathers as $father)

            <div class="text-center">
                <label>{{\App\Models\BloodType::find($father->father_blood_type)->name}}</label>
            </div>
        @endforeach
        </div>
        <div class="flex col space-x-10">
        @foreach($fathers as $father)
            <div class=" text-center">
                <span class="text-2xl text-amber-700 "> {{$father->count}} </span>
            </div>
        @endforeach
        </div>
    </x-filament::section>
    <x-filament::section @class('section_widget_amber w-1/2')>
        <x-slot name="heading">
            {{$label2}}
        </x-slot>
        <div class="flex  space-x-10">
            @foreach($mothers as $mother)

                <div class="text-center">
                    <label>{{\App\Models\BloodType::find($mother->mother_blood_type)->name}}</label>
                </div>
            @endforeach
        </div>
        <div class="flex col space-x-10">
            @foreach($mothers as $mother)
                <div class=" text-center">
                    <span class="text-2xl text-amber-700 "> {{$mother->count}} </span>
                </div>
            @endforeach
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
