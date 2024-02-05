<div>
    @if($beforeTableSlot)
        <div class="mt-8">
            @include($beforeTableSlot)
        </div>
    @endif
        <div wire:loading.delay>
            <div style="position:absolute;background-color: transparent;z-index: 100;top:180px;left: 0;height: calc(100% + 120px);width: 100%;">
                <!-- <div style="display: flex; align-items: center; justify-content: center;height: 100%;">
                     <div role="status" style="    transform: scale(1.7);">
                         <svg aria-hidden="true" class="w-8 h-8 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                             <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#EEEEEE"/>
                             <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="#0E4D82"/>
                         </svg>
                         <span class="sr-only">Loading...</span>
                     </div>
                </div>-->
            </div>
        </div>


    <div class="relative">
        <div class="flex justify-between items-center mb-1">
            <div class="flex-grow h-10 flex items-center">
                @if($this->searchableColumns()->count())
                <div class="w-96 flex rounded-lg shadow-sm">
                    <div class="relative flex-grow focus-within:z-10">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" stroke="currentColor" fill="none">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input wire:model.debounce.500ms="search" class="form-input block bg-gray-100 focus:bg-white w-full pl-10 py-2 pr-10 my-3 transition ease-in-out duration-150 sm:text-sm sm:leading-5" placeholder="Buscar en {{ $this->searchableColumns()->map->label->join(', ') }}" />
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <button wire:click="$set('search', null)" class="text-gray-300 hover:text-red-600 focus:outline-none">
                                <x-icons.x-circle class="h-5 w-5 stroke-current" />
                            </button>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <div class="flex items-center space-x-1">
                <x-icons.cog wire:loading class="h-9 w-9 animate-spin text-gray-400" />

                @if($exportable)
                <div x-data="{ init() {
                    window.livewire.on('startDownload', link => window.open(link,'_blank'))
                } }" x-init="init" class="border border-gray-300 w-max pl-2 hover:bg-siadi-green-100 rounded-lg mb-2 cursor-pointer">
                    <button wire:click="export" class="py-2 inline-block rounded-l-lg font-weight-light text-xs uppercase">
                        <span>Exportar</span>
                    </button>
                    <div class="bg-siadi-green-100 text-black inline-block p-2 rounded-r-lg">
                        <x-icons.excel />
                    </div>
                </div>
                @endif

                @if($hideable === 'select')
                @include('datatables::hide-column-multiselect')
                @endif
            </div>
        </div>

        @if($hideable === 'buttons')
        <div class="p-2 grid grid-cols-8 gap-2">
            @foreach($this->columns as $index => $column)
            <button wire:click.prefetch="toggle('{{ $index }}')" class="px-3 py-2 rounded text-white text-xs focus:outline-none
            {{ $column['hidden'] ? 'bg-blue-100 hover:bg-blue-300 text-blue-600' : 'bg-blue-500 hover:bg-blue-800' }}">
                {{ $column['label'] }}
            </button>
            @endforeach
        </div>
        @endif

        <div class="rounded-lg shadow-lg bg-white max-w-screen overflow-x-scroll">
            <div class="rounded-lg @unless($this->hidePagination) rounded-b-none @endif">
                <div class="table align-middle min-w-full">
                    @unless($this->hideHeader)
                    <div class="table-row divide-x divide-gray-200">
                        @foreach($this->columns as $index => $column)
                            @if($hideable === 'inline')
                                @include('datatables::header-inline-hide', ['column' => $column, 'sort' => $sort])
                            @elseif($column['type'] === 'checkbox')
                            <div class="relative table-cell h-12 w-48 overflow-hidden align-top px-6 py-3 border-b border-gray-200 bg-gradient-to-t from-gray-200 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider flex items-center focus:outline-none">
                                <div class="px-3 py-1 rounded @if(count($selected)) bg-siadi-blue-300 @else bg-siadi-blue-300 @endif text-white text-center">
                                    {{ count($selected) }}
                                </div>
                            </div>
                            @else
                                @include('datatables::header-no-hide', ['column' => $column, 'sort' => $sort])
                            @endif
                        @endforeach
                    </div>

                    <div class="table-row divide-x divide-blue-200 bg-siadi-blue-100">
                        @foreach($this->columns as $index => $column)
                            @if($column['hidden'])
                                @if($hideable === 'inline')
                                    <div class="table-cell w-5 overflow-hidden align-top bg-siadi-blue-100"></div>
                                @endif
                            @elseif($column['type'] === 'checkbox')
                                <div class="overflow-hidden align-top bg-blue-100 py-5 border-b border-gray-200 bg-siadi-blue-100 text-left text-xs leading-4 font-medium text-siadi-blue-700 uppercase tracking-wider flex h-full flex-col items-center space-y-2 focus:outline-none">
                                    <div class="text-center">Seleccionar Todo</div>
                                    <div>
                                        <input type="checkbox" wire:click="toggleSelectAll" @if(count($selected) === $this->results->total()) checked @endif class="form-checkbox mt-1 h-4 w-4 text-blue-600 transition duration-150 ease-in-out" />
                                    </div>
                                </div>
                            @else
                                <div class="table-cell overflow-hidden align-top">
                                    @isset($column['filterable'])
                                        @if( is_iterable($column['filterable']) )
                                            <div wire:key="{{ $index }}">
                                                @include('datatables::filters.select', ['index' => $index, 'name' => $column['label'], 'options' => $column['filterable']])
                                            </div>
                                        @else
                                            <div wire:key="{{ $index }}">
                                                @include('datatables::filters.' . ($column['filterView'] ?? $column['type']), ['index' => $index, 'name' => $column['label']])
                                            </div>
                                        @endif
                                    @endisset
                                </div>
                            @endif
                        @endforeach
                    </div>
                    @endif
                    @forelse($this->results as $result)
                        <div class="table-row p-1 divide-x divide-gray-100 {{ isset($result->checkbox_attribute) && in_array($result->checkbox_attribute, $selected) ? 'bg-orange-100' : ($loop->even ? 'bg-gray-100' : 'bg-gray-50') }}">
                            @foreach($this->columns as $column)
                                @if($column['hidden'])
                                    @if($hideable === 'inline')
                                    <div class="table-cell w-5 overflow-hidden align-top"></div>
                                    @endif
                                @elseif($column['type'] === 'checkbox')
                                    @include('datatables::checkbox', ['value' => $result->checkbox_attribute])
                                @else
                                    <div class="px-6 py-2 whitespace-no-wrap text-sm leading-5 text-siadi-blue-700 table-cell @if($column['contentAlign'] === 'right') text-right @elseif($column['contentAlign'] === 'center') text-center @else text-left @endif">
                                        {!! $result->{$column['name']} !!}
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @empty
                        <p class="p-3 text-lg text-teal-600">
                            No hay nada que mostrar en este momento
                        </p>
                    @endforelse
                </div>
            </div>
            @unless($this->hidePagination)
            <div class="rounded-lg rounded-t-none max-w-screen rounded-lg border-b border-gray-200 bg-white">
                <div class="p-2 sm:flex items-center justify-between">
                    {{-- check if there is any data --}}
                     {{--@if($this->results[1])--}}
                        <div class="my-2 sm:my-0 flex items-center">
                            <select name="perPage" class="mt-1 form-select block w-full pl-3 pr-10 py-2 text-base leading-6 border-gray-300 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5" wire:model="perPage">
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                                <option value="99999999">Todo</option>
                            </select>
                        </div>

                        <div class="my-4 sm:my-0">
                            <div class="lg:hidden">
                                <span class="space-x-2">{{ $this->results->links('datatables::tailwind-simple-pagination') }}</span>
                            </div>

                            <div class="hidden lg:flex justify-center">
                                <span>{{ $this->results->links('datatables::tailwind-pagination') }}</span>
                            </div>
                        </div>

                        <div class="flex justify-end text-siadi-blue-700">
                            Resultados {{ $this->results->firstItem() }} - {{ $this->results->lastItem() }} of
                            {{ $this->results->total() }}
                        </div>
                    {{--@endif--}}
                </div>
            </div>
            @endif
        </div>
    </div>
    @if($afterTableSlot)
    <div class="mt-8">
        @include($afterTableSlot)
    </div>
    @endif
</div>
