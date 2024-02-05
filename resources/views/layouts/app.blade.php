<!doctype html>


<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/foundation-icons/foundation-icons.css') }}">
    <!--<link href="{{ asset('css/app.scss') }}" rel="stylesheet">-->
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
    @stack('custom-css')
    @livewireStyles

    <style>[x-cloak] { display: none!important }</style>

</head>
<body class="flex flex-col min-h-screen ">
<header>
    <nav class="flex items-center bg-siadi-blue-900 p-4 text-white">
        <div class="flex items-center flex-shrink-0 text-white mr-6">
            <span class="font-semibold text-xl tracking-tight">
                 @if(isset($_GET['egg']))
                    <a href="{{ route('dashboard') }}" class="text-siadi-yellow">SUANFOSON</a>
                @else
                    <a href="{{ route('dashboard') }}" class="text-siadi-yellow">SIADI</a>
                @endif
            </span>
        </div>
        <div class="mr-6 relative" x-data="{ open : false}" x-cloak>
            <a @click="open = true" class="cursor-pointer">
                Módulos
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </a>

                <ul x-show="open"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform scale-90"
                    x-transition:enter-end="opacity-100 transform scale-100"
                    x-transition:leave="transition ease-in duration-300"
                    x-transition:leave-start="opacity-100 transform scale-100"
                    x-transition:leave-end="opacity-0 transform scale-90" @click.away="open = false" class="absolute bg-gray-800 rounded w-max z-30">
                    @can('user_read')
                        <li><a class="block my-4 w-full px-4 py-2 hover:bg-gray-100 hover:text-gray-800" href="{{ route('user-index') }}">Usuarios SIADI</a></li>
                    @endcan
                    @can('moodle_read')
                        <li><a class="block my-4 w-full px-4 py-2 hover:bg-gray-100 hover:text-gray-800" href="{{ route('moodle-index') }}">Usuarios Plataforma</a></li>
                    @endcan
                    @can('role_read')
                        <li><a class="block my-4 w-full px-4 py-2 hover:bg-gray-100 hover:text-gray-800" href="{{ route('role-index') }}">Roles de SIADI</a></li>
                    @endcan
                    @can('permission_read')
                        <li><a class="block my-4 w-full px-4 py-2 hover:bg-gray-100 hover:text-gray-800" href="{{ route('permission-index') }}">Permisos de SIADI</a></li>
                    @endcan
                    @can('category_read')
                        <li><a class="block my-4 w-full px-4 py-2 hover:bg-gray-100 hover:text-gray-800" href="{{ route('category-index') }}">Categorías</a></li>
                    @endcan
                    @can('program_read')
                        <li><a class="block my-4 w-full px-4 py-2 hover:bg-gray-100 hover:text-gray-800" href="{{ route('program-index') }}">Programas</a></li>
                    @endcan
                    @can('course_read')
                        <li><a class="block my-4 w-full px-4 py-2 hover:bg-gray-100 hover:text-gray-800" href="{{ route('course-index') }}">Asignaturas</a></li>
                    @endcan
                    @can('group_read')
                        <li><a class="block my-4 w-full px-4 py-2 hover:bg-gray-100 hover:text-gray-800" href="{{ route('group-index') }}">Grupos</a></li>
                    @endcan
                    @can('role_moodle_read')
                        <li><a class="block my-4 w-full px-4 py-2 hover:bg-gray-100 hover:text-gray-800" href="{{ route('role-moodle-index') }}">Roles de Matrícula</a></li>
                    @endcan
                    @can('state_enrollment_read')
                        <li><a class="block my-4 w-full px-4 py-2 hover:bg-gray-100 hover:text-gray-800" href="{{ route('state-enrollment-index') }}">Estados de Matrícula</a></li>
                    @endcan
                    @can('enrollment_read')
                        <li><a class="block my-4 w-full px-4 py-2 hover:bg-gray-100 hover:text-gray-800" href="{{ route('enrollment-index') }}">Matrículas</a></li>
                    @endcan
                </ul>
        </div>
        @canany(['moodle_massive', 'enrollment_massive'])
        <div class="mr-6 relative" x-data="{ open : false}" x-cloak >
            <a @click="open = true" class="cursor-pointer">
                Carga Masiva
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </a>
                <ul x-show="open"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform scale-90"
                    x-transition:enter-end="opacity-100 transform scale-100"
                    x-transition:leave="transition ease-in duration-300"
                    x-transition:leave-start="opacity-100 transform scale-100"
                    x-transition:leave-end="opacity-0 transform scale-90" @click.away="open = false" class="absolute bg-gray-800 rounded w-max z-30">

                    @can('moodle_massive')
                        <li><a class="block my-4 w-full px-4 py-2 hover:bg-gray-100 hover:text-gray-800" href="{{ route('moodle-mass-creation') }}">Usuarios plataforma</a></li>
                    @endcan
                    @can('enrollment_massive')
                        <li><a class="block my-4 w-full px-4 py-2 hover:bg-gray-100 hover:text-gray-800" href="{{ route('enrollment-mass-creation') }}">Matrículas</a></li>
                    @endcan
                    @can('enrollment_massive')
                        <li><a class="block my-4 w-full px-4 py-2 hover:bg-gray-100 hover:text-gray-800" href="{{ route('unenrollment-mass-update') }}">Desmatrículas</a></li>
                    @endcan
                </ul>
        </div>
        @endcanany
        @can('report_read')
        <div class="mr-6 relative" x-data="{ open : false}" x-cloak >
            <a @click="open = true" class="cursor-pointer">
                Estadisticas
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </a>
            <ul x-show="open"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform scale-90"
                x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-90" @click.away="open = false" class="absolute bg-gray-800 rounded w-max z-30">
                    <li><a class="block my-4 w-full px-4 py-2 hover:bg-gray-100 hover:text-gray-800" href="{{ route('moodle-report') }}">Usuarios plataforma</a></li>
                    <li><a class="block my-4 w-full px-4 py-2 hover:bg-gray-100 hover:text-gray-800" href="{{ route('course-report') }}">Asignaturas</a></li>
                    <li><a class="block my-4 w-full px-4 py-2 hover:bg-gray-100 hover:text-gray-800" href="{{ route('enrollment-report') }}">Matrículas</a></li>
                    <li><a class="block my-4 w-full px-4 py-2 hover:bg-gray-100 hover:text-gray-800" href="{{ route('reporte-nunca.export') }}">Reportes Nunca</a></li>
                <li><a class="block my-4 w-full px-4 py-2 hover:bg-gray-100 hover:text-gray-800" href="{{ route('reportsNever-index') }}">Reportes Nunca Page</a></li>
            </ul>
        </div>
        @endcan
        @can('search_read')
            <div>
                <a href="{{ route('search-index') }}">Búsquedas</a>
            </div>
        @endcan
        <div class="flex-1 text-right relative" x-data="{ open : false }" x-cloak>
            <a @click="open = true" class="text-white cursor-pointer py-2 px-4">
                @if(isset($_GET['egg']))
                    <img class="inline-block rounded-full" width="50px" src="{{ asset('img/suafonson.jpg') }}" alt="">
                    Suanfonson
                @else
                    {{ Auth::user()->name }} {{ Auth::user()->last_name }}
                @endif
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </a>
            <ul  x-show="open"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 transform scale-90"
                 x-transition:enter-end="opacity-100 transform scale-100"
                 x-transition:leave="transition ease-in duration-300"
                 x-transition:leave-start="opacity-100 transform scale-100"
                 x-transition:leave-end="opacity-0 transform scale-90" @click.away="open = false" class="absolute rounded w-60 z-30 right-0 bg-gray-100 mt-2">
                <li><a class="block text-gray-800 hover:bg-gray-700 hover:text-white py-2 px-4" href="{{ route('user-detail', ['id' => Auth::id()]) }}">Mi Perfil</a></li>
                @can('logs_read')
                    <li><a class="block text-gray-800 hover:bg-gray-700 hover:text-white py-2 px-4" href="{{ route('log-index') }}">Ver Logs</a></li>
                @endcan
                <li><a class="block text-gray-800 hover:bg-gray-700 hover:text-white py-2 px-4" href="{{ route('logout') }}">Cerrar sesión</a></li>
            </ul>
        </div>
    </nav>
</header>
<main class="flex-grow">
    @yield('content')
</main>
<footer style="border-bottom-width: 4em" class="border-siadi-blue-900 px-4 text-siadi-blue-900 mt-4 text-xl">
    @if(isset($_GET['egg']))
        <p>SUANFOSON | El Verdadero Nombre del Sistema.</p>
    @else
        <p>SIADI | Sistema de Información Académico Digital</p>
    @endif
</footer>
<script src="{{ asset('js/alpine.min.js')  }}" defer></script>
<script nomodule src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine-ie11.min.js" defer></script>
@stack('custom-script')
@livewireScripts
<script src="{{ mix('js/app.js') }}"></script>

</body>
</html>
