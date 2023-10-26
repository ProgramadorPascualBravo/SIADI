<table>
    <thead>
    <tr>
        <th>Nombres</th>
        <th>Apellidos</th>
        <th>Documento</th>
        <th>Correo de usuario</th>
        <th>Código matrícula</th>
        <th>Rol</th>
        <th>Estado</th>
        <th>Periodo</th>
        <th>Mensajes</th>
    </tr>
    </thead>
    <tbody>
    @foreach($failures as $failure)
        <tr>
            <td>{{ Str::title($failure['name']) }}</td>
            <td>{{ Str::title($failure['last_name']) }}</td>
            <td>{{ $failure['document'] }}</td>
            <td>{{ $failure['email'] }}</td>
            <td>{{ $failure['code'] }}</td>
            <td>{{ $failure['rol'] }}</td>
            <td>{{ $failure['state'] }}</td>
            <td>{{ $failure['period'] }}</td>
            <td>
                @foreach($failure["errors"] as $error)
                    <p>{{$error[0]}}</p>
                @endforeach
            </td>
        </tr>
    @endforeach
    </tbody>
</table>