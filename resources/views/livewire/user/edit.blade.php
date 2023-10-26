<div>
    <div wire:ignore.self >
        <h2>{{ __('modules.user.edit') }}</h2>
        <div>
            @include('livewire.user.inputs')
            @include('fragments.btn-update')
        </div>
    </div>
</div>
