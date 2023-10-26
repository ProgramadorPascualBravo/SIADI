<div class="grid px-5 grid-cols-5 gap-4" x-data="{ open: false }">
    @include("sessions.session-input")
    <div class="col-span-5 flex flex-row-reverse">
        <div wire:click="cancel"
             class="border border-gray-300 w-max pl-2 inline-block hover:bg-red-100 rounded-lg cursor-pointer inline-block">
                <span class="py-2 inline-block rounded-l-lg text-sm capitalize">
                    &nbsp;Reiniciar&nbsp;
                </span>
            <div class="bg-siadi-red text-gray-100 inline-block p-2 rounded-r-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 m-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
            </div>
        </div>
        <div wire:click="download('app/file/anexo-11.xlsx')"
             class="border border-gray-300 w-max pl-2 inline-block hover:bg-siadi-green-100 rounded-lg mr-3 cursor-pointer">
            <span class="py-2 inline-block rounded-l-lg text-sm capitalize">
                Plantilla
            </span>
            <div class="bg-siadi-green-100 text-gray-700 inline-block p-2 rounded-r-lg">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 384 512"><path fill="currentColor" d="M369.9 97.9L286 14C277 5 264.8-.1 252.1-.1H48C21.5 0 0 21.5 0 48v416c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48V131.9c0-12.7-5.1-25-14.1-34zM332.1 128H256V51.9l76.1 76.1zM48 464V48h160v104c0 13.3 10.7 24 24 24h104v288H48zm212-240h-28.8c-4.4 0-8.4 2.4-10.5 6.3-18 33.1-22.2 42.4-28.6 57.7-13.9-29.1-6.9-17.3-28.6-57.7-2.1-3.9-6.2-6.3-10.6-6.3H124c-9.3 0-15 10-10.4 18l46.3 78-46.3 78c-4.7 8 1.1 18 10.4 18h28.9c4.4 0 8.4-2.4 10.5-6.3 21.7-40 23-45 28.6-57.7 14.9 30.2 5.9 15.9 28.6 57.7 2.1 3.9 6.2 6.3 10.6 6.3H260c9.3 0 15-10 10.4-18L224 320c.7-1.1 30.3-50.5 46.3-78 4.7-8-1.1-18-10.3-18z"></path></svg>
            </div>
        </div>

    </div>
    <div class="col-span-2 pl-2 border-r border-siadi-blue-900">
        <h2 class="font-normal text-2xl mb-4 text-siadi-blue-900 border-siadi-blue-300 border-b-2 w-min">Instrucciones</h2>
        <ol class="list-decimal pl-4 text-siadi-blue-700">
            <li class="mb-3 text-lg">
                Descargar
                <div wire:click="download('app/file/anexo-11.xlsx')"
                     class="border border-gray-300 w-max pl-2 inline-block hover:bg-siadi-green-100 rounded-lg cursor-pointer">
                    <span class="py-2 inline-block rounded-l-lg text-sm capitalize">
                        Plantilla Básica para Desmatriculación
                    </span>
                    <div class="bg-siadi-green-100 text-gray-700 inline-block p-2 rounded-r-lg">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 384 512"><path fill="currentColor" d="M369.9 97.9L286 14C277 5 264.8-.1 252.1-.1H48C21.5 0 0 21.5 0 48v416c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48V131.9c0-12.7-5.1-25-14.1-34zM332.1 128H256V51.9l76.1 76.1zM48 464V48h160v104c0 13.3 10.7 24 24 24h104v288H48zm212-240h-28.8c-4.4 0-8.4 2.4-10.5 6.3-18 33.1-22.2 42.4-28.6 57.7-13.9-29.1-6.9-17.3-28.6-57.7-2.1-3.9-6.2-6.3-10.6-6.3H124c-9.3 0-15 10-10.4 18l46.3 78-46.3 78c-4.7 8 1.1 18 10.4 18h28.9c4.4 0 8.4-2.4 10.5-6.3 21.7-40 23-45 28.6-57.7 14.9 30.2 5.9 15.9 28.6 57.7 2.1 3.9 6.2 6.3 10.6 6.3H260c9.3 0 15-10 10.4-18L224 320c.7-1.1 30.3-50.5 46.3-78 4.7-8-1.1-18-10.3-18z"></path></svg>
                    </div>
                </div>
            </li>
            <li class="mb-3 text-lg">Cargar la plantilla en la opción <b class="uppercase">cargar archivo</b></li>
            <li class="mb-3 text-lg">Procesar archivo con la opción <b class="uppercase">procesar archivo cargado</b></li>
            <li class="mb-3 text-lg">
                Finalizado el proceso pueden surgir 2 escenarios:
                <ol class="list-decimal pl-4">
                    <li class="my-3 text-sm"><b>Hay errores:</b> Se genera un documento excel con los registros que contienen incosistencias y no se pudieron guardar.</li>
                    <li class="mb-3 text-sm"><b>No hay errores:</b> No sé genera documento y sale un mensaje informando que todos los registros fueron existosos. </li>
                </ol>
            </li>
        </ol>
        <div class="text-lg"">
            <b>Nota:</b> Para cargar un nuevo archivo, usar la opcíon
            <div wire:click="cancel"
                 class="border border-gray-400 w-max pl-2 inline-block hover:bg-red-100 rounded-lg cursor-pointer inline-block">
                    <span class="py-2 inline-block rounded-l-lg text-sm capitalize">
                        &nbsp;Reiniciar&nbsp;
                    </span>
                <div class="bg-siadi-red text-gray-100 inline-block p-2 rounded-r-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 m-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                </div>
            </div>
        </div>
    </div>
   <livewire:unenrollment-form-file-component />
@if (count($errors) > 0)
    <div class="row">
        <div class="col-md-8 col-md-offset-1">
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Error!</h4>
                @foreach($errors->all() as $error)
                    {{ $error }} <br>
                @endforeach
            </div>
        </div>
    </div>
@endif
    <div class="col-span-2">

        @if(!is_null($quantity))
            <h2 class="font-normal text-2xl mb-4 text-siadi-blue-900 border-siadi-blue-300 border-b-2 w-min">Resultados</h2>
            <div class="my-4 w-64">
                <span class="rounded-lg block w-full shadow-lg p-5 text-sm uppercase border-gray-300 border cursor-pointer block">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-siadi-blue-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                    Registros totales: {{ $quantity['processed'] + $quantity['mistakes'] }}
                </span>
            </div>
            @if($quantity['mistakes'] > 0)
                <div class="my-4 w-64">
                    <span class="rounded-lg shadow-lg py-5 pl-4 pr-20 text-sm uppercase border-gray-300 border block w-ful">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-siadi-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Procesados: {{ $quantity['processed'] }}
                    </span>
                </div>
                <div class="my-4 w-64">
                    <span class="rounded-lg shadow-lg py-5 pl-4 pr-24 text-sm uppercase border-gray-300 border block w-full">
                       <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-siadi-red" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                       </svg>
                        Errores: {{ $quantity['mistakes'] }}
                    </span>
                </div>
            @else
                <div class="rounded-lg shadow-lg p-5 text-sm uppercase border-gray-300 border w-max">
                    Todos los registros fueron existosos
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-siadi-blue-300" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                    </svg>
                </div>
            @endif
        @else
            <h2 class="font-normal text-2xl mb-4 w-min border-b-2 border-siadi-blue-300">Información</h2>
            <p class="text-lg">
                Plantilla básica para desmatriculación: Se utiliza para actualizar las matrículas a estado desmatriculado.

            </p>
            <br>
            <a x-on:click="open = true" class="rounded-lg shadow-lg p-5 text-sm uppercase border-gray-300 border cursor-pointer">
                Ver descripción de los campos
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-siadi-blue-300" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                </svg>
            </a>
            <div x-show="open" x-cloak class="cursor-pointer">
                <div class="fixed bottom-0 inset-x-0 px-4 pb-4 sm:inset-0 sm:flex sm:items-center sm:justify-center" style="z-index:9999">
                    <div class="fixed inset-0 transition-opacity">
                        <div class="absolute inset-0 bg-gray-700 opacity-75" x-on:click="open = false"></div>
                    </div>
                    <div class="bg-bg-white overflow-hidden shadow-xl transform transition-all">
                        <table class="table-view">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Descripción</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Obligatorio Básica</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Obligatorio Extendida</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <td class="px-6 py-2">{{ Str::ucfirst(__('modules.input.code')) }} (code)</td>
                                    <td class="px-6 py-2">Código generado en el <a target="_blank" href="{{ route('group-index') }}" class="text-underline text-blue-500">módulo de grupos.</a></td>
                                    <td class="text-center px-6 py-2">Sí</td>
                                    <td class="text-center px-6 py-2">Sí</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-2">{{ Str::ucfirst(__('modules.input.email')) }} (email)</td>
                                    <td class="px-6 py-2 ">Correo institucional del alumno.</td>
                                    <td class="text-center px-6 py-2 ">Sí</td>
                                    <td class="text-center px-6 py-2 ">Sí</td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </div>

</div>
