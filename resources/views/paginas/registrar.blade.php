
@extends('plantilla')
@section('content')

<div class="content-wrapper" style="min-height: 247px;">
  <section class="content-header">

    <div class="container-fluid">

      <div class="row mb-2">

        <div class="col-sm-6">

          <h1>Administradores</h1>

        </div>

        <div class="col-sm-6">

          <ol class="breadcrumb float-sm-right">

            <li class="breadcrumb-item"><a href="{{url('/')}}">Registrar</a></li>

            <li class="breadcrumb-item active">Administradores</li>

          </ol>

        </div>

      </div>

    </div><!-- /.container-fluid -->

  </section>

  <!-- Main content -->
  <section class="content">

    <div class="container-fluid">

      <div class="row">

        <div class="col-12">

          <!-- Default box -->
          <div class="card">

            <div class="card-header">

             <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#crearAdministrador">Crear nuevo administrador</button>

            </div>

            <div class="card-body">

              <div class="row">
                <div class="col-md-5 container-fluid text-center">
                  <div class="login-box">
    <div class="login-logo justify-content-center">
        <div>
          <a href="/">
             <!-- <x-application-logo class="w-20 h-20 fill-current text-gray-500" /> -->
               
          </a>
        </div>
    </div>

    <!-- /.login-logo -->

    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg color-claro">Registrar</p>
        <form method="POST" action="{{ route('register') }}">
          @csrf

           {{-- name --}}
          <div class="input-group mb-3">
              <div class="input-group-append">
                <div class="input-group-text">
                  <i class="fas fa-envelope color-claro"></i>
                </div>
              </div>
              <input id="name" type="text" class="form-control email_login @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" placeholder="Nombre" autofocus>
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
          </div>

            {{-- email --}}
          <div class="input-group mb-3">
              <div class="input-group-append">
                <div class="input-group-text">
                  <i class="fas fa-envelope color-claro"></i>
                </div>
              </div>
              <input id="email" type="email" class="form-control email_login @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Correo" autofocus>
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
                 <i class="fas fa-key color-claro"></i>
                </div>
              </div>
              <input id="password" type="password" class="form-control password @error('password') is-invalid @enderror" name="name" value="{{ old('password') }}" required autocomplete="name" placeholder="Contraseña" autofocus>
  
          </div>

           {{-- password_confirmation --}}
          <div class="input-group mb-3">
              <div class="input-group-append">
                <div class="input-group-text">
                    <i class="fas fa-key color-claro"></i>
                </div>
              </div>
              <input id="password_confirmation" type="password" class="form-control password_confirmation @error('password_confirmation') is-invalid @enderror" name="name" value="{{ old('password_confirmation') }}" required autocomplete="name" placeholder="Confirmar Contraseña" autofocus>
  
          </div>

        

          
        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ml-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>



       <div class="row">   
  

    
       </div>     
      </form>
    </div>
  </div>
                </div>
              </div>
             
            </div>

            <!-- /.card-body -->
            <div class="card-footer">

              Footer

            </div>
            <!-- /.card-footer-->
          </div>
          <!-- /.card -->
        </div>

      </div>

    </div>

  </section>
  <!-- /.content -->
</div>
@endsection('content')