<div class="grid grid-cols-1 gap-2">
    <div class="block">
        <span >{{ __('modules.input.name') }}</span>
        <input type="text"
               class="@error('name') is-invalid-input @enderror input-underline" name="name" id="name" wire:model.defer="name">
        @error('name')
        <span class="form-error is-visible">{{ $message }}</span>
        @enderror
    </div>
    <label class="block">
        <span >{{ __('modules.input.state') }}</span>
        <select class="@error('state') is-invalid-input @enderror input-underline" name="state" id="state" wire:model.defer="state">
            <option selected value="">Seleccione una opción</option>
            <option value="1">Activo</option>
            <option value="0">Desactivado</option>
        </select>
        @error('state')
            <span class="form-error is-visible">{{ $message }}</span>
        @enderror
    </label>
</div>
