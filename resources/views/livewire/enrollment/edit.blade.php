<div>
    <div wire:ignore.self >
        <h2>{{ __('modules.enrollment.edit') }}</h2>
        <div>
            @include('livewire.enrollment.inputs')
            @include('fragments.btn-update')
        </div>
    </div>
</div>
