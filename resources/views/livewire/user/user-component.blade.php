<div>
    @include("sessions.session-input")
    <div class="grid grid-cols-4 gap-2">
        <div class="@cannot('user_write') col-span-4 px-4 @endcan col-span-3 pl-4">
            <livewire:user-table :destroy="Auth::user()->can('user_destroy')" />
        </div>
        @can('user_write')
            <div class="col-span-1 content-form">
                @include("livewire.user.$view")
            </div>
        @endcan
    </div>
</div>
