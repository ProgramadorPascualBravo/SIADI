@extends('layouts.app')
@section('content')
    {{ Breadcrumbs::render('program-detail', $program) }}
    <div class="grid grid-cols-1 gap-2 px-4">
        <div>
            <h1 class="font-medium text-4xl mt-4 mb-1 text-siadi-blue-900">Detalle del programa</h1>
            <hr class="border-siadi-blue-700">
        </div>
        <div>
            @livewire('program-detail-component', ['program' => $program] );
        </div>
    </div>
@endsection
