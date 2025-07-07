
@extends('plantilla')
@section('content')


<div class="content-wrapper" style="min-height: 247px;">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Pacientes</h1>
        </div>
{{--        <div class="col-sm-6">--}}
{{--          <ol class="breadcrumb float-sm-right">--}}
{{--            <li class="breadcrumb-item"><a href="{{url('/')}}">Registrar</a></li>--}}
{{--            <li class="breadcrumb-item active">Administradores</li>--}}
{{--          </ol>--}}
{{--        </div>--}}
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
             <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#crearPaciente">
              Crear nuevo Paciente
             </button>
            </div>
  <div class="card-body">
    <div class="row">
      <div class="col-lg-12">
        <div class="table-responsive fuenteTabla">
          <table id="tablaPacientes" class="table table-striped table-bordered table-condensed" style="width:100%" >
            <thead class="text-center">
              <tr class="badge-primary">
                <th>Id Paciente</th>
                <th>Número</th>
                <th>Nombre</th>
                <th>Apellido Paterno</th>
                <th>Apellido Materno</th>
                <th>Edad</th>
                <th>Género</th>
                <th>Dirección</th>
                <th>Teléfono</th>
                <th>Correo</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
               @forelse($pacientes as $paciente)
                <tr>
                  <td class="text-center"> {{$paciente['pac_id']}} </td>
                  <td class="text-center"> {{$paciente['pac_numero']}} </td>
                  <td> {{$paciente['pac_nombre']}} </td>
                  <td> {{$paciente['pac_paterno']}} </td>
                  <td> {{$paciente['pac_materno']}} </td>
                  <td class="text-center"> {{ $paciente['pac_nacimiento'] }} </td>
                  <td class="text-center"> {{$paciente['pac_genero']}} </td>
                  <td> {{$paciente['pac_direccion']}} </td>
                  <td> {{$paciente['pac_telefono']}} </td>
                  <td> {{$paciente['pac_correo']}} </td>
                  <td>
                    <div class='text-center'>
                      <div class='btn-group'>
                          <a href="{{url('/')}}/expediente-estudios/{{$paciente['pac_id']}}"
                             title="Expediente" id="{{$paciente['pac_id']}}" type="button"
                              class="btn btn-sm btn-primary editarPaciente">
                              <i class="fas fa-folder-plus"></i>
                          </a>
                        <button  title="Editar" id="{{$paciente['pac_id']}}" type="button"
                                 class="ml-2 btn btn-sm btn-primary editarPaciente"
                                 data-toggle="modal" data-target="#editarPaciente_{{$paciente['pac_id']}}">
                          <i class='fas fa-pencil-alt'></i>
                        </button>
                          <button class="btn btn-danger btn-sm eliminarRegistro ml-2" ruta="{{url('/')}}/pacientes"
                                  action="{{url('/')}}/pacientes/{{$paciente['pac_id']}} "
                                  method="DELETE" pagina="administradores" >
                              @csrf
                              <i class="fas fa-trash-alt"></i>
                          </button>
                      </div>
                    </div>
                  </td>
                  @empty
                  <td class="text-center" colspan="11">No existen Pacientes</td>
                    </tr>
              @endif
            </tbody>
          </table>
        </div>
      </div>
  </div>

</div>
<!-- /.card-body -->
  <div class="card-footer">
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

<!--=====================================
Crear Paciente
======================================-->

<div class="modal fade" id="crearPaciente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="exampleModalLabel">
                  <h4>Agrega Paciente </h4>
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
            </div>
          <form action="{{url('/')}}/pacientes" class="bg-light needs-validation" method="post" novalidate>
            @csrf
            <div class="modal-body">
                <div class="row mt-3">
                  <div class="col-md-6">
                    <div class="input-group mb-3 form-group">
                      <div class="input-group-append">
                        <div class="input-group-text">
                         <i class="fas fa-hashtag"></i>
                        </div>
                      </div>
                        <input type="hidden" name="es_cita" id="es_cita" value="0">
                      <input id="pac_numero" type="pac_numero" class="form-control pac_numero @error('pac_numero')
                      is-invalid @enderror" name="pac_numero" value="{{ $ultimoNumeroPaciente + 1 }}"
                             autocomplete="pac_numero" placeholder="Número Paciente">
                       <span class="invalid-feedback" role="alert">
                        {{$errors->first('pac_numero')}}
                      </span>
                  </div>
                </div>
                </div>
                <div class="row mt-3">
                  <div class="col-md-12">
                    <div class="input-group mb-3 form-group">
                      <div class="input-group-append">
                        <div class="input-group-text">
                          <i class="nav-icon fas fa-user-injured"></i>
                        </div>
                      </div>
                      <input id="pac_nombre" type="pac_nombre" class="form-control pac_nombre @error('pac_nombre')
                      is-invalid @enderror"
                             name="pac_nombre" value="{{old('pac_nombre')}}" placeholder="Nombre Paciente" autocomplete="off">
                    <span class="invalid-feedback" role="alert">
                       {{$errors->first('pac_nombre')}}
                    </span>
                    </div>
                  </div>
                </div>

                <div class="row mt-3">
                  <div class="col-md-6">
                    <div class="input-group mb-3">
                      <div class="input-group-append">
                        <div class="input-group-text">
                          <i class="fas fa-signature"></i>
                        </div>
                      </div>
                      <input id="pac_paterno" type="text" class="form-control pac_paterno @error('pac_paterno')
                      is-invalid @enderror" name="pac_paterno" value="{{ old('pac_paterno') }}" required
                             placeholder="Apellido Paterno" autocomplete="off">
                    <span class="invalid-feedback" role="alert">
                       {{$errors->first('pac_paterno')}}
                    </span>
                    </div>
                  </div>

                   <div class="col-md-6">
                    <div class="input-group mb-3">
                      <div class="input-group-append">
                        <div class="input-group-text">
                          <i class="fas fa-signature"></i>
                        </div>
                      </div>
                      <input id="pac_materno" type="email" class="form-control pac_materno @error('pac_materno')
                      is-invalid @enderror" name="pac_materno" value="{{ old('pac_materno') }}"
                             placeholder="Apellido Materno" autocomplete="off">
                    <span class="invalid-feedback" role="alert">
                       {{$errors->first('pac_materno')}}
                    </span>
                    </div>
                  </div>

                </div>

                  <div class="row mt-3">
                    <div class="col-md-6">
                      <div class="input-group mb-3">
                        <div class="input-group-append">
                          <div class="input-group-text">
                              <i class="fas fa-birthday-cake"></i>
                          </div>
                        </div>
                        <input id="date" type="text" class="form-control pac_nacimiento @error('pac_naciemiento')
                        is-invalid @enderror" name="pac_nacimiento" value="{{ old('pac_materno') }}" required
                               placeholder="Edad" autofocus>
                      <span class="invalid-feedback" role="alert">
                          <strong>
                            {{$errors->first('pac_naciemiento')}}</strong>
                      </span>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="input-group mb-3">
                        <div class="input-group-append">
                          <div class="input-group-text">
                            <i class="fas fa-venus-mars"></i>
                          </div>
                        </div>
                        <select name="pac_genero" id="pac_genero" class="form-control pac_genero @error('pac_genero') is-invalid @enderror">
                            <option value="M">Masculino</option>
                            <option value="F">Femenino</option>
                        </select>
                      <span class="invalid-feedback" role="alert">
                          <strong>
                            {{$errors->first('pac_genero')}}</strong>
                      </span>
                      </div>
                    </div>
                  </div>
                  <div class="row mt-3">
                    <div class="col-md-12">
                      <div class="input-group mb-3">
                        <div class="input-group-append">
                          <div class="input-group-text">
                            <i class="fas fa-map"></i>
                          </div>
                        </div>
                        <input id="pac_direccion" type="pac_direccion" class="form-control pac_direccion
                        @error('pac_direccion') is-invalid @enderror" name="pac_direccion"
                               value="{{ old('pac_direccion') }}"  autocomplete="pac_direccion"
                               placeholder="Dirección" autocomplete="off">
                      </div>
                    </div>
                  </div>

                 <div class="row mt-3">
                  <div class="col-md-5">
                    <div class="input-group mb-3">
                      <div class="input-group-append">
                        <div class="input-group-text">
                          <i class="fas fa-mobile-alt"></i>
                        </div>
                      </div>
                      <input id="pac_telefono" type="text" class="form-control pac_telefono @error('pac_telefono')
                      is-invalid @enderror" name="pac_telefono" value="{{ old('pac_telefono') }}"
                             required autocomplete="pac_telefono" placeholder="Telefono" autocomplete="off">
                      <span class="invalid-feedback" role="alert">
                       {{$errors->first('pac_telefono')}}
                    </span>
                    </div>
                  </div>

                   <div class="col-md-7">
                    <div class="input-group mb-3">
                      <div class="input-group-append">
                        <div class="input-group-text">
                          <i class="fas fa-envelope"></i>
                        </div>
                      </div>
                      <input id="pac_correo" type="email" class="form-control pac_correo @error('pac_correo')
                      is-invalid @enderror" name="pac_correo" value="{{ old('pac_correo') }}"  placeholder="Correo"
                             autocomplete="off" >
                    <span class="invalid-feedback" role="alert">
                       {{$errors->first('pac_correo')}}
                    </span>
                    </div>
                  </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                <button type="submit" name="guardarEquipo" id="btnGuardar" class="btn btn-primary">Guardar</button>
            </div>
        </form>
        </div>
    </div>
</div>


<!--=====================================
Editarr Paciente
======================================-->
    @foreach($pacientes as $paciente)

     <div class="modal fade" id="editarPaciente_{{$paciente['pac_id']}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog"  role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="exampleModalLabel">
                        <h4>Editar Paciente </h4>
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{url('/')}}/pacientes/{{$paciente['pac_id']}}" class="bg-light needs-validation"
                      method="post" novalidate>
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="input-group mb-3 form-group">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <i class="fas fa-hashtag"></i>
                                        </div>
                                    </div>
                                    <input type="hidden" name="pac_id" id="pac_id" value="{{$paciente['pac_id']}}">
                                    <input id="pac_numero" type="pac_numero" class="form-control pac_numero
                                        @error('pac_numero') is-invalid @enderror" name="pac_numero"
                                           value="{{$paciente['pac_numero'] }}"  autocomplete="pac_numero"
                                           placeholder="Número Paciente" autocomplete="off">
                                    <span class="invalid-feedback" role="alert">
                                    {{$errors->first('pac_numero')}}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="input-group mb-3 form-group">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <i class="nav-icon fas fa-user-injured"></i>
                                        </div>
                                    </div>
                                    <input id="pac_nombre" type="pac_nombre" class="form-control pac_nombre
                                    @error('pac_nombre') is-invalid @enderror" name="pac_nombre"
                                           value="{{ $paciente['pac_nombre']  }}" placeholder="Nombre Paciente"
                                           autocomplete="off">
                                    <span class="invalid-feedback" role="alert">
                       {{$errors->first('pac_nombre')}}
                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <i class="fas fa-signature"></i>
                                        </div>
                                    </div>
                                    <input id="pac_paterno" type="text" class="form-control pac_paterno
                                    @error('pac_paterno') is-invalid @enderror" name="pac_paterno"
                                           value="{{ $paciente['pac_paterno'] }}" required  placeholder="Apellido Paterno"
                                           autocomplete="off">
                                    <span class="invalid-feedback" role="alert">
                                    {{$errors->first('pac_paterno')}}
                                 </span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <i class="fas fa-signature"></i>
                                        </div>
                                    </div>
                                    <input id="pac_materno" type="email" class="form-control pac_materno
                                    @error('pac_materno') is-invalid @enderror" name="pac_materno"
                                           value="{{ $paciente['pac_materno'] }}"  autocomplete="off"
                                           placeholder="Apellido Materno" autofocus>
                                    <span class="invalid-feedback" role="alert">
                       {{$errors->first('pac_materno')}}
                    </span>
                                </div>
                            </div>

                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <i class="fas fa-birthday-cake"></i>
                                        </div>
                                    </div>
                                    <input id="date" type="text" class="form-control pac_nacimiento @error('pac_naciemiento')
                                    is-invalid @enderror" name="pac_nacimiento"
                                           value="{{ $paciente['pac_nacimiento'] }}" required
                                           placeholder="Edad" autofocus>
                                    <span class="invalid-feedback" role="alert"><strong>
                            {{$errors->first('pac_naciemiento')}}</strong>
                      </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <i class="fas fa-venus-mars"></i>
                                        </div>
                                    </div>
                                    <select name="pac_genero" id="pac_genero" class="form-control pac_genero
                                    @error('pac_genero') is-invalid @enderror">
                                        <option value="M"
                                                @if( $paciente['pac_genero'] == "M" ) selected @endif
                                        >
                                        Masculino
                                        </option>
                                        <option value="F"
                                                @if( $paciente['pac_genero'] == "F" ) selected @endif
                                        >Femenino
                                        </option>
                                    </select>
                                    <span class="invalid-feedback" role="alert">
                          <strong>
                            {{$errors->first('pac_genero')}}</strong>
                      </span>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <i class="fas fa-map"></i>
                                        </div>
                                    </div>
                                    <input id="pac_direccion" type="pac_direccion" class="form-control pac_direccion
                                    @error('pac_direccion') is-invalid @enderror" name="pac_direccion"
                                           value="{{$paciente['pac_direccion']}}"  autocomplete="pac_direccion"
                                           placeholder="Dirección" autocomplete="off">
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-5">
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <i class="fas fa-mobile-alt"></i>
                                        </div>
                                    </div>
                                    <input id="pac_telefono" type="text" class="form-control pac_telefono
                                    @error('pac_telefono') is-invalid @enderror" name="pac_telefono"
                                           value="{{ $paciente['pac_telefono'] }}" required autocomplete="off"
                                           placeholder="Telefono" autofocus>
                                    <span class="invalid-feedback" role="alert">
                       {{$errors->first('pac_telefono')}}
                    </span>
                                </div>
                            </div>

                            <div class="col-md-7">
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <i class="fas fa-envelope"></i>
                                        </div>
                                    </div>
                                    <input id="pac_correo" type="email" class="form-control pac_correo @error('pac_correo')
                                    is-invalid @enderror" name="pac_correo"
                                           value="{{ $paciente['pac_correo'] }}"  placeholder="Correo" >
                                    <span class="invalid-feedback" role="alert">
                       {{$errors->first('pac_correo')}}
                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                        <button type="submit" name="guardarEquipo" id="btnGuardar" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @endforeach


{{--Editar Baner--}}

  <script>
 // $("#crearPaciente").modal()
  </script>




@if (Session::has("ok-crear"))

  <script>
      notie.alert({ type: 1, text: '¡El Paciente ha sido creado correctamente!', time: 10 })
 </script>

@endif

@if (Session::has("ok-editar"))

    <script>
        notie.alert({ type: 1, text: '¡El Paciente ha sido actualizado correctamente!', time: 10 })
    </script>

@endif

@if (Session::has("existe-editar"))

    <script>
        notie.alert({ type: 3, text: '¡El  nùmero de  Paciente  ya existe !', time: 10 });
    </script>

@endif

@if (Session::has("existe-cita"))

    <script>
        notie.alert({ type: 3, text: '¡El  cliente tiene citas asociadas por lo cual no podra se eliminado!', time: 10 });
    </script>

@endif

@if ($errors->any())
    <script>
    // $("#editarPaciente").modal()
    notie.alert({ type: 3, text: '¡Error al actualizar el paciente!', time: 10 });
    </script>
@endif

@endsection('content')
