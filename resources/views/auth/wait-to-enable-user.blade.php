<x-auth-layout :title="'Habilitación'">
    <div class="form-group text-center mb-4">
        {{ __('Comunicate con el administrador para que lo habilite y pueda continuar con su gestión.') }}
    </div>

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
</x-auth-layout>