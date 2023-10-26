<div class="grid grid-cols-1 gap-2">
    <div class="block">
        <span >{{ __('modules.input.code') }}</span>
        <input type="text"
               class="@error('name') is-invalid-input @enderror input-underline" name="name" id="name" wire:model.defer="name" {{ $enrollment > 0 ? 'readonly' : '' }}>
        @error('name')
        <span class="form-error is-visible">{{ $message }}</span>
        @enderror
    </div>
    <label class="block">
        <span >{{ __('modules.course.name') }}</span>
        <select class="@error('course_id') is-invalid-input @enderror input-underline" name="course_id" id="course_id" wire:model.defer="course_id">
            <option value="">Seleccione una opción</option>
            @foreach($courses as $course)
                <option value="{{ $course->id }}">{{ $course->name }}</option>
            @endforeach
        </select>
        @error('course_id')
            <span class="form-error is-visible">{{ $message }}</span>
        @enderror
    </label>
    <label class="block">
        <span >{{ __('modules.input.state') }}</span>
        <select class="@error('state') is-invalid-input @enderror input-underline" name="state" id="state" wire:model.defer="state">
            <option value="">Seleccione una opción</option>
            <option value="1">Activo</option>
            <option value="0">Desactivado</option>
        </select>
        @error('state')
        <span class="form-error is-visible">{{ $message }}</span>
        @enderror
    </label>
</div>
