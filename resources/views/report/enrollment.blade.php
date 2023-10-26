@extends('layouts.app')
@section('content')
    {{ Breadcrumbs::render('enrollment-report') }}
    <div class="grid grid-cols-5 gap-4 px-4">
        <div class="col-span-5 mb-3">
            <h1 class="font-medium text-4xl mt-4 mb-1 text-siadi-blue-900">{{ __('modules.stats') }}</h1>
            <hr class="border-siadi-blue-700">
        </div>
        <div class="col-span-1 pl-2">
            <div>
                <table class="table-view">
                    <caption>Matrículas por estado</caption>
                    <thead>
                        <tr>
                            <th class="text-left p-3">Estado</th>
                            <th class="text-center">Valor</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($states as $state)
                        <tr>
                            <td>{{ $state->name }}</td>
                            <td class="text-center font-bold">{{ $state->enrollments->count() }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div>
                {!! $charttotal->container() !!}
            </div>
        </div>
        <div class="col-span-4 pr-2 col-row-2">
            {!! $chartstate->container() !!}
        </div>

    </div>
@endsection
@push('custom-script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/6.0.6/highcharts.js" charset="utf-8"></script>
{!! $chartstate->script() !!}
{!! $charttotal->script() !!}
@endpush