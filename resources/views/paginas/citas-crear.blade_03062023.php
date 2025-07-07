@extends('plantilla')
@section('content')

    {{ date_default_timezone_set('America/Mexico_City')  }}

    <div class="content-wrapper" style="min-height: 247px;">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Citas</h1>
                    </div>
                    {{--                    <div class="col-sm-6">--}}
                    {{--                        <ol class="breadcrumb float-sm-right">--}}
                    {{--                            <li class="breadcrumb-item"><a href="{{url('/')}}">Registrar</a></li>--}}
                    {{--                            <li class="breadcrumb-item active">Administradores</li>--}}
                    {{--                        </ol>--}}
                    {{--                    </div>--}}
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
                                {{--                                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#crearPaciente">--}}
                                {{--                                    Crear nueva cita--}}
                                {{--                                </button>--}}
                                <div class="row">
                                    <div class="col-md-12">
                                        <form action="{{url('/')}}/citas-crear" class="bg-light needs-validation"
                                              method="post" novalidate>
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-append">
                                                            <div class="input-group-text">
                                                                <i class="nav-icon fas fa-calendar-alt color-claro"></i>
                                                            </div>
                                                        </div>
                                                        <input id="fecha" type="date" class="form-control
                                                    fecha @error('fecha')
                                                    is-invalid @enderror" name="fecha" value="{{date("Y-m-d")}}"
                                                               required autocomplete="email" autofocus>
                                                        @error('fecha')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                         </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-append">
                                                            <div class="input-group-text">
                                                                <i class="fas fa-history color-claro"></i>
                                                            </div>
                                                        </div>
                                                        <input id="hora" type="time" class="form-control
                                                  hora @error('hora') is-invalid
                                                    @enderror" name="hora" value="{{date('H:i')}}" autofocus>
                                                        @error('hora')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                         </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-append">
                                                            <div class="input-group-text">
                                                                <i class="nav-icon fas fa-user-injured color-claro"></i>
                                                            </div>
                                                        </div>
                                                        <select class="form-control" name="id" id="id" required>
                                                            <option value="">--Seleccione--</option>
                                                            @foreach( $pacientes as $paciente)
                                                                <option value=" {{$paciente['pac_id']}}  ">
                                                                    {{ $paciente['pac_nombre'] . " " . $paciente['pac_paterno'] . " " . $paciente['pac_materno']  }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <span class="ml-2">
                                                         <a style="cursor:pointer" title="Agrega Paciente"
                                                            class="btn btn-success btn-sm text-white"
                                                            data-toggle="modal">
                                                             <i class=" nav-icon fas fa-user-injured"
                                                                data-toggle="modal" data-target="#crearPaciente">
                                                             </i>
                                                        </a>
                                                    </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-3">

                                                <div class="col-md-2 mt-3 mt-sm-0">
                                                    <button data-toggle="crearPaciente" type="reset"
                                                            class="btn  btn-block btn-flat btn-danger"> Cancelar
                                                    </button>
                                                </div>
                                                <div class="col-md-2">
                                                    <button class="btn btn-primary btn-block btn-flat mt-3 mt-md-0">
                                                        Guardar
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body mt-5">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="table-responsive ">
                                            <table id="tablaCitas"
                                                   class="table table-striped table-bordered table-condensed"
                                                   style="width:100%">
                                                <thead class="text-center">
                                                <tr class="badge-primary">
                                                    <th>Id Cita</th>
                                                    <th>Número Paciente</th>
                                                    <th>Paciente</th>
                                                    <th>Fecha</th>
                                                    <th>Hora</th>
                                                    <th>Acciones</th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                @foreach($citas as $cita)
                                                    <tr>
                                                        <td class="text-center"> {{$cita['cit_id']}} </td>
                                                        <td class="text-center"> {{ $cita['pac_numero']  }} </td>
                                                        <td>
                                                            {{$cita['pac_nombre'] . " " . $cita['pac_paterno'] . " " . $cita['pac_materno']  }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{ date('d-m-Y', strtotime($cita['cit_fecha']))   }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{ $cita['cit_hora']  }}
                                                        </td>
                                                        <td>
                                                            <div class='text-center'>
                                                                <div class='btn-group'>
                                                                    <a class="btn btn-primary " title="Consulta"
                                                                       href="{{url('/consulta')}}/{{$cita->cit_id}}">
                                                                        <i class="fas fa-user-md"></i>

                                                                    </a>
                                                                    <button title="Editar" id="" type="button"
                                                                            class="btn btn-warning  editarCita ml-2"
                                                                            data-toggle="modal"
                                                                            data-target="#editarCita_{{$cita->cit_id}}">
                                                                        <i class='fas fa-pencil-alt'></i>

                                                                    </button>
                                                                    <button
                                                                        class="btn btn-danger  eliminarRegistro ml-2"
                                                                        ruta="{{url('/')}}/citas-crear"
                                                                        action="{{url('/')}}/citas-crear/{{$cita['cit_id']}} "
                                                                        method="DELETE" pagina="administradores">
                                                                        @csrf
                                                                        <i class="fas fa-trash-alt"></i>

                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
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

    <!--Modal crear paciente-->
    <div class="row">
        <div class="modal fade" id="crearPaciente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog " style="" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title" id="exampleModalLabel">
                            <h4>Agrega Paciente </h4>
                        </h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span>
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
                                        <input type="hidden" name="es_cita" id="es_cita" value="1">
                                        <input id="pac_numero" type="pac_numero"
                                               class="form-control pac_numero @error('pac_numero') is-invalid @enderror"
                                               name="pac_numero" value="{{ $siguienteNumero }}"
                                               autocomplete="pac_numero"
                                               placeholder="Número Paciente">
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
                                        <input id="pac_nombre" type="pac_nombre"
                                               class="form-control pac_nombre @error('pac_nombre') is-invalid @enderror"
                                               name="pac_nombre" value="{{ old('pac_nombre') }}"
                                               placeholder="Nombre Paciente">
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
                                        <input id="pac_paterno" type="text"
                                               class="form-control pac_paterno @error('pac_paterno') is-invalid @enderror"
                                               name="pac_paterno" value="{{ old('pac_paterno') }}" required
                                               placeholder="Apellido Paterno" autofocus>
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
                                        <input id="pac_materno" type="email"
                                               class="form-control pac_materno @error('pac_materno') is-invalid @enderror"
                                               name="pac_materno" value="{{ old('pac_materno') }}"
                                               autocomplete="pac_materno" placeholder="Apellido Materno" autofocus>
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
                                                <i class="fas fa-calendar-alt"></i>
                                            </div>
                                        </div>
                                        <input id="date" type="date"
                                               class="form-control pac_nacimiento @error('pac_naciemiento') is-invalid @enderror"
                                               name="pac_nacimiento" value="{{ date('Y-m-d') }}" required
                                               placeholder="Fecha Nacimiento" autofocus>
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
                                        <select name="pac_genero" id="pac_genero"
                                                class="form-control pac_genero @error('pac_genero') is-invalid @enderror">
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
                                        <input id="pac_direccion" type="pac_direccion"
                                               class="form-control pac_direccion @error('pac_direccion') is-invalid @enderror"
                                               name="pac_direccion" value="{{ old('pac_direccion') }}"
                                               autocomplete="pac_direccion" placeholder="Dirección" autofocus>
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
                                        <input id="pac_telefono" type="text"
                                               class="form-control pac_telefono @error('pac_telefono') is-invalid @enderror"
                                               name="pac_telefono" value="{{ old('pac_telefono') }}" required
                                               autocomplete="pac_telefono" placeholder="Teléfono" autofocus>
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
                                        <input id="pac_correo" type="email"
                                               class="form-control pac_correo @error('pac_correo') is-invalid @enderror"
                                               name="pac_correo" value="{{ old('pac_correo') }}" placeholder="Correo">
                                        <span class="invalid-feedback" role="alert">
                       {{$errors->first('pac_correo')}}
                    </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                            <button type="submit" name="guardarEquipo" id="btnGuardar" class="btn btn-primary">
                                Guardar
                            </button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!--Editar Cita -->
    @foreach($citas as $cita)
        <div class="modal fade" id="editarCita_{{$cita->cit_id}}" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title" id="exampleModalLabel">
                            <h4>Editar Cita </h4>
                        </h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{url('/')}}/citas-crear/{{$cita->cit_id}}" class="bg-light " method="post" novalidate
                          name="editaCitaForm" id="editaCitaForm">
                        @csrf
                        @method('PUT')
                        <div class="modal-body" id="modal-body-editar">
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <div class="input-group mb-3">
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <i class="fas fa-calendar-alt"></i>
                                            </div>
                                        </div>
                                        <input type="hidden" id="{{$cita->cit_id}}" value="${data.cita[0].cit_id}">
                                        <input id="fecha" type="date" class="form-control fecha"
                                               name="fecha" value="{{$cita->cit_fecha}}" required autofocus>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <div class="input-group mb-3">
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <i class="fas fa-calendar-alt"></i>
                                            </div>
                                        </div>
                                        <input id="hora" type="time" class="form-control hora"
                                               name="hora" value="{{$cita->cit_hora}}" required autofocus>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <div class="input-group mb-3">
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <i class="fas fa-calendar-alt"></i>
                                            </div>
                                        </div>
                                        <select class="form-control" name="id" id="id" required>
                                            @foreach( $pacientes as $paciente)
                                                <option value=" {{$paciente['pac_id']}}  "

                                                        @if( $paciente->pac_id == $cita->cit_pac_id ) selected @endif
                                                >
                                                    {{ $paciente['pac_nombre'] . " " . $paciente['pac_paterno'] . " " . $paciente['pac_materno']  }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                            <button type="submit" name="guardarCita" id="btnGuardarCita" class="btn btn-primary">
                                Guardar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach


    @if (Session::has("ok-crear-cita"))

        <script>
            notie.alert({type: 1, text: '¡El Cita ha sido creada correctamente!', time: 10})
        </script>

    @endif

    @if (Session::has("ok-editar"))

        <script>
            notie.alert({type: 1, text: '¡El Paciente ha sido actualizado correctamente!', time: 10})
        </script>

    @endif

    @if (Session::has("ok-editar-cita"))

        <script>
            notie.alert({type: 1, text: '¡El Cita ha sido actualizada correctamente!', time: 10})
        </script>

    @endif

    @if (Session::has("existe-editar-cita"))

        <script>
            notie.alert({type: 1, text: '¡El Cita ha sido actualizada correctamente!', time: 10})
        </script>

    @endif

    @if (Session::has("existe-update"))

        <script>
            notie.alert({type: 1, text: '¡El Cita de  Cliente  ya existe !', time: 10});
        </script>

    @endif

    @if (Session::has("no-editar-cita"))

        <script>
            notie.alert({type: 3, text: '¡Error al actualizar la Cita !', time: 10})
        </script>

    @endif

    @if (Session::has("ok-crear-paciente"))

        <script>
            notie.alert({type: 1, text: '¡El Paciente ha sido creado correctamente!', time: 10})
        </script>

    @endif

    @if ($errors->any())
        <script>
            // $("#editarPaciente").modal()
            notie.alert({type: 3, text: '¡Error al actualizar la Cita !', time: 10})
        </script>
    @endif

@endsection('content')
