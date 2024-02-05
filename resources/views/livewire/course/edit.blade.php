<div>
    <div wire:ignore.self >
        <h2>{{ __('modules.course.edit') }}</h2>
        <div>
            @include('livewire.course.inputs')
            @include('fragments.btn-update')
        </div>
    </div>
</div>
