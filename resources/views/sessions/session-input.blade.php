<div class="fixed w-screen bottom-0 left-0 h-auto rounded p-5 bg-green-500 bg-opacity-75 z-50"
     x-transition:enter="ease-out duration-300"
     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
     x-transition:leave="ease-in duration-200"
     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
     x-data="{ open : false }"
     x-show="open"
     x-init="@this.on('alert-success', () => { open = true; setTimeout(() => { open = false; }, 2500) })"
     x-cloak>
     <div class="text-right block text-green-800 text-xl font-bold"><a @click="open = false" class="cursor-pointer"><i class="fi-x"></i></a></div>
     <h3 class="font-bold text-2xl text-green-900 underline mb-2">Éxito</h3>
     <p class="text-xl text-white font-bold">
         {{ $message }}
     </p>
</div>
<div class="fixed w-screen bottom-0 left-0 h-auto rounded p-5 bg-red-500 bg-opacity-75 z-50"
     x-transition:enter="ease-out duration-300"
     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
     x-transition:leave="ease-in duration-200"
     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
     x-data="{ open : false }"
     x-show="open"
     x-init="@this.on('alert-error', () => { open = true; setTimeout(() => { open = false; }, 2500) })"
     x-cloak>
    <div class="text-right block"><a @click="open = false" class="cursor-pointer"><i class="fi-x"></i></a></div>
    <h3 class="font-bold text-2xl text-red-900 underline">Error</h3>
    <p class="text-xl text-white font-bold">
        {{ $message }}
    </p>
</div>
<div class="fixed w-screen bottom-0 left-0 h-auto rounded p-5 bg-blue-500 bg-opacity-75 z-50"
     x-transition:enter="ease-out duration-300"
     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
     x-transition:leave="ease-in duration-200"
     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
     x-data="{ open : false }"
     x-show="open"
     x-init="@this.on('alert-info', () => { open = true; setTimeout(() => { open = false; }, 2500) })"
x-cloak>
    <div class="text-right block"><a @click="open = false" class="cursor-pointer"><i class="fi-x"></i></a></div>
    <h3 class="font-bold text-2xl text-white underline">Informativo</h3>
    <p class="text-xl text-white font-bold">
        {{ $message }}
    </p>
</div>
