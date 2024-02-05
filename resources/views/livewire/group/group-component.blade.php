<div>
    @include("sessions.session-input")
    <div class="grid grid-cols-4 gap-2">

        <div class="@cannot('group_write') col-span-4 px-4 @endcan col-span-3 pl-4">
            <livewire:group-table :destroy="Auth::user()->can('group_destroy')" />
        </div>
        @can('group_write')
        <div class="col-span-1 content-form">
            @include("livewire.group.$view")
        </div>
        @endcan
    </div>
</div>