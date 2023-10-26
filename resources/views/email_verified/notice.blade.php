<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SIADI</title>
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
</head>
<body>
<div class="min-h-screen flex items-center justify-center bg-gray-300 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl w-full space-y-8">
            <div class="grid grid-cols-2 p-5 bg-white">
                <div class="col-span-1">
                    <h1 class="font-medium text-4xl mt-4 mb-1 text-siadi-blue-900">
                        Información
                    </h1>
                    <hr class="border-siadi-blue-700">
                </div>
                <div class="col-span-1 text-right">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-siadi-red" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                    </svg>
                </div>
                <div class="col-span-2 text-siadi-blue-900">
                    <br>
                        <p>Hola, {{ Auth::user()->full_name }}.</p>
                    <br>
                    <p>
                        Aun no has verificado tu correo electronico <b>{{ Auth::user()->username }}</b>, Por favor revisa tu bandeja de entrada
                        y busca el asunto <b>Verificar cuenta | SIADI</b> y valida el correo para poder ingresar.</p>
                    <br>
                    <p class="text-right">
                        <a class="bg-siadi-blue-500 hover:bg-siadi-blue-300 px-4 py-2 font-bold text-white" href="{{ route('logout') }}">
                            Salir
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
