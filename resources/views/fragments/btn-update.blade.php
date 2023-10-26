<div class="text-right my-4 flex flex-row-reverse">
    <button class="btn btn-blue-light mr-0" wire:click="update">
        {{ __('modules.update') }}
    </button>
    <button class="btn btn-red" wire:click="cancel">
        <span>{{ __('modules.cancel') }}</span>
    </button>
    <div wire:loading wire:target="update" class="text-center bg-blue-600 font-bold text-white p-3">
        {{ Str::title(__('modules.updating')) }}
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 animate-spin" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
        </svg>
    </div>
</div>