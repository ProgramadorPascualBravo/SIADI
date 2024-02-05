<div>
    @include("sessions.session-input")
    <div class="grid grid-cols-4 gap-2">
        <div class="@cannot('state_enrollment_write') col-span-4 px-4 @endcan col-span-3 pl-4">
            <livewire:state-enrollment-table :destroy="Auth::user()->can('state_enrollment_destroy')"/>
        </div>
        @can('state_enrollment_write')
            <div class="col-span-1 content-form">
                @include("livewire.state-enrollment.$view")
            </div>
        @endcan
    </div>
</div>
