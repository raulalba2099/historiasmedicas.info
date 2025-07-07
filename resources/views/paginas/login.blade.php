

<div class="container">
    <div class="row div-logo-sm">

    </div>

    <div class=" h-100 div-login"  >
        <div class="col-sm-12 text-center d-lg-none">
            <img src="imgs/logo-general.jpeg" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8" width="300px;" height="300px;">
        </div>
    </div>
{{--        <div class="d-flex justify-content-center h-100" style="margin-top: 200px;" >--}}
        <div class="card-login m-0 m-auto float-lg-left ">
            <div class="card-header">
                <h3>Iniciar Sesión</h3>
{{--                <div class="d-flex justify-content-end social_icon">--}}
{{--                    <span><i class="fab fa-facebook-square"></i></span>--}}
{{--                    <span><i class="fab fa-google-plus-square"></i></span>--}}
{{--                    <span><i class="fab fa-twitter-square"></i></span>--}}
{{--                </div>--}}
            </div>
            <div class="card-body ">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    {{-- email --}}
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                        </div>
                        <input id="email" type="email" class="form-control email_login @error('email') is-invalid @enderror"
                               name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Correo"
                               autofocus>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                        @enderror
                    </div>
                    {{-- password --}}
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                        </div>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                               name="password" required autocomplete="current-password" placeholder="Contraseña">

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                        @enderror
                    </div>
                    <div class="row align-items-center remember">
                        <div class="col-6">
                            <input type="checkbox">Recordarme
                        </div>
                        <div class="col-6 mt-2">
                            @if (Route::has('password.request'))
                                <a class="text-white" href="{{ route('password.request') }}">
                                    {{ __('¿Olvido su Contraseña?') }}
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <input type="submit" value="Login" class="btn float-right login_btn">
                    </div>
                </form>
            </div>
{{--            <div class="card-footer">--}}
{{--                <div class="d-flex justify-content-center links">--}}
{{--                    Don't have an account?<a href="#">Sign Up</a>--}}
{{--                </div>--}}
{{--                <div class="d-flex justify-content-center">--}}
{{--                    <a href="#">Forgot your password?</a>--}}
{{--                </div>--}}
{{--            </div>--}}
        </div>
    </div>
</div>
