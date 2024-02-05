    <div>
        @include("sessions.session-input")
        <div class="grid grid-cols-4 gap-2">
            <div class="@cannot('program_write') col-span-4 px-4 @endcan col-span-3 pl-4">
                <livewire:program-table :destroy="Auth::user()->can('program_destroy')" />
            </div>
            @can('program_write')
                <div class="col-span-1 content-form">
                    @include("livewire.program.$view")
                </div>
            @endcan
        </div>
    </div>
