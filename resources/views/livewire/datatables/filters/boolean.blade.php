<div x-data class="flex flex-col">
    <select
        x-ref="select"
        name="{{ $name }}"
        class="m-1 text-sm leading-4 flex-grow form-select border border-siadi-blue-300 text-siadi-blue-700"
        wire:input="doBooleanFilter('{{ $index }}', $event.target.value)"
        x-on:input="$refs.select.value=''"
    >
        <option value=""></option>
        <option value="0">Desactivado</option>
        <option value="1">Activado</option>
    </select>

    <div class="flex flex-wrap max-w-48 space-x-1">
        @isset($this->activeBooleanFilters[$index])
        @if($this->activeBooleanFilters[$index] == 1)
        <button wire:click="removeBooleanFilter('{{ $index }}')"
            class="m-1 pl-1 flex items-center uppercase tracking-wide bg-siadi-blue-300 text-white hover:bg-red-600 rounded-full focus:outline-none text-xs space-x-1">
            <span>Activado</span>
            <x-icons.x-circle />
        </button>
        @elseif(strlen($this->activeBooleanFilters[$index]) > 0)
        <button wire:click="removeBooleanFilter('{{ $index }}')"
            class="m-1 pl-1 flex items-center uppercase tracking-wide bg-siadi-blue-300 text-white hover:bg-red-600 rounded-full focus:outline-none text-xs space-x-1">
            <span>Desactivado</span>
            <x-icons.x-circle />
        </button>
        @endif
        @endisset
    </div>
</div>