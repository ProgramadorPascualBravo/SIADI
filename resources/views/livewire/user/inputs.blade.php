<div class="grid grid-cols-1 gap-2">
    <label class="block">
        <span class=" ">{{ __('modules.input.name') }}</span>
        <input type="text"
               class="@error('name') is-invalid-input @enderror input-underline" name="name" id="name" wire:model.defer="name" autocomplete="off">
        @error('name')
            <span class="form-error is-visible">{{ $message }}</span>
        @enderror
    </label>
    <label class="block">
        <span class=" ">{{ __('modules.input.last_name') }}</span>
        <input type="text"
               class="@error('last_name') is-invalid-input @enderror input-underline" name="last_name" id="last_name" wire:model.defer="last_name" autocomplete="off">
        @error('last_name')
        <span class="form-error is-visible">{{ $message }}</span>
        @enderror
    </label>
    <label class="block">
        <span class=" ">{{ __('modules.input.document') }}</span>
        <input type="number"
               class="@error('document') is-invalid-input @enderror input-underline" name="document" id="document" wire:model.defer="document" autocomplete="off">
        @error('document')
        <span class="form-error is-visible">{{ $message }}</span>
        @enderror
    </label>
    <label class="block">
        <span class=" ">{{ __('modules.input.email') }}</span>
        <input type="email"
               class="@error('username') is-invalid-input @enderror input-underline" name="username" id="username" wire:model.defer="username" autocomplete="off">
        @error('username')
        <span class="form-error is-visible">{{ $message }}</span>
        @enderror
    </label>
    <label class="block">
        <span class=" ">{{ __('modules.category.name') }}</span>
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
        <span class=" ">{{ __('modules.input.state') }}</span>
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
