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
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-xl w-full space-y-4 border-t-20 border-siadi-blue-700 shadow-xl  border-gray-300 px-12 pb-5 rounded-md">
            <div class="mt-4">
                <h1 class="text-center text-4xl font-medium text-siadi-blue-500">
                    SIADI
                </h1>
                <p class="text-center text-siadi-gray">
                    Sistema de Información Académico Digital
                </p>
                <h2 class="text-center text-2xl font-medium text-gray-700">
                    Inicio de sesión
                </h2>
            </div>
            @foreach($errors->all() as $error)
            <div class="text-center text-red-600">{{ $error }}</div>
            @endforeach
            <form class="my-4"  action="{{ route('sing-in') }}" method="POST">
                <div class="rounded-md shadow-sm space-y-px">
                    <div>
                        <input id="username" name="username" type="email" autocomplete="username" required
                               class="appearance-none mb-2 rounded-none font-medium relative block w-full px-3 py-2 border border-gray-300 placeholder-siadi-gray text-siadi-gray focus:outline-none focus:z-10 text-lg" placeholder="Nombre de usuario">
                    </div>
                    <div>
                        <input id="password" name="password" type="password" autocomplete="current-password" required
                               class="appearance-none mb-6 rounded-none relative font-medium block w-full px-3 py-2 border border-gray-300 placeholder-siadi-gray text-siadi-gray focus:outline-none text-lg"
                               placeholder="Contraseña">
                    </div>
                </div>

                <div>
                    <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white hover:text-gray-700 bg-siadi-blue-500 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                    <!-- Heroicon name: solid/lock-closed -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z" />
                        </svg>
                    </span>
                        Ingresar
                    </button>
                </div>
                @csrf
            </form>
            <div class="mt-2" style="margin-top: 1em">
                <p class="text-center text-siadi-blue-700">
                    Si tienes dificultad para acceder
                </p>
                <p class="text-center">
                    <a href="https://soporte.pascualbravovirtual.edu.co/index.php" target="_blank" class="text-siadi-blue-500 font-medium">
                        ingresa al centro de soporte
                    </a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>
