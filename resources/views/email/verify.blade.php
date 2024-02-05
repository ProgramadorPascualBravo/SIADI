<link rel="stylesheet" href="{{ mix('/css/app.css') }}">
<div class="grid grid-cols-5 gap-4 bg-purple-200">
    <div class="col-span-3 col-start-2 bg-white p-3">
        <p>Hola, {{ $user->full_name }}</p>
        <p>
            Te crearon la cuenta en el sistema de <b>SIADI</b>.
            Haga clic en el botón a continuación para verificar su dirección de correo electrónico y completar su registro.
        </p>
        <br />
        <p>
            <a href="{{ url('email/verify/'.$user->confirmation_code) }}" target="_blank" class="btn bg-blue-800 text-white mt-2 ml-0" style="margin-left: 0">VERIFICA TU CORREO ELECTRÓNICO
            </a>
        </p>
        <br />
        <p class="block mt-5"><b>¿Teniendo problemas?</b></p>
        <p>Si el método anterior no funciona, intente copiar y pegar este enlace en su navegador. </p>
        <br />
        <a target="_blank" class="text-blue-700 underline" href="{{ url('email/verify/'.$user->confirmation_code) }}">
            {{ url('email/verify/'.$user->confirmation_code) }}
        </a>
        <br />
        <br />
        <p>Atentamente</p>
        <p>Team SIADI | Sistema de Información Académico Digital</p>
    </div>
</div>