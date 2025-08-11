<div>
@if(!\Illuminate\Support\Facades\Auth::user()->is_employee)
<x-filament::link outlined icon="heroicon-m-envelope" :href="route('filament.user.resources.contacts.create')"
                     tooltip="يمكنك كتابة أي معلومات أو إستفسارات هنا ">
    اتصل بنا
</x-filament::link>
@endif
</div>
