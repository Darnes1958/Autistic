<x-filament-widgets::widget>
<div class="flex flex-row justify-between items-start shrink-0">
    <div class="w-2/4 ">
        <span class="text-3xl font-bold">
            الهيئة الوطنية لعلاج وتأهيل أطفال التوحد
        </span>
        <br>
        <span class="text-lg  " style="color: #cc5500">
            بنغازي - ليبيا
        </span>

        <br>
        <br>

        <span class="text-lg text-black ">
            هذه الصفحة خاصة بــ
        </span>
        <br>
        <span class="text-3xl font-bold " style="color: #cc5500">
            {{\Illuminate\Support\Facades\Auth::user()->name}}
        </span>

    </div>
    <div class="w-1/4">


        <img class=" w-70 " src="{{ asset('img/natrac.png') }}"
             alt="image description">

    </div>
    <div class="w-1/4">
        @if($image)
            @php(info(storage_path('app\private\\'.$image[0])));
            <img class=" w-96 " src="{{  asset('images/'.$image[0])   }}"
                 alt="image description">
        @endif
    </div>
</div>

</x-filament-widgets::widget>
