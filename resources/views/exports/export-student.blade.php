<table>
    <thead>
    <tr>
        <th>Nombres</th>
        <th>Apellidos</th>
        <th>Documento</th>
        <th>Correo electronico</th>
        <th>Mensajes</th>
    </tr>
    </thead>
    <tbody>
    @foreach($failures as $failure)
        <tr>
            <td>{{ Str::title($failure['name']) }}</td>
            <td>{{ Str::title($failure['last_name']) }}</td>
            <td>{{ Str::title($failure['document']) }}</td>
            <td>{{ Str::title($failure['email']) }}</td>
            <td>
            @foreach($failure["errors"] as $error)
                <p>{{$error[0]}}</p>
            @endforeach
            </td>
        </tr>
        @endforeach
    </tbody>
</table>