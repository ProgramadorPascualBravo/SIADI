<div wire:poll.30s="someMethod">
@extends('layouts.app')

@section('content')
    {{ Breadcrumbs::render('dashboard.reports') }}

    <div class="grid grid-cols-1 gap-2 px-4">
        <div>
            <h1 class="font-medium text-4xl mt-4 mb-1 text-siadi-blue-900">Reportes nunca</h1>
            <hr class="border-siadi-blue-700">
        </div>

        <div>
            @livewire('report-detail-component')
        </div>
    </div>
@endsection
</div>
