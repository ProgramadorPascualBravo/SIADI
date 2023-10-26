<table>
    <thead>
    <tr>
        <th>Código curso</th>
        <th>Correo de usuario</th>
        <th>Mensajes</th>
    </tr>
    </thead>
    <tbody>
    @foreach($failures as $failure)
        <tr>
            <td>{{$failure["curso"] }}</td>
            <td>{{$failure["usuario"] }}</td>
            @foreach($failure["errors"] as $error)
                <td>{{$error}}</td>
            @endforeach
        </tr>
    @endforeach
    </tbody>
</table>
