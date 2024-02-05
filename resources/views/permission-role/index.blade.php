@extends('layouts.app')
@section('content')
    @if($option)
        {{ Breadcrumbs::render('permission') }}
    @else
        {{ Breadcrumbs::render('role') }}
    @endif

    <div class="grid grid-cols-1 gap-2 px-4">
        <div>
            <h1 class="font-medium text-4xl mt-4 my-4 text-siadi-blue-900">Módulo de Roles y Permisos</h1>
            <hr class="border-siadi-blue-700">
        </div>
        <div class="pt-5">
            <a href="{{ route('role-index') }}"
                    class="border w-48 border-gray-300 pl-2 inline-block hover:bg-blue-100 rounded-lg mb-4 {{ $option ? '' : 'bg-blue-100' }}">
                <span class="py-2 inline-block rounded-l-lg text-sm ">
                    Sección Roles&nbsp;
                </span>
                <div class="bg-siadi-blue-900 text-gray-100 inline-block p-2 rounded-r-lg float-right">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
            </a>
            <a href="{{ route('permission-index') }}"
               class="border w-48 border-gray-300 pl-2 inline-block hover:bg-blue-100 rounded-lg mb-4 {{ $option ? 'bg-blue-100' : '' }}">
                <span class="py-2 inline-block rounded-l-lg text-sm ">
                    Sección Permisos&nbsp;
                </span>
                <div class="bg-siadi-blue-900 text-gray-100 inline-block p-2 rounded-r-lg float-right">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                    </svg>
                </div>
            </a>
        </div>
        <div>
            @if($option)
                @livewire('permission-component')
            @else
                @livewire('role-component')
            @endif
        </div>
    </div>
@endsection
