@extends('layouts.app')
@section('content')
    {{ Breadcrumbs::render('students-report') }}
    <div class="grid grid-cols-5 gap-4 px-4">
        <div class="col-span-5 mb-3">
            <h1 class="font-medium text-4xl mt-4 mb-1 text-siadi-blue-900">{{ __('modules.stats') }}</h1>
            <hr class="border-siadi-blue-700">
        </div>
        <div class="col-span-4 pl-2">
            {!! $chartstate->container() !!}
        </div>
        <div class="col-span-1 pr-2">
            {!! $charttotal->container() !!}
        </div>
    </div>
@endsection
@push('custom-script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/6.0.6/highcharts.js" charset="utf-8"></script>
{!! $chartstate->script() !!}
{!! $charttotal->script() !!}
@endpush