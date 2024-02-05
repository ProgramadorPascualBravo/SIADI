<div class="grid grid-cols-5 gap-2">
    <div class="col-span-3 col-start-2 text-center pt-4 flex justify-center">
        <button wire:click="change('student')"
             class="border border-gray-300 w-max mr-5 pl-2 inline-block rounded-lg cursor-pointer hover:bg-gray-200 inline-block {{ $view == 'student' ? 'bg-gray-200' : '' }}">
            <span class="py-2 inline-block rounded-l-lg text-sm capitalize">
                {{ __('modules.moodle.pname') }}&nbsp;
            </span>
            <div class="bg-siadi-gray text-gray-100 inline-block p-2 rounded-r-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                </svg>
            </div>
        </button>
        <button wire:click="change('program')"
                class="border border-gray-300 w-max mr-5 pl-2 inline-block rounded-lg cursor-pointer hover:bg-gray-200 inline-block {{ $view == 'program' ? 'bg-gray-200' : '' }}">
            <span class="py-2 inline-block rounded-l-lg text-sm capitalize">
                {{ __('modules.program.pname') }}&nbsp;
            </span>
            <div class="bg-siadi-gray text-gray-100 inline-block p-2 rounded-r-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                </svg>
            </div>
        </button>
        <button wire:click="change('course')"
                class="border border-gray-300 w-max mr-5 pl-2 inline-block rounded-lg cursor-pointer hover:bg-gray-200 inline-block {{ $view == 'course' ? 'bg-gray-200' : '' }}">
            <span class="py-2 inline-block rounded-l-lg text-sm capitalize">
                {{ __('modules.course.pname') }}&nbsp;
            </span>
            <div class="bg-siadi-gray text-gray-100 inline-block p-2 rounded-r-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                </svg>
            </div>
        </button>
        <button wire:click="change('group')"
                class="border border-gray-300 w-max mr-5 pl-2 inline-block rounded-lg cursor-pointer hover:bg-gray-200 inline-block {{ $view == 'group' ? 'bg-gray-200' : '' }}">
            <span class="py-2 inline-block rounded-l-lg text-sm capitalize">
                {{ __('modules.group.pname') }}&nbsp;
            </span>
            <div class="bg-siadi-gray text-gray-100 inline-block p-2 rounded-r-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                </svg>
            </div>
        </button>
        <button wire:click="change('enrollment')"
                class="border border-gray-300 w-max mr-5 pl-2 inline-block rounded-lg cursor-pointer hover:bg-gray-200 inline-block {{ $view == 'enrollment' ? 'bg-gray-200' : '' }}">
            <span class="py-2 inline-block rounded-l-lg text-sm capitalize">
                {{ __('modules.enrollment.pname') }}&nbsp;
            </span>
            <div class="bg-siadi-gray text-gray-100 inline-block p-2 rounded-r-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                </svg>
            </div>
        </button>
    </div>
    @if(!empty($view))
        <div class="col-span-5 px-2">
            @include("livewire.search.$view")
        </div>
    @endif
</div>
