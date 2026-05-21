<x-auth-layout :title="'Iniciar Sesion'">

    <form action="{{ route('login') }}" method="POST" class="signin-form">
        @csrf

        <!-- Email Field -->
        <div class="form-group mb-3">
            <label for="email" class="form-label">Correo electronico</label>
            <div class="position-relative">
                <input type="email"
                       id="email"
                       name="email"
                       class="form-control"
                       placeholder="ejemplo@correo.com"
                       value="{{ old('email') }}"
                       required
                       autofocus>
            </div>
        </div>

        <!-- Password Field -->
        <div class="form-group mb-3">
            <label for="password" class="form-label">Contrasena</label>
            <div class="position-relative">
                <input id="password"
                       name="password"
                       type="password"
                       class="form-control"
                       placeholder="Ingresa tu contrasena"
                       required>
                <span toggle="#password" class="fa fa-fw fa-eye password-toggle toggle-password"></span>
            </div>
        </div>

        <!-- Remember Me -->
        <div class="form-group mb-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                <label class="form-check-label small" for="remember" style="color: var(--alu-gray-600);">
                    Recordar mi sesion
                </label>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="form-group mb-3">
            <button type="submit" class="btn btn-primary btn-block w-100">
                <i class="fa-solid fa-right-to-bracket mr-2"></i>
                Acceder
            </button>
        </div>

        <!-- Forgot Password Link -->
        @if (Route::has('password.request'))
            <div class="text-center">
                <a class="link-muted" href="{{ route('password.request') }}">
                    <i class="fa-solid fa-lock mr-1"></i>
                    Olvidaste tu contrasena?
                </a>
            </div>
        @endif

    </form>

</x-auth-layout>
