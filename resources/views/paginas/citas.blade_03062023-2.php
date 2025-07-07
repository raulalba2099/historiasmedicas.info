
@extends('plantilla')
@section('content')

<?php
    use \App\Http\Controllers\CitaController;
    $datos = CitaController::indexAction();
?>

<div class="content-wrapper" style="min-height: 247px;">
  <section class="content-header">

    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Calendario</h1>

{{--            {{dd($datos)}}--}}
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
                <button style="cursor:pointer"   class="btn btn-primary btn-sm" data-toggle="modal"  data-target="#crearCita">
                    <i class="nav-icon fas fa-calendar-alt"></i>
                    Crear Cita
                </button>
                <button style="cursor:pointer"   class="btn btn-success btn-sm" data-toggle="modal"  data-target="#crearPacienteCalendario">
                    <i class="nav-icon fas fa-user-injured"></i>
                    Agregar Paciente
                </button>
{{--                <a style="cursor:pointer" title="Agrega Paciente"--}}
{{--                   class="btn btn-success btn-sm text-white"--}}
{{--                   data-toggle="modal">--}}
{{--                    <i class=" nav-icon fas fa-user-injured"--}}
{{--                       data-toggle="modal" data-target="#crearPacienteCalendario">--}}
{{--                    </i> Agregar Paciente--}}
{{--                </a>--}}
            </div>
            <div class="card-body">
                <input type="hidden" name="moedule" id="module" class="module" value="1">
                <div id="containerCalendar" class="calendar-container"></div>
            </div>

                <?php
                    print '
                <script>
                    var $calendar;
                    $(document).ready(function () {
                        let container = $("#containerCalendar").simpleCalendar({
                            fixedStartDay: 0, // begin weeks by sunday
                            disableEmptyDetails: true,
                         events: [';
                         foreach ($datos['citas'] as $key => $cita) {
                             print '
                                {
                                  startDate: new Date(new Date().setHours(new Date().getHours() - '.$cita["horas"].' , '.$cita["minutos"].'    )).toISOString(),
                                  endDate: new Date(new Date().setHours(new Date().getHours() -  '.$cita["horas"].')).getTime(),
                                  summary: " <input class=id name=id id=id type=hidden value= '.$cita['cit_id'].'>    '.$cita["pac_nombre"].' '.$cita["pac_paterno"].' '.$cita["pac_materno"].'  "
                                },
                            ';
                         }
                     print '
                         ],

                        });

                        $calendar = container.data("plugin_simpleCalendar")
                    });
                </script>
                  '?>
                    <!--Crear Cita -->
                    <div class="modal fade" id="crearCita" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-primary">
                                    <h5 class="modal-title" id="exampleModalLabel">
                                        <h4>Agregar Cita </h4>
                                    </h5>
                                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="{{url('/')}}/citas-crear" class="bg-light needs-validation" method="post" novalidate>
                                    @csrf
                                    <div class="modal-body" id="modal-body-crear">
                                        <div class="row mt-3">
                                            <div class="col-md-12">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-append">
                                                        <div class="input-group-text">
                                                            <i class="fas fa-calendar-alt"></i>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="mod_calendario" id="mod_calendario" value="1" >
                                                    <input id="fecha" type="date" class="form-control fecha"
                                                           name="fecha" value="{{ date('Y-m-d') }}" required   autofocus>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-md-12">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-append">
                                                        <div class="input-group-text">
                                                            <i class="fas fa-clock"></i>
                                                        </div>
                                                    </div>
                                                    <input id="hora" type="time" class="form-control hora"
                                                           name="hora" value="{{date( 'H:m' ) }}" required   autofocus>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-md-12">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-append">
                                                        <div class="input-group-text">
                                                            <i class="nav-icon fas fa-user-injured"></i>
                                                        </div>
                                                    </div>
                                                    <select class="form-control" name="id" id="id" required>
                                                        @foreach( $datos['pacientes'] as $paciente)
                                                            <option value=" {{$paciente['pac_id']}}">
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
                                        <button type="submit" name="guardarCita" id="btnGuardarCita" class="btn btn-primary">Guardar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

              <!--Modal crear paciente-->
              <div class="row">
                  <div class="modal fade" id="crearPacienteCalendario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
                                                  <input type="hidden" name="es_cita" id="es_cita" value="2">
                                                  <input id="pac_numero" type="pac_numero"
                                                         class="form-control pac_numero @error('pac_numero') is-invalid @enderror"
                                                         name="pac_numero" value="<?= $datos['siguienteNumero'] ?>"
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
                                                          <i class="fas fa-birthday-cake"></i>
                                                      </div>
                                                  </div>
                                                  <input id="date" type="text"
                                                         class="form-control pac_nacimiento @error('pac_naciemiento') is-invalid @enderror"
                                                         name="pac_nacimiento" value="{{ old('pac_nacimiento') }}" required
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




@if (Session::has("ok-crear-cita"))

    <script>
        notie.alert({ type: 1, text: '¡La Cita ha sido creada correctamente!', time: 10 })
    </script>

@endif

@if (Session::has("ok-crear-paciente"))

    <script>
        notie.alert({ type: 1, text: '¡El Paciente ha sido creado correctamente!', time: 10 })
    </script>

@endif

@endsection('content')


