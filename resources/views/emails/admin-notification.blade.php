<x-mail::message>

<h1>Hola,</h1>
<p>Un administrador realizo la siguiente accion:</p>

<p>{{$mensaje}}</p>

<x-mail::button :url="route('dashboard.medidas.index')"
    color="success">
    Ver detalles
</x-mail::button>

</x-mail::message>