@extends('plantilla')
@section('content')


    <?php
        use App\Http\Controllers\PacienteController;
        $pac = new PacienteController();
        $fisicos = [];
    ?>

    <div class="content-wrapper" style="min-height: 247px;">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Recetas: {{$paciente->pac_nombre}} {{$paciente->pac_paterno}} {{$paciente->pac_materno}} </h1>
                    </div>
                </div>

{{--                <a  href="{{ url('/') }}/expediente-estudios/{{$paciente->pac_id}}" class="btn btn-primary btn-sm mt-4" >--}}
{{--                    <i class="fas fa-file-medical"></i> <span>Estudios</span>--}}
{{--                </a>--}}

{{--                <a  href="{{ url('/') }}/expediente-fisico/{{$paciente->pac_id}}" class="btn btn-primary btn-sm mt-4" >--}}
{{--                    <i class="fas fa-file-medical"></i> <span>Exámen Físico</span>--}}
{{--                </a>--}}

{{--                @if(auth()->user()->esp_id == 1)--}}
{{--                <a  href="{{ url('/') }}/expediente-historia/{{$paciente->pac_id}}" class="btn btn-primary btn-sm mt-4" >--}}
{{--                    <i class="fas fa-file-medical"></i> <span>Historia Clínica</span>--}}
{{--                </a>--}}
{{--                @endif--}}

{{--                <a  href="{{ url('/') }}/expediente-notas/{{$paciente->pac_id}}" class="btn btn-primary btn-sm mt-4" >--}}
{{--                    <i class="fas fa-file-medical"></i> <span>Notas de Evolución </span>--}}
{{--                </a>--}}

{{--                @if(auth()->user()->esp_id == 2)--}}
{{--                    <a href="{{ url('/') }}/expediente-menu/{{$paciente->pac_id}}/{{date('Y-m-d')}}" class="btn btn-primary btn-sm mt-4">--}}
{{--                        <i class="fas fa-utensils"></i></i> <span>Menu</span>--}}
{{--                    </a>--}}
{{--                @endif--}}

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
                                <div class="row">
                                    <div class="col-sm-6">
                                        <h6>
                                            <span class="font-weight-bold">Paciente:</span>
{{--                                            {{ $paciente['pac_nombre']}}--}}
{{--                                            {{ $paciente['pac_paterno']}}--}}
{{--                                            {{ $paciente['pac_materno']}}--}}
                                        </h6>
                                    </div>
                                    <div class="col-sm-6">
                                        <h6 class="float-right">
                                            <span class="font-weight-bold">Fecha de Hoy:</span>
                                            {{ date('d-M-Y') }}
                                        </h6>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <h6>
{{--                                            <span class="font-weight-bold">Edad</span>--}}
{{--                                            {{$paciente['pac_nacimiento']}}--}}
                                        </h6>

                                    </div>
                                </div>

                            </div>

                            <div class="card-body">

                                <div class="card-header">
                                </div>
                                <div class="row text-center" >
                                    <div class="col-sm-12">
                                        <input type="hidden" id="pac_id" name="pac_id" value="{{$paciente->pac_id}}">
                                        <input type="hidden" id="espId" name="esp_id" value="{{auth()->user()->esp_id}}">
                                        <input type="hidden" name="module" id="module" class="module" value="4"
                                               method="GET"
                                               action="{{url('/')}}/receta-expediente-cita/{{$paciente->pac_id}}">
                                        @csrf
                                        <div id="containerCalendar" class="calendar-container" ></div>
                                    </div>
                                </div>
                                <?php
                                print '
                         <script>
                    var $calendar;
                    $(document).ready(function () {
                        let container = $("#containerCalendar").simpleCalendar({
                            fixedStartDay: 0, // begin weeks by sunday
                            disableEmptyDetails: true,
                         events:
                            ['; ?>
                                @foreach($recetasCalendar as $key => $valor)
                                    {{
                                        '{
                                             startDate: new Date(new Date().setHours(new Date().getHours() - '.$valor["horas"].' )).toISOString(),
                                            endDate: new Date(new Date().setHours(new Date().getHours() -  '.$valor["horas"].')).getTime(),
                                        },'
                                    }}
                                @endforeach
                                <?php
                                print '
                                ],
                        });

                        $calendar = container.data("plugin_simpleCalendar")
                    });
                </script>
                  ' ?>

                                    <div class="row">
                                            <div class="col-sm-10 m-2 m-auto">
                                                    <div class="caja-mediana d-none" id="expediente-receta">
                                                        <div class="row m-0 m-auto">
                                                            <div class="col-sm-12 text-center ">
                                                                <span id="receta-label" class="font-weight-bold"> Receta </span>
                                                            </div>
                                                        </div>
                                                        <div class="container container-fluid mb-5 p-4" id="receta">
                                                            <div class="table-responsive fuenteTabla">
                                                                <table id="" class="table table-striped table-bordered table-condensed" style="width:100%" >
                                                                    <thead class="text-center">
                                                                    <tr class="badge-primary">
                                                                        <th>Médicamento</th>
                                                                        <th>Dosis</th>
                                                                        <th>Duracion Paterno</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody id="receta-body"></tbody>
                                                                </table>
                                                            </div>
{{--                                                            <div class="row bg-primary">--}}
{{--                                                                    @csrf--}}
{{--                                                                    <div class="col-sm-7 text-center font-weight-bold ">Medicamento</div>--}}
{{--                                                                    <div--}}
{{--                                                                        class="col-sm-2 text-center font-weight-bold ">Dosis</div>--}}
{{--                                                                    <div class="col-sm-2 text-center font-weight-bold ">Duración</div>--}}
{{--                                                                    <div class="col-sm-1 text-center font-weight-bold "></div>--}}
{{--                                                            </div>--}}

                                                        </div>
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

    <!--Agregar Receta -->
    <div class="modal fade" id="agregaReceta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Receta
                    </h5>
                </div>
                <form action="{{url('/')}}/receta" class="bg-light "
                      method="post" novalidate name="agregaRecetaForm" id="agregaRecetaForm">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <i class="fas fa-file-medical"></i>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <i class="fas fa-file-medical"></i>
                                        </div>
                                    </div>
                                    <input class="form-control" type="text" name="dosis" id="dosis"
                                           value="{{old('rec_dosis')}}"
                                           placeholder="Dosis">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <i class="fas fa-file-medical"></i>
                                        </div>
                                    </div>
                                    <input class="form-control" type="text" name="duracion" id="duracion"
                                           value="{{old('rec_duracion')}}"
                                           placeholder="Duracion">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <i class="fas fa-file-medical"></i>
                                        </div>
                                    </div>
                                    <input class="form-control" type="text" name="nota" id="nota"
                                           value="{{old('rec_nota')}}"
                                           placeholder="Nota">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                        <button type="submit" name="guardarConsulta" id="btnGuardarConsulta" class="btn btn-primary">
                            Guardar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    @if (Session::has("ok-crear-receta"))

        <script>
            notie.alert({type: 1, text: '¡La receta ha sido creada correctamente!', time: 2})
        </script>

    @endif

    @if ($errors->any())
         {{$errors}}
        <script>
            // $("#editarPaciente").modal()
            // notie.alert({type: 3, text: '¡Error al actualizZZ a  ar el Registro !', time: 10});
        </script>
    @endif

@endsection('content')
