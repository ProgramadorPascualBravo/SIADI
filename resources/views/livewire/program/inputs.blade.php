<div class="grid grid-cols-1 gap-2">
    <div class="block">
        <span >{{ __('modules.input.name') }}</span>
        <input type="text"
               class="@error('name') is-invalid-input @enderror input-underline" name="name" id="name" wire:model.defer="name">
        @error('name')
        <span class="form-error is-visible">{{ $message }}</span>
        @enderror
    </div>
    <div class="block">
        <span >{{ __('modules.input.code') }}</span>
        <input type="text"
               class="@error('code') is-invalid-input @enderror input-underline" name="code" id="code" wire:model.defer="code">
        @error('code')
        <span class="form-error is-visible">{{ $message }}</span>
        @enderror
    </div>
    <div class="block">
        <span >{{ __('modules.input.faculty') }}</span>
        <input type="text"
               class="@error('faculty') is-invalid-input @enderror input-underline" name="faculty" id="faculty" wire:model.defer="faculty">
        @error('faculty')
            <span class="form-error is-visible">{{ $message }}</span>
        @enderror
    </div>
    <label class="block">
        <span >{{ __('modules.category.name') }}</span>
        <select class="@error('department_id') is-invalid-input @enderror input-underline" name="department_id" id="department_id" wire:model.defer="department_id">
            <option value="">Seleccione una opción</option>
            @foreach($departments as $department)
                <option value="{{ $department->id }}">{{ $department->name }}</option>
            @endforeach
        </select>
        @error('department_id')
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
