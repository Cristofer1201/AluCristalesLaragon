<x-auth-layout :title="'Restablecer contraseña'">
    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">
        

        <!-- Email Address -->
        <div>
            <div class="form-group">
                <x-text-input id="email" class="form-control" placeholder="Correo electronico" type="email" name="email" :value="old('email', $request->email)" required
                    autofocus autocomplete="username" />
            </div>
                
            <!--<x-input-error :messages="$errors->get('email')" class="mt-2" />-->
        </div>

        <!-- Password -->
        <div>
            <div class="form-group">
                <x-text-input id="password" class="form-control" placeholder="Contraseña" type="password" name="password" required
                autocomplete="new-password" />
            </div>
        </div>

        <!-- Confirm Password -->
        <div>
            <div class="form-group">
                <x-text-input id="password_confirmation" class="form-control" placeholder="Confirmar contraseña" type="password"
                name="password_confirmation" required autocomplete="new-password" />
            </div>
        </div>

        <div class="flex items-center justify-end mt-4">
            <button class="form-control btn btn-primary submit px-3">
                {{ __('Restablecer contraseña') }}
            </button>
        </div>
    </form>
</x-auth-layout>
