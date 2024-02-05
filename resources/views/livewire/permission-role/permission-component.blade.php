<div>
    @include("sessions.session-input")
    <div class="grid grid-cols-4 gap-2">
        <div class="col-span-2 my-3">
                <h2 class="font-normal text-2xl mb-4 w-max border-b-2 border-siadi-blue-300">Seleccionar el rol para asignar permiso.</h2>
                <label class="block w-72">
                    <span class="text-gray-700">Roles</span>
                    <select class="@error('rol_id') is-invalid-input @enderror input-underline" name="rol_id" id="rol_id" wire:model.defer="rol_id" wire:change="change">
                        <option value="">Seleccione una opción</option>
                        @foreach($roles as $rol)
                            <option value="{{ $rol->id }}">{{ $rol->name }}</option>
                        @endforeach
                    </select>
                    @error('rol')
                    <span class="form-error is-visible">{{ $message }}</span>
                    @enderror
                </label>
        </div>
        <div class="col-span-2">
            <a href="{{ asset('img/permisos.JPG') }}" target="_blank" class="rounded-lg shadow-lg p-5 text-sm uppercase border-gray-300 border cursor-pointer">
                Descripción de los permisos
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-siadi-blue-300" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                </svg>
            </a>
        </div>
        @if (Auth::user()->can('permission_write'))
        <div class="col-span-4 pl-4 mt-1 flex flex-row-reverse">
            <button class="btn btn-red inline-flex" type="submit" wire:click="cancel">Cancelar</button>
            @if($view == 'create')
                <button class="btn btn-blue-light inline-flex" type="submit" wire:click="store">Crear</button>
            @else
                <button class="btn btn-blue-light inline-flex" type="submit" wire:click="update">Actualizar</button>
            @endif
                <input type="text"
                   class="@error('name') is-invalid-input @enderror inline-flex" name="name" id="name" wire:model.defer="name">
        </div>
        @endif
        <div class="col-span-4 px-4">
            <livewire:permission-table />
        </div>
    </div>
</div>