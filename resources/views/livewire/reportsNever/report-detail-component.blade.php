<div wire:poll.60s="someMethod" class="h-screen overflow-hidden">
    {{-- Contenido --}}

    <div class="w-full h-full flex flex-col">
        <a href="{{ route('reporte-nunca.export') }}" onclick="document.getElementById('generateReportButton').click(); return false;" class="text-white py-2 px-4 rounded-md bg-green-600">Generar Reporte</a>{{-- Filtro por Facultad --}}
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

        @if ($registros && $registros->isNotEmpty())
            <div class="flex-1 overflow-x-auto">
                <table class="w-full border rounded-lg">
                    <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="py-3 px-6 text-left">CodigoCurso</th>
                        <th class="py-3 px-6 text-left">InicioCurso</th>
                        <th class="py-3 px-6 text-left">Rol</th>
                        <th class="py-3 px-6 text-left">Documento</th>
                        <th class="py-3 px-6 text-left">Correo</th>
                        <th class="py-3 px-6 text-left">Periodo</th>
                        <th class="py-3 px-6 text-left">ultimoCur</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                    @foreach ($registros as $registro)
                        <tr class="{{ $loop->even ? 'bg-gray-100' : 'bg-white' }}">
                            <td class="py-3 px-6">{{ $registro->CodigoCurso }}</td>
                            <td class="py-3 px-6">{{ $registro->InicioCurso ?? 'N/A' }}</td>
                            <td class="py-3 px-6">{{ $registro->Rol }}</td>
                            <td class="py-3 px-6">{{ $registro->Documento }}</td>
                            <td class="py-3 px-6">{{ $registro->Correo }}</td>
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
            <p class="text-gray-500 flex-1">No hay registros para mostrar.</p>
        @endif
    </div>
</div>
