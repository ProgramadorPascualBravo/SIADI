<div x-data="{ show: false }" class="flex flex-col items-center">
    <div class="flex flex-col items-center relative">
        <button x-on:click="show = !show" class="p-2 mb-2 border border-siadi-blue-300 rounded-md bg-siadi-blue-300 text-white text-xs leading-4 font-medium uppercase tracking-wider focus:outline-none">
            <div class="flex items-center h-5">
                Mostrar / Ocultar columnas
            </div>
        </button>
        <div x-show="show" x-on:click.away="show = false" class="z-50 absolute mt-16 mr-4 shadow-2xl top-100 bg-white z-40 w-96 right-0 rounded max-h-select overflow-y-auto" x-cloak>
            <div class="flex flex-col w-full">
                @foreach($this->columns as $index => $column)
                <div>
                    <div class="@unless($column['hidden']) hidden @endif cursor-pointer w-full border-gray-800 border-b bg-siadi-blue-100 text-siadi-blue-700 font-medium hover:bg-siadi-blue-300 hover:text-white" wire:click="toggle({{$index}})">
                        <div class="relative flex w-full items-center p-2 group">
                            <div class=" w-full items-center flex">
                                <div class="mx-2 leading-6">{{ $column['label'] }}</div>
                            </div>
                            <div class="absolute inset-y-0 right-0 pr-2 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="@if($column['hidden']) hidden @endif cursor-pointer w-full border-gray-800 border-b bg-siadi-blue-500 text-white hover:bg-red-600" wire:click="toggle({{$index}})">
                        <div class="relative flex w-full items-center p-2 group">
                            <div class=" w-full items-center flex">
                                <div class="mx-2 leading-6">{{ $column['label'] }}</div>
                            </div>
                            <div class="absolute inset-y-0 right-0 pr-2 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<style>
    .top-100 {
        top: 100%
    }

    .bottom-100 {
        bottom: 100%
    }

    .max-h-select {
        max-height: 300px;
    }

</style>
