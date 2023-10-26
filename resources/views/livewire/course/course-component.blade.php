<div>
    @include("sessions.session-input")
    <div class="grid grid-cols-4 gap-2">
        <div class="@cannot('course_write') col-span-4 px-4 @endcan col-span-3 pl-4">
            <livewire:course-table :destroy="Auth::user()->can('course_destroy')" />
        </div>
        @can('course_write')
            <div class="col-span-1 content-form">
                @include("livewire.course.$view")
            </div>
        @endcan
    </div>
</div>