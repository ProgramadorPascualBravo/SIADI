@if($column['hidden'])
@else
<div class="relative table-cell h-12 overflow-hidden align-top">
    <button wire:click.prefetch="sort('{{ $index }}')" class="w-full h-full bg-gradient-to-t from-gray-200 to-white px-6 py-5 border-b border-gray-200 text-left text-base leading-4 text-siadi-blue-900 capitalize tracking-wider flex items-center focus:outline-none @if($column['contentAlign'] === 'right') flex justify-end @elseif($column['contentAlign'] === 'center') flex justify-center @endif">
        <span class="inline ">{{ str_replace('_', ' ', $column['label']) }}</span>
        <span class="inline text-base text-siadi-blue-700">
            @if($sort === $index)
            @if($direction)
            <x-icons.chevron-up wire:loading.remove class="h-6 w-6 text-green-600 stroke-current" />
            @else
            <x-icons.chevron-down wire:loading.remove class="h-6 w-6 text-green-600 stroke-current" />
            @endif
            @endif
        </span>
    </button>
</div>
@endif

