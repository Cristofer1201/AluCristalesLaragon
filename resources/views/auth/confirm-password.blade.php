<x-auth-layout :title="'Confirmar contraseña'">
    <div class="mb-4 text-center">
        {{ __('Esta es un área segura de la aplicación. Confirme su contraseña antes de continuar.') }}
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <!-- Password -->
        <div class="form-group">
            <x-text-input id="password" class="form-control" placeholder="Contraseña"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />
        </div>

        <div class="flex justify-end mt-4">
            <x-primary-button class="form-control btn btn-primary submit px-3">
                {{ __('Confirmar') }}
            </x-primary-button>
        </div>
    </form>
</x-auth-layout>
