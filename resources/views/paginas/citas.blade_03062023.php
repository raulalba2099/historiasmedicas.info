
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
                <button   class="btn btn-primary btn-sm" data-toggle="modal"  data-target="#crearCita">
                    <i class="nav-icon fas fa-calendar-alt"></i>
                    Crear Cita
                </button>
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
                                                            <i class="fas fa-calendar-alt"></i>
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
                                                            <i class="fas fa-calendar-alt"></i>
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
        notie.alert({ type: 1, text: '¡El Cita ha sido creada correctamente!', time: 10 })
    </script>

@endif

@endsection('content')


