<div class="m-4" style="box-shadow: 0px 4px 4px 2px #ccc;">
    <a href="{{ route($route) }}"
       class="w-48 bg-white text-blue-700 inline-flex justify-center text-center px-2 flex-col">
        <h3 class="text-5xl	text-white font-medium w-24 bg-siadi-blue-500 m-auto">
            {{ $eloquent::month()->get()->count() }}
        </h3>
        <p class="text-lg text-siadi-blue-500 my-2">
            {{ $title }}
        </p>
    </a>
    <hr class="border-siadi-gray">
    <a href="{{ route($route) }}"
       class="w-full block text-center text-lg py-4 bg-gradient-to-t from-gray-300 to-gray-100">
        {{  \App\View\Components\StatsCurrentMonthComponent::getMonth(now()->format('m')) }}
    </a>
</div>