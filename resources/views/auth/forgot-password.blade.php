<x-auth-layout :title="'Contraseña olvidada'">
    <div class="form-group text-center mb-4">
        {{ __('¿Olvidaste tu contraseña? No hay problema. Con su dirección de correo electrónico le enviaremos un enlace para restablecer su contraseña que le permitirá elegir una nueva.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="text-center text-success mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div class="form-group">
            <x-text-input id="email" class="form-control" placeholder="Correo electronico" type="email" name="email" :value="old('email')" required autofocus />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="form-control btn btn-primary submit px-3">
                {{ __('Obtener enlace') }}
            </x-primary-button>
        </div>
    </form>
</x-auth-layout>
