<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="{{ url('/') }}/css/estilos.css">

        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <script src="https://kit.fontawesome.com/e632f1f723.js" crossorigin="anonymous"></script>

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>


    <div class="container">
        <div class=" h-100 div-login"  style="margin-top: 150px;" >
            <div class="col-sm-12 text-center d-lg-none">
                <img src="imgs/logo-general.jpeg" alt="Logo" class="" style="opacity: .8" width="300px;" height="200px;">
            </div>
        </div>
        {{--        <div class="d-flex justify-content-center h-100" style="margin-top: 200px;" >--}}
        <div class="card-login m-0 m-auto float-lg-left " style="margin-bottom: 150px;">
            <div class="card-header text-white">
                <h5>Recuperar Contraseña</h5>
            </div>
            <div class="card-body ">
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    {{-- email --}}
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
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

                    <div class="form-group mt-5">
                        <button type="submit"  class="btn btn-block btn-light">
                            {{ __('Enviar') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>

    </div>


</html>


