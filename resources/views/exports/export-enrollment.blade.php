<table>
    <thead>
    <tr>
        <th>Código matrícula</th>
        <th>Correo de usuario</th>
        <th>Rol</th>
        <th>Estado</th>
        <th>Periodo</th>
        <th>Mensajes</th>
    </tr>
    </thead>
    <tbody>
    @foreach($failures as $failure)
        <tr>
            <td>{{ $failure['code'] }}</td>
            <td>{{ $failure['email'] }}</td>
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