@extends('layouts.app')
@section('content')
    {{ Breadcrumbs::render('course-detail', $course) }}
    <div class="grid grid-cols-1 gap-2 px-4">
        <div>
            <h1 class="font-medium text-4xl mt-4 mb-1 text-siadi-blue-900">Detalle de la asignatura</h1>
            <hr class="border-siadi-blue-700">
        </div>
        <div>
            @livewire('course-detail-component', ['course' => $course] )
        </div>
    </div>
@endsection
