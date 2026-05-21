<x-dashboard-layout>
    <x-slot:pageTitle>Perfil</x-slot:pageTitle>

    <div class="container-fluid">

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 card bg-white shadow">
                    <div class="max-w-xl">
                        <!--@include('profile.partials.update-profile-information-form') -->
                        <section>
                            <header>
                                <h2 class="text-lg font-medium text-gray-900">
                                    {{ __('Información de perfil') }}
                                </h2>
                        
                                <p class="mt-1 text-sm text-gray-600">
                                    {{ __("Actualice la información del perfil y la dirección de correo electrónico de su cuenta.") }}
                                </p>
                            </header>
                        
                            <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                                @csrf
                            </form>
                        
                            <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
                                @csrf
                                @method('patch')
                        
                                <div class="row">
                                    <div class="col-lg-4">
                                        <x-input-label for="name" :value="__('Nombre: ')" />
                                        <x-text-input id="name" name="name" type="text" class="form-control block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                                        <x-input-error class="text-danger mt-2" :messages="$errors->get('name')" />
                                    </div>
                                </div>
                                
                                <div class="row mt-3">
                                    <div class="col-lg-6">
                                        <x-input-label for="email" :value="__('Correo electrónico: ')" />
                                        <x-text-input id="email" name="email" type="email" class="form-control block w-full" :value="old('email', $user->email)" required autocomplete="username" />
                                        <x-input-error class="text-danger mt-2" :messages="$errors->get('email')" />
                            
                                        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                                            <div>
                                                <p class="mt-3 text-sm mt-2 text-gray-800">
                                                    <x-input-label>
                                                        {{ __('Su dirección de correo electrónico no está verificada.') }}
                                                    </x-input-label>
                                                    
                            
                                                    <button form="send-verification" class="btn btn-primary block w-full">
                                                        {{ __('Haga clic aquí para volver a enviar el correo electrónico de verificación.') }}
                                                    </button>
                                                </p>
                            
                                                @if (session('status') === 'verification-link-sent')
                                                    <p class="mt-2 font-medium text-sm text-green-600">
                                                        {{ __('Se ha enviado un nuevo enlace de verificación a su dirección de correo electrónico.') }}
                                                    </p>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </div>
                        
                                <div class="d-flex align-items-center gap-4 mt-3">
                                    <button class="btn btn-success">{{ __('Guardar') }}</button>
                                    <div class="text-success">
                                        @if (session('status') === 'profile-updated')
                                            <div
                                                x-data="{ show: true }"
                                                x-show="show"
                                                x-transition
                                                x-init="setTimeout(() => show = false, 2000)"
                                                class="mx-3 text-sm"
                                            >{{ __('Guardado.') }}
                                            <i class="fa-solid fa-check"></i>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </section>
                    </div>
                </div>

                <div class="p-4 mt-4 card bg-white shadow">
                    <div class="max-w-xl">
                        <section>
                            <header>
                                <h2 class="text-lg font-medium text-gray-900">
                                    {{ __('Actualizar contraseña') }}
                                </h2>
                        
                                <p class="mt-1 text-sm text-gray-600">
                                    {{ __('Asegúrese de que su cuenta utilice una contraseña larga y aleatoria para mantenerse segura.') }}
                                </p>
                            </header>
                        
                            <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
                                @csrf
                                @method('put')
                        
                                <div class="row">
                                    <div class="col-lg-4">
                                        <x-input-label for="update_password_current_password" :value="__('Contraseña actual: ')" />
                                        <x-text-input id="update_password_current_password" name="current_password" type="password" class="form-control block w-full" autocomplete="current-password" />
                                        <x-input-error :messages="$errors->updatePassword->get('current_password')" class="text-danger mt-2" />
                                    </div>
                                </div>
                                
                                <div class="row mt-3">
                                    <div class="col-lg-4">
                                        <x-input-label for="update_password_password" :value="__('Nueva contraseña: ')" />
                                        <x-text-input id="update_password_password" name="password" type="password" class="form-control block w-full" autocomplete="new-password" />
                                        <x-input-error :messages="$errors->updatePassword->get('password')" class="text-danger mt-2" />
                                    </div>
                                </div>
                        
                                <div class="row mt-3">
                                    <div class="col-lg-4">
                                        <x-input-label for="update_password_password_confirmation" :value="__('Confirmar contraseña: ')" />
                                        <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="form-control block w-full" autocomplete="new-password" />
                                        <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="text-danger mt-2" />
                                    </div>
                                </div>
                        
                                <div class="d-flex align-items-center gap-4 mt-3">
                                    <button class="btn btn-success">{{ __('Guardar') }}</button>
                                    <div class="text-success">
                                        @if (session('status') === 'password-updated')
                                            <div
                                                x-data="{ show: true }"
                                                x-show="show"
                                                x-transition
                                                x-init="setTimeout(() => show = false, 2000)"
                                                class="mx-3 text-sm"
                                            >{{ __('Guardado.') }}
                                            <i class="fa-solid fa-check"></i>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </section>                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    
</x-dashboard-layout>
