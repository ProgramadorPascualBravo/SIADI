<div class="grid grid-cols-1 gap-2">
    <div class="block">
        <span >{{ __('modules.input.code') }}</span>
        <input type="text"
               class="@error('name') is-invalid-input @enderror input-underline" name="name" id="name" wire:model.defer="name" {{ $enrollment > 0 ? 'readonly' : '' }}>
        @error('name')
        <span class="form-error is-visible">{{ $message }}</span>
        @enderror
    </div>
    <!-- Bloque Nuevo URL del curso-->
    <div class="block">
    <label for="course_url">URL del curso</label>
    <input type="text" class="@error('course_url') is-invalid-input @enderror input-underline" name="course_url" id="course_url" wire:model.defer="course_url">
    @error('course_url')
    <span class="form-error is-visible">{{ $message }}</span>
    @enderror
</div>
    <!-- Fin URL del curso-->
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
    <!-- Bloque Nuevo URL del curso-->
    <label class="block">
        <span >Entrega del grupo</span>
        <select class="@error('course_state') is-invalid-input @enderror input-underline" name="course_state" id="course_state" wire:model.defer="course_state">
            <option value="">Seleccione una opción</option>
            <option value="SI">Si</option>
            <option value="NO">No</option>
        </select>
        @error('course_state')
        <span class="form-error is-visible">{{ $message }}</span>
        @enderror
    </label>
    <!-- Fin URL del curso-->
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
