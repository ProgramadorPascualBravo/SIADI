<div class="grid grid-cols-4 gap-4">
    @include('fragments.search-form')
    <div class="col-span-4">
        <h2 class="font-normal text-2xl mb-4 text-siadi-blue-900 border-siadi-blue-300 border-b-2 w-max">Criterio de búsqueda</h2>
        <div class="rounded-lg shadow-lg p-5 text-sm uppercase border-gray-300 border cursor-pointer w-max">
            Buscar por nombre y código.
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-siadi-blue-300" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
            </svg>
        </div>
        <br>
        @if($search_table != '' and $view == 'group')
            <livewire:group-search-table :params="$search_table" />
        @endif
    </div>
</div>