<x-filament-widgets::widget>
    <x-filament::section>

@if($image)
    <figure class="max-w-lg">
        <img class="h-auto max-w-full rounded-lg" src="{{ asset('storage/'.$image[0]) }}"
             alt="image description">
        <figcaption class="mt-2 text-sm text-center text-gray-500 dark:text-gray-400">{{$name}}</figcaption>
    </figure>
@endif


    </x-filament::section>
</x-filament-widgets::widget>
