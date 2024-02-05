<div class="grid grid-cols-4 gap-4 px-4">
    <div class="col-span-2 p-2">
        <h2 class="font-bold text-xl">Datos del programa</h2>
        <h2><b>Nombre :</b> {{ $program->name }}</h2>
        <h2><b>Facultad :</b> {{ $program->faculty }} </h2>
        <h2><b>Estado :</b> {!! $program->state == 1 ? "<span class='text-green-400 font-bold'>Activo</span>" : "<span class='text-red-400 font-bold'>Desactivado</span>" !!} </h2>
        <h2><b>Creado en SIADI :</b> {{ \Illuminate\Support\Carbon::createFromFormat('Y-m-d H:i:s', $program->created_at)->format('d-m-Y') }} </h2>
    </div>
    <div class="col-span-2 gap-2">
        {{--
        @if ($student->user_external)
            <h2><b>Primer ingreso a moodle</b> {{ $student->user_external->first_entry }}</h2>
            <h2><b>Último ingreso a moodle</b> {{ $student->user_external->last_entry }}</h2>
        @else
            <h2>No tiene registro en la plataforma de Moodle</h2>
        @endif
        --}}
    </div>
    <div class="col-span-4">
        <h2 class="font-bold text-xl">Lista de asignaturas</h2>
        <div class="w-full my-4">
            @foreach($program->courses->reverse() as $course)
                <div x-data={show:false} class="rounded-sm">
                    <div class="border border-b-0" id="headingOne">
                        <button @click="show=!show"  class="block w-full h-full font-bold text-white text-left px-10 py-6 focus:outline-none bg-siadi-blue-300"  :class="{ 'bg-blue-900': show === true }" type="button">
                            {{ $course->name }}
                        </button>
                    </div>
                    <div x-show="show" class="border border-b-0 px-10 py-6">
                       <div class="grid grid-cols-2 gap-4">
                           <div class="col-span-1">
                               <p><b>Codigo:</b> {{ $course->code }} </p>
                               <p><b>Estado :</b> {!! $course->state == 1 ? "<span class='text-green-400 font-bold'>Activo</span>" : "<span class='text-red-400 font-bold'>Desactivado</span>" !!} </p>
                               <h2><b>Creado en SIADI :</b> {{ \Illuminate\Support\Carbon::createFromFormat('Y-m-d H:i:s', $course->created_at)->format('d-m-Y') }} </h2>
                           </div>
                           <div class="col-span-1 text-right">
                               @if(Auth::user()->can('course_detail'))
                               <h2>
                                   <a href="{{ route('course-detail', ['id' => $course->id]) }}" class="border border-gray-300 w-max pl-2 hover:bg-blue-100 rounded-lg mb-4 inline-block uppercase">
                                        <span class="py-2 inline-block rounded-l-lg text-sm">
                                            Ver Detalle
                                        </span>
                                        <div class="bg-siadi-blue-900 text-gray-100 inline-block p-2 rounded-r-lg">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                            </svg>
                                        </div>
                                   </a>
                               </h2>
                               @endif
                           </div>
                           <div class="col-span-2">
                               <h2 class="font-bold text-xl">Lista de grupos</h2>
                               <livewire:course-group-table :params="$course->id" />
                           </div>
                       </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>