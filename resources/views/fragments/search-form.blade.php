<div class="col-span-4 flex justify-center my-3">
    <div class="flex flex-col">
        <input type="text"
               class="@error('search') border-siadi-red @enderror border-2 border-siadi-blue-300 inline-flex"
               name="search" id="search" wire:model.defer="search"
               placeholder="Buscar..."
        >
        @error('search')
            <span class="form-error text-red-700 is-visible">{{ $message }}</span>
        @enderror
    </div>
    <button class="btn btn-blue" wire:click="search" wire:loading.attr="disabled">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
    </button>
    <div wire:loading wire:target="search" class="text-center bg-siadi-blue-300 font-bold text-white p-3">
        Buscando
        <x-icons.cog wire:loading class="h-4 w-4  animate-spin text-gray-400" style="display: inline-block" />
    </div>
</div>