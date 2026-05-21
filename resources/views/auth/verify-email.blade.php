<x-auth-layout :title="'Verificacion de correo'">
    <div class="form-group text-center mb-4">
        {{ __('¡Gracias por iniciar sesión! Antes de comenzar, ¿podría verificar su dirección de correo electrónico haciendo clic en el enlace que le acabamos de enviar por correo electrónico? Si no recibió el correo electrónico, con gusto le enviaremos otro.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-success">
            {{ __('Se ha enviado un nuevo enlace de verificación a la dirección de correo electrónico que proporcionó.') }}
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div class="form-group">
                <x-primary-button class="form-control btn btn-primary submit px-3">
                    {{ __('Reenviar verificación') }}
                </x-primary-button>
            </div>
        </form>

        <div class="text-center">
            <form method="POST"
                class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    style=
                "background: none;
                border: none;
                cursor: pointer;
                font: inherit;
                padding: 0;
                -webkit-transition: .3s all ease;
                -o-transition: .3s all ease;
                transition: .3s all ease;
                color: #fbceb5;
                text-decoration: none;
                };" >
                    {{ __('Cerrar sesión') }}</button>
            </form>
        </div>
        
    </div>
</x-auth-layout>
