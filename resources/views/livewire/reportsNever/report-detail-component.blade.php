<div wire:poll.60s="someMethod">
    {{-- Contenido --}}

<div class="w-full">

    {{-- Filtro por Facultad --}}
    <form wire:submit.prevent="filterByFaculty" class="mb-4">
        <label for="facultyFilter" class="mr-2">Filtrar por Facultad:</label>
        <select wire:model="selectedFaculty" id="facultyFilter" class="p-2 border rounded-md">
            <option value="" selected>Todas las Facultades</option>
            @foreach($uniqueFaculties as $faculty)
                <option value="{{ $faculty }}">{{ $faculty }}</option>
            @endforeach
        </select>
        <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md">Filtrar por Facultad</button>
    </form>

    <h1 class="text-3xl font-bold mb-4">Reportes Nunca</h1>

    @if ($registros->isNotEmpty())
        <div class="overflow-x-auto">
            <table class="min-w-full border rounded-lg overflow-hidden">
                <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="py-3 px-6 text-left">Facultad</th>
                    <th class="py-3 px-6 text-left">Programa</th>
                    <th class="py-3 px-6 text-left">CodigoCurso</th>
                    <th class="py-3 px-6 text-left">Curso</th>
                    <th class="py-3 px-6 text-left">Grupo</th>
                    <th class="py-3 px-6 text-left">InicioCurso</th>
                    <th class="py-3 px-6 text-left">Rol</th>
                    <th class="py-3 px-6 text-left">Documento</th>
                    <th class="py-3 px-6 text-left">Correo</th>
                    <th class="py-3 px-6 text-left">Nombre_Curso</th>
                    <th class="py-3 px-6 text-left">Periodo</th>
                    <th class="py-3 px-6 text-left">ultimoCur</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                @foreach ($registros as $registro)
                    <tr class="{{ $loop->even ? 'bg-gray-100' : 'bg-white' }}">
                        <td class="py-3 px-6">{{ $registro->Facultad }}</td>
                        <td class="py-3 px-6">{{ $registro->programa }}</td>
                        <td class="py-3 px-6">{{ $registro->CodigoCurso }}</td>
                        <td class="py-3 px-6">{{ $registro->Curso }}</td>
                        <td class="py-3 px-6">{{ $registro->Grupo }}</td>
                        <td class="py-3 px-6">{{ $registro->InicioCurso ?? 'N/A' }}</td>
                        <td class="py-3 px-6">{{ $registro->Rol }}</td>
                        <td class="py-3 px-6">{{ $registro->Documento }}</td>
                        <td class="py-3 px-6">{{ $registro->Correo }}</td>
                        <td class="py-3 px-6">{{ $registro->Nombre_Curso }}</td>
                        <td class="py-3 px-6">{{ $registro->Periodo }}</td>
                        <td class="py-3 px-6">{{ $registro->ultimoCur }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @if ($registros instanceof \Illuminate\Pagination\LengthAwarePaginator)
            {{ $registros->links() }}
        @endif
    @else
        <p class="text-gray-500">No hay registros para mostrar.</p>
    @endif
</div>

</div>
