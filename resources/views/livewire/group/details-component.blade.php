<div class="grid grid-cols-4 gap-4 px-4">
    <div class="col-span-4 p-2">
        <h2 class="font-bold text-xl">Datos del grupo</h2>
        <h2><b>Nombre : </b> Grupo{{ $group->name }}</h2>
        <h2><b>Código :</b> {{ $group->code }} </h2>
        <h2><b>Estado :</b> {!! $group->state == 1 ? "<span class='text-green-400 font-bold'>Activo</span>" : "<span class='text-red-400 font-bold'>Desactivado</span>" !!} </h2>
        <h2><b>Creado en SIADI :</b> {{ \Illuminate\Support\Carbon::createFromFormat('Y-m-d H:i:s', $group->created_at)->format('d-m-Y') }} </h2>
        <a href="{{ route('course-detail', ['id' => $group->course_id]) }}" class="border border-gray-300 w-max pl-2 hover:bg-blue-100 rounded-lg mb-4 inline-block uppercase">
            <span class="py-2 inline-block rounded-l-lg text-sm">
                Ver detalle de la asignatura - <b>{{ $group->course->name }}</b>
            </span>
            <div class="bg-siadi-blue-900 text-gray-100 inline-block p-2 rounded-r-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                </svg>
            </div>
        </a>
    </div>
    <div class="col-span-4">
        <h2 class="font-bold text-xl">Lista de usuarios</h2>
        <div class="w-full my-4">
            <livewire:group-enrollment-table :params="$group->code" />
        </div>
    </div>
</div>