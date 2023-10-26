@extends('layouts.app')
@section('content')
    {!! $chart->container() !!}
@endsection
@push('custom-script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/6.0.6/highcharts.js" charset="utf-8"></script>
    {!! $chart->script() !!}
@endpush