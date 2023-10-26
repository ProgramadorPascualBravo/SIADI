<div class="grid grid-cols-4 gap-4 px-4 pt-4">
    <div class="col-span-2 p-2">
        <h2 class="font-normal text-2xl mb-4 text-siadi-blue-900 border-siadi-blue-300 border-b-2 w-max">Datos del usuario plataforma</h2>
        <h2 class="mb-2"><b>Nombre :</b> {{ $student->name }} {{ $student->last_name }}</h2>
        <h2 class="mb-2"><b>Documento :</b> {{ $student->document }} </h2>
        <h2 class="mb-2"><b>Correo :</b> {{ $student->email }} </h2>
        <h2 class="mb-2"><b>Estado :</b> {!! $student->state == 1 ? "<span class='text-green-400 font-bold'>Activo</span>" : "<span class='text-red-400 font-bold'>Desactivado</span>" !!} </h2>
        <div
                class="border border-gray-300 w-max pl-2 hover:bg-blue-100 rounded-lg mb-4">
                <span class="py-2 inline-block rounded-l-lg text-sm">
                Creado en SIADI {{ \Illuminate\Support\Carbon::createFromFormat('Y-m-d H:i:s', $student->created_at)->format('d-m-Y') }}
                </span>
            <div class="bg-siadi-blue-900 text-gray-100 inline-block p-2 rounded-r-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
        </div>
    </div>
    <div class="col-span-2 gap-2">
        <h2 class="font-normal text-2xl mb-4 text-siadi-blue-900 border-siadi-blue-300 border-b-2 w-max">Datos de plataforma</h2>
        @if ($student->user_external)
            <div
                    class="border border-gray-300 w-max pl-2 hover:bg-blue-100 rounded-lg mb-4">
                <span class="py-2 inline-block rounded-l-lg text-sm">
                    Primer ingreso a campus {{ $student->user_external->first_entry }}
                </span>
                <div class="bg-siadi-blue-300 text-gray-100 inline-block p-2 rounded-r-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>
            <div
                    class="border border-gray-300 w-max pl-2 inline-block hover:bg-green-100 rounded-lg">
                <span class="py-2 inline-block rounded-l-lg text-sm">
                    Último ingreso a campus {{ $student->user_external->last_entry }}
                </span>
                <div class="bg-siadi-green-500 text-gray-100 inline-block p-2 rounded-r-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>
        {{-- <h2><b>Programa :</b> {{ $enrollments[0]->group->course->program->name }}</h2> --}}
        @else
            <div
                 class="border border-gray-300 w-max pl-2 inline-block hover:bg-yellow-100 rounded-lg inline-block">
                <span class="py-2 inline-block rounded-l-lg text-sm">
                    &nbsp;Nunca a ingresado a la plataforma&nbsp;
                </span>
                <div class="bg-siadi-yellow text-gray-100 inline-block p-2 rounded-r-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
            </div>
        @endif
    </div>
    <div class="col-span-4">
        <livewire:student-enrollment-table :params="$student->email" />
    </div>
</div>