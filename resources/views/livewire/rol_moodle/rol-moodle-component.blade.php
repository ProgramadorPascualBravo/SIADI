    <div>
        @include("sessions.session-input")
        <div class="grid grid-cols-4 gap-2">
            <div class="@cannot('role_moodle_write') col-span-4 px-4 @endcan col-span-3 pl-4">
                <livewire:rol-moodle-table :destroy="Auth::user()->can('role_moodle_destroy')" />
            </div>
            @can('role_moodle_write')
                <div class="col-span-1 content-form">
                    @include("livewire.rol_moodle.$view")
                </div>
            @endcan
        </div>
    </div>
