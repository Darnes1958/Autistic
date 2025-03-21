<x-filament-widgets::widget>
    <x-filament-widgets::widget>
        @if($image )
            <x-filament::section>


                <figure class="max-w-lg">
                    <img class="h-auto max-w-full rounded-lg" src="{{ asset('storage/'.$image) }}"
                         alt="image description">

                </figure>

            </x-filament::section>
        @endif



    </x-filament-widgets::widget>
</x-filament-widgets::widget>
