<x-auth-layout :title="'Restablacer contraseña'">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center mb-5">
                <h2 class="heading-section">CAMBIAR CONTRASEÑA</h2>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="login-wrap p-0">
                    <div class="mb-4 text-center">
                        <img src="img/Logo Alucristales.png" alt="Alucristales Palermo"
                            class="img-fluid move-up small-image"
                            style="width: 200px; margin-top: -80px; margin-left: -20px;">
                        <h3 class="text-white text-center">Alucristales Palermo</h3>
                    </div>
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <form action="{{ route('cambiarpasswords.cambiar') }}" method="POST" class="signin-form">
                        @csrf
                        <div class="form-group">
                            <input id="password" name="password" type="password" class="form-control"
                                placeholder="Contraseña" required>
                            <!--<span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password"></span>-->
                        </div>
                        <!--
                        <div class="form-group">
                            <input id="repeat_password" name="repeat_password" type="password" class="form-control"
                                placeholder="Repetir contraseña" required>
                            
                        </div>-->
                        <div class="form-group">
                            <button type="submit" class="form-control btn btn-primary submit px-3">Cambiar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-auth-layout>