<x-filament-widgets::widget>
    <div >
        <x-filament::section @class('section_widget_amber')>
            <x-slot name="heading" >

                    {{$label}}


            </x-slot>
            <div class="flex space-x-16">
                <div class="text-center">
                    <x-filament::icon-button
                        icon="heroicon-m-check"
                        label="New label"
                        color="success"
                        size="xl"
                    />
                </div>
                <div class="text-center">
                    <x-filament::icon-button
                        icon="heroicon-m-x-mark"
                        label="New label"
                        color="danger"
                        size="xl"
                    />
                </div>
            </div>
            <div class="flex space-x-16">
                <div class="text-center">
                    <span class="text-2xl"> {{$yes}} </span>
                </div>
                <div class="text-center">
                    <span class="text-2xl"> {{$no}} </span>
                </div>
            </div>



        </x-filament::section>
    </div>

</x-filament-widgets::widget>
