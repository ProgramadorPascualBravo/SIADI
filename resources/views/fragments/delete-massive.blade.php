
<div x-data="{ open: {{ isset($open) && $open ? 'true' : 'false' }}, working: false }" x-cloak wire:key="{{ $relation }}">
    @if ($destroy)
        <div x-on:click="open = true"
             class="shadow-lg border border-gray-300 w-max pl-2 hover:bg-red-100 rounded-lg mb-2 cursor-pointer">
            <span class="py-2 inline-block rounded-l-lg text-xs uppercase">
                Eliminar seleccionados
            </span>
            <div class="bg-siadi-red text-white inline-block p-2 rounded-r-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
            </div>
        </div>
    @endif
    <div x-show="open"
         class="fixed z-50 bottom-0 inset-x-0 px-4 pb-4 sm:inset-0 sm:flex sm:items-center sm:justify-center">
        <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
             class="fixed inset-0 transition-opacity">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>

        <div x-show="open" x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             class="relative bg-gray-100 rounded-lg px-4 pt-5 pb-4 overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full sm:p-6">
            <div class="hidden sm:block absolute top-0 right-0 pt-4 pr-4">
                <button @click="open = false" type="button"
                        class="text-gray-400 hover:text-gray-500 focus:outline-none focus:text-gray-500 transition ease-in-out duration-150">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="w-full">
                <div class="mt-3 text-center">
                    <h3 class="text-lg leading-6 font-medium text-siadi-blue-900">
                        Eliminar registro
                    </h3>
                    <div class="mt-2">
                        <div class="mt-10 text-siadi-blue-700">
                            ¿Estas seguro?
                        </div>
                        <div class="mt-10 flex justify-center">
                            <span class="mr-2">
                                <button x-on:click="open = false" x-bind:disabled="working" class="w-32 rounded-md shadow-sm inline-flex justify-center items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-siadi-red focus:outline-none focus:border-gray-700 focus:shadow-outline-teal active:bg-gray-700 transition ease-in-out duration-150">
                                    No
                                </button>
                            </span>
                            <span x-on:click="open = false">
                                <button wire:click="deleteMassive('{{ $relation }}')" class="w-32 rounded-md shadow-sm inline-flex justify-center items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-siadi-blue-300 focus:outline-none focus:border-red-700 focus:shadow-outline-teal active:bg-blue-700 transition ease-in-out duration-150">
                                    Sí
                                </button>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
