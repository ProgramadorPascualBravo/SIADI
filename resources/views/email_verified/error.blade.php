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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="col-span-2 text-siadi-blue-900 text-xl">
                <br>
                <p>
                    El link no es valido.
                </p>
                <br>
            </div>
        </div>
    </div>
</div>
</body>
</html>
