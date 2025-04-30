<x-filament-widgets::widget>
    @if($image)
    <x-filament::section>
        <div class="w-full">
            <figure class="w-1/2">
                <img class="h-auto max-w-full  rounded-lg" src="{{ asset('storage/'.$image[0]) }}"
                     alt="image description">
                <figcaption class="mt-2 text-sm text-center text-gray-500 dark:text-gray-400">{{$name}}</figcaption>
            </figure>
        </div>





    </x-filament::section>
    @endif
</x-filament-widgets::widget>
