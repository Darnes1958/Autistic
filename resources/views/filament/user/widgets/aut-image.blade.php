<x-filament-widgets::widget>
    <x-filament::section>

@if($image)
            <img class="h-auto max-w-full"
                 src="{{ asset('storage/'.$image[0]) }}" alt="description of myimage"

            />
@endif


    </x-filament::section>
</x-filament-widgets::widget>
