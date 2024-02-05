<div>
    @include("sessions.session-input")
    <div class="grid grid-cols-4 gap-2">
        @can('moodle_massive')
            <div class="col-span-4 text-right pr-4">
                <a href="{{ route('moodle-mass-creation') }}" class="btn w-max bg-gray-800 text-white">{{ __('modules.massive.name') }}</a>
            </div>
        @endcan
        <div class="@cannot('moodle_write') col-span-4 px-4 @endcan col-span-3 pl-4">
            <livewire:student-table :destroy="Auth::user()->can('moodle_destroy')"/>
        </div>
        @can('moodle_write')
            <div class="col-span-1 content-form">
                @include("livewire.student.$view")
            </div>
        @endcan
    </div>
</div>
