<div>
    <div wire:ignore.self >
        <h2>{{ __('modules.user.create') }}</h2>
        <div>
            @include('livewire.user.inputs')
            @include('fragments.btn-create')
        </div>
    </div>
</div>
