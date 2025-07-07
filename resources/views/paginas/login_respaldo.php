<body class="login-page body float col-sm-6">
<div class="login-box">
{{--    <div class="login-logo justify-content-center">--}}
{{--        <div>--}}
{{--            <a href="/">--}}
{{--                <!-- <x-application-logo class="w-20 h-20 fill-current text-gray-500" /> -->--}}
{{--                <img src="{{url('/')}}/imgs/logo-general.jpeg" alt="logo" >--}}
{{--            </a>--}}
{{--        </div>--}}
{{--    </div>--}}

    <!-- /.login-logo -->

    <div class="">
        <div class="card-body login-card-body">
{{--            <p class="login-box-msg color-claro">Iniciar Sesión</p>--}}
            <form method="POST" action="{{ route('login') }}">
                @csrf

                {{-- email --}}

                <div class="input-group mb-3">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <i class="fas fa-envelope i-login" ></i>
                        </div>
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

                <div class="input-group mb-3">

                    <div class="input-group-append">

                        <div class="input-group-text">

                            <i class="fas fa-key i-login""></i>

                        </div>

                    </div>

                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                           name="password" required autocomplete="current-password" placeholder="Contraseña">

                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror

                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-block btn-flat i-login">Ingresar</button>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <!-- Remember Me -->
                        <div class="block mt-4">
                            <label for="remember_me" class="inline-flex items-center">
                                <input id="remember_me" type="checkbox"
                                       class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
                                       name="remember">
                                <span class="liga ml-2 text-sm text-white">{{ __('Recordarme') }}</span>
                            </label>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="flex items-center justify-end mt-4">
                            @if (Route::has('password.request'))
                                <a class="text-white underline text-sm rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                                   href="{{ route('password.request') }}">
                                    {{ __('¿RecuperarContraseña?') }}
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="{{url('/')}}/js/login.js"></script>
</body>
