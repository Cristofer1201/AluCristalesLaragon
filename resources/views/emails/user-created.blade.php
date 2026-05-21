<x-mail::message>

<h1>Hola {{ $usuario->name }},</h1>
<p>Tu cuenta ha sido creada con éxito. Usa las siguientes credenciales para iniciar sesión:</p>
<x-mail::panel>
    Email: {{ $usuario->email }} <br>
    Contraseña Temporal: {{ $password }}
</x-mail::panel>
<div>Por favor, cambia tu contraseña después de iniciar sesión por primera vez</div>
<x-mail::button :url="route('login')"
    color="success">
    Click aqui para iniciar sesión
</x-mail::button>

</x-mail::message>