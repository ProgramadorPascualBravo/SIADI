<div class="grid grid-cols-1 gap-2">
    <label class="block">
        <span>{{ __('modules.group.name') }}</span>
        <input type="text" class="@error('code') is-invalid-input @enderror input-underline" name="code" id="code" wire:model.defer="code" {{ $view == 'edit' ? 'disabled' : '' }} />
        @error('code')
            <span class="form-error is-visible">{{ $message }}</span>
        @enderror
    </label>
    <div class="block">
        <span >{{ __('modules.input.email') }}</span>
        <input type="email"
               class="@error('email') is-invalid-input @enderror input-underline" name="email" id="email" wire:model.defer="email" {{ $view == 'edit' ? 'disabled' : '' }}>
        @error('email')
            <span class="form-error is-visible">{{ $message }}</span>
        @enderror
    </div>
    <label class="block">
        <span >{{ __('modules.input.period') }}</span>
        <select class="@error('period') is-invalid-input @enderror input-underline" name="period" id="period" wire:model.defer="period">
            <option value="">Seleccione una opción</option>
            <option value="{{ date('Y') }}1">1</option>
            <option value="{{ date('Y') }}2">2</option>
            <option value="{{ date('Y') }}3">3</option>
            <option value="{{ date('Y') }}4">4</option>
            <option value="{{ date('Y') }}5">5</option>
            <option value="{{ date('Y') }}6">6</option>
        </select>
        @error('period')
        <span class="form-error is-visible">{{ $message }}</span>
        @enderror
    </label>
    <label class="block">
        <span >{{ __('modules.role-moodle.name') }}</span>
        <select class="@error('rol') is-invalid-input @enderror input-underline" name="rol" id="rol" wire:model.defer="rol">
            <option value="">Seleccione una opción</option>
            @foreach($roles as $rol)
                <option value="{{ $rol->name }}">{{ $rol->name }}</option>
            @endforeach
        </select>
        @error('rol')
            <span class="form-error is-visible">{{ $message }}</span>
        @enderror
    </label>
    <label class="block">
        <span >{{ __('modules.state-enrollment.name') }}</span>
        <select class="@error('state') is-invalid-input @enderror input-underline" name="state" id="state" wire:model.defer="state">
            <option value="">Seleccione una opción</option>
            @foreach($states as $state)
                <option value="{{ $state->id }}">{{ $state->name }}</option>
            @endforeach
        </select>
        @error('state')
            <span class="form-error is-visible">{{ $message }}</span>
        @enderror
    </label>
</div>
