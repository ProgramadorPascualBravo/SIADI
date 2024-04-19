<div class="grid grid-cols-1 gap-2">
    <div class="block">
        <span >{{ __('modules.input.names') }}</span>
        <input type="text"
               class="@error('name') is-invalid-input @enderror input-underline" name="name" id="name" wire:model.defer="name" autocomplete="off">
        @error('name')
            <span class="form-error is-visible">{{ $message }}</span>
        @enderror
    </div>
    <div class="block">
        <span >{{ __('modules.input.last_name') }}</span>
        <input type="text"
               class="@error('last_name') is-invalid-input @enderror input-underline" name="last_name" id="last_name" wire:model.defer="last_name" autocomplete="off">
        @error('last_name')
            <span class="form-error is-visible">{{ $message }}</span>
        @enderror
    </div>
    <div class="block">
        <span >{{ __('modules.input.email') }}</span>
        <input type="text"
               class="@error('email') is-invalid-input @enderror input-underline" name="email" id="email" wire:model.defer="email" autocomplete="off" {{ $enrollment > 0 ? 'readonly' : '' }}>
        @error('email')
            <span class="form-error is-visible">{{ $message }}</span>
        @enderror
    </div>
    <div class="block">
        <span >{{ __('modules.input.document') }}</span>
        <input type="number"
               class="@error('document') is-invalid-input @enderror input-underline" name="document" id="document" wire:model.defer="document" autocomplete="off">
        @error('document')
            <span class="form-error is-visible">{{ $message }}</span>
        @enderror
    </div>
    {{-- <div class="medium-12 cell">
        <label for="department_id">Departamento
            <select class="@error('department_id') is-invalid-input @enderror" name="department_id" id="department_id" wire:model.defer="department_id">
                <option value="">Seleccione una opción</option>
                @foreach($departments as $department)
                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                @endforeach
            </select>
            @error('department_id')
            <span class="form-error is-visible">{{ $message }}</span>
        @enderror
    </div> --}}
<!-- Nuevos bloques personalmail, phone y cellphone -->
<div class="block">
        <span >Correo Personal</span>
        <input type="text"
               class="@error('personalmail') is-invalid-input @enderror input-underline" name="personalmail" id="personalmail" wire:model.defer="personalmail">
        @error('personalmail')
            <span class="form-error is-visible">{{ $message }}</span>
        @enderror
    </div>

    <div class="block">
        <span >Telefono Fijo</span>
        <input type="text"
               class="@error('phone') is-invalid-input @enderror input-underline" name="phone" id="phone" wire:model.defer="phone">
        @error('phone')
            <span class="form-error is-visible">{{ $message }}</span>
        @enderror
    </div>

    <div class="block">
        <span >Telefono Celular</span>
        <input type="text"
               class="@error('cellphone') is-invalid-input @enderror input-underline" name="cellphone" id="cellphone" wire:model.defer="cellphone">
        @error('cellphone')
            <span class="form-error is-visible">{{ $message }}</span>
        @enderror
    </div>
    <!-- Fin Nuevos bloques -->
    
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
