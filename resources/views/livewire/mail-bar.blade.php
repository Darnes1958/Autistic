<div>
    @if(!\Illuminate\Support\Facades\Auth::user()->is_employee)
        <x-filament::link outlined icon="heroicon-m-bell" badge-color="success"
                          :href="route('filament.user.resources.contact-trans.index')"
                          tooltip="يمكنك كتابة أي معلومات أو إستفسارات هنا ">
            البريد الوارد
            <x-slot name="badge">
                {{$count}}
            </x-slot>
        </x-filament::link>

    @endif
</div>
