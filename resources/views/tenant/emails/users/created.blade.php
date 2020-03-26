@component('mail::message')
# {{ ucfirst($user->first_name) }} @if ($user->gender == 'mujer') Bienvenida @else Bienvenido @endif a la comunidad!!<br>
<br>

Estamos felices de que te unas a nuestra familia, estamos aquí para apoyarte y para que cumplas tus objetivos.

{{-- @component('mail::button', ['url' => '$url'])
    View Order
@endcomponent --}}

Saludos,<br>
{{ $box_name ?? config('app.name') }}
@endcomponent
