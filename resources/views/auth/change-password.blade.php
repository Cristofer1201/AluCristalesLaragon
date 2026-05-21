<x-auth-layout :title="'Cambiar contraseña'">

    <div class="form-group text-center mb-4">
        {{ __('Por temas de seguridad, le solicitamos que cambie su contraseña.') }}
    </div>

    <form method="POST" action="{{ route('contrasena.update') }}">
        @csrf

        <!-- Current password -->
        <div>
            <div class="form-group">
                <x-text-input id="current_password" class="form-control" placeholder="Contraseña actual" type="password"
                    name="current_password" required autofocus />
            </div>

        </div>

        <!-- Password -->
        <div>
            <div class="form-group">
                <x-text-input id="new_password" class="form-control" placeholder="Contraseña nueva" type="password"
                    name="new_password" required autocomplete="new-password" />
            </div>
        </div>

        <!-- Confirm Password -->
        <div>
            <div class="form-group">
                <x-text-input id="new_password_confirmation" class="form-control"
                    placeholder="Confirmar contraseña nueva" type="password" name="new_password_confirmation" required
                    autocomplete="new-password" />
            </div>
        </div>
        <div class="form-group">
            <button class="form-control btn btn-primary submit px-3">
                {{ __('Cambiar contraseña') }}
            </button>
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
</x-auth-layout>
