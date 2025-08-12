<div>
    @if(!\Illuminate\Support\Facades\Auth::user()->is_employee)
        <x-filament::link outlined icon="heroicon-m-bell" :href="route('viewcontact')"
                          tooltip="للإطلاع علي البريد الوارد ">
            البريد الوارد
        </x-filament::link>
    @endif
</div>
