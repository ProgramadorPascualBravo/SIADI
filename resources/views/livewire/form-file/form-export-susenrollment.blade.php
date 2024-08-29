<div class="col-span-1 flex flex-col items-center border-r border-siadi-blue-900">
    {{--<span>¿Tipo de plantilla?</span>
    <div class="flex my-3">
        <label for="anexo_user" class="mr-2">
            Básica
            <input class="text-siadi-green-500 h-6 w-6 cursor-pointer" type="radio" wire:model="type" name="type" value="1">
        </label>
        <label for="anexo_user" class="ml-2">
            Extendida
            <input class="text-siadi-red h-6 w-6 cursor-pointer" type="radio" wire:model="type" name="type" value="0">
        </label>
    </div>--}}
    <form wire:submit.prevent="analyze"
          x-data="{ isUploading: false, progress: 0 }"
          x-on:livewire-upload-start="isUploading = true"
          x-on:livewire-upload-finish="isUploading = false"
          x-on:livewire-upload-error="isUploading = false"
          x-on:livewire-upload-progress="progress = $event.detail.progress"
    >
        <div x-show="isUploading" class="fixed left-0 -top-2.5 w-screen">
            <progress max="100" class="border-green-300 h-2 w-screen" x-bind:value="progress"></progress>
        </div>

        <div>
            <div class="flex w-full bg-grey-lighter">
                <label class="w-full @if($file) bg-green-200 @endif flex block border-gray-300 border flex-col items-center p-4 text-siadi-blue-900 rounded-lg shadow-lg tracking-wide uppercase cursor-pointer">
                    <svg class="w-8 h-8" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                    </svg>
                    @if($file)
                        <span class="mt-2 text-xs text-center leading-normal">
                            {{ $file->getClientOriginalName() }}
                        </span>
                    @else
                        <span class="mt-2 text-base leading-normal">
                            Cargar archivo
                        </span>
                    @endif
                    <input type='file'  wire:model="file" name="file" class="hidden" />
                </label>
            </div>
        </div>
        <div class="m-2">
            @error('file') <span class="error">{{ $message }}</span> @enderror
        </div>
        <div class="flex justify-center">
            <button class="rounded-lg shadow-lg p-4 m-auto block text-sm uppercase border-gray-300 border cursor-pointer" type="submit" wire:loading.attr="disabled">
                Procesar archivo cargado
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-siadi-green-500" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>
    </form>
    <div wire:loading wire:target="file" class="text-center bg-green-600 text-white my-4 p-4 uppercase">
        Subiendo archivo &nbsp;
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 animate-ping" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
        </svg>
    </div>
    <div wire:loading wire:target="analyze" class="text-center bg-siadi-blue-500 text-white my-4 p-4 m-auto">
        Procesando archivo &nbsp;
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 animate-spin" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
        </svg>
    </div>
</div>
