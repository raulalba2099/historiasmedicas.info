@extends('plantilla')
@section('content')

   <?php
    use App\Http\Controllers\HistoriaClinicaRespuestasController;
    use App\Http\Controllers\PacienteController;

    $resp = new HistoriaClinicaRespuestasController();
    $paciente = new PacienteController();
   ?>

    <div class="content-wrapper" style="min-height: 247px;">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-2">
                        <h1>Historia Clínica</h1>
                    </div>
                </div>

                <a href="{{ url('/') }}/consulta/{{$consulta->cit_id}}" class="btn btn-primary btn-sm mt-4">
                    <i class="fas fa-file-medical"></i> <span>Consulta</span>
                </a>
{{--                <a href="{{ url('/') }}/receta/{{$consulta->cit_id}}" class="btn btn-primary btn-sm mt-4">--}}
{{--                    <i class="fas fa-file-medical"></i> <span>Receta</span>--}}
{{--                </a>--}}
                <a href="{{ url('/') }}/estudios/{{$consulta->cit_id}}" class="btn btn-primary btn-sm mt-4">
                    <i class="fas fa-file-medical"></i> <span>Estudios</span>
                </a>
                <a href="{{ url('/') }}/historia/{{$consulta->cit_id}}" class="btn btn-primary btn-sm mt-4">
                    <i class="fas fa-file-medical"></i> <span>Historia Clínica</span>
                </a>
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
                                <div class="row mt-2">
                                    <div class="col-sm-6">
                                        <h6>
                                            <span class="font-weight-bold">Paciente:</span>
                                            {{ $consulta->pac_nombre}}
                                            {{ $consulta->pac_paterno}}
                                            {{ $consulta->pac_materno}}
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
                                            <span class="font-weight-bold">Edad:</span>

                                            {{ $consulta->pac_nacimiento }}

                                        </h6>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <h6>
                                            <span class="font-weight-bold">Fecha y hora de cita:</span>
                                            {{ date('d-M-Y', strtotime($consulta->cit_fecha))  }}
                                            {{ $consulta->cit_hora}}
                                        </h6>
                                    </div>
                                </div>
{{--                                <div class="row mt-3">--}}
{{--                                    <div class="col-sm-6">--}}
{{--                                        <h6>--}}
{{--                                            <span class="font-weight-bold">Razón de su visita:</span>--}}
{{--                                            <textarea class="form-control mt-2" name="" id=""></textarea>--}}
{{--                                        </h6>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                            </div>
                            <div class="card body mt-2 caja  m-0 m-auto mt-3" style="width: 90%;">
                                <form action="{{url('/')}}/historia" class="bg-light needs-validation" method="post" novalidate>
                                    @csrf
                                    <input type="hidden" name="cit_id" id="cit_id" value="{{$consulta->cit_id}}">
                                    <textarea name="descripcion" id="nota" cols="" rows="5"
                                              class="form-control">
                                        @if(!empty($historia))
                                            {{$historia->descripcion}}
                                        @else
                                        <span style="font-weight: bold;">{{$fisico->paciente}}</span> <br/>
                                        <span style="font-weight: bold;">Ficha informacion:
                                            <p>
                                                <label>Presón Arterial Sistólica:</label>
                                                 {{$fisico->presion_arterial_sistolica}}
                                            </p>
                                            <p>
                                            <label>Presón Arterial Diastólica :</label>
                                            {{$fisico->presion_arterial_diastolica}}
                                            </p>
                                            <p>
                                            <label>Presón Arterial Media:</label>
                                                {{$fisico->presion_arterial}}
                                            </p>
                                            <p>
                                            <label>Frecuencia Cardiaca:</label>
                                            {{$fisico->frecuencia_cardiaca}}
                                            </p>
                                            <p>
                                            <label>Frecuencia Respiratoria:</label>
                                            {{$fisico->frecuencia_respiratoria}}
                                            </p>
                                            <p>
                                            <label>Saturación:</label>
                                            {{$fisico->saturacion}}
                                            </p>
                                            <p>
                                            <label>Temperatura:</label>
                                            {{$fisico->temperatura}}
                                            </p>
                                            <p>
                                            <label>Peso:</label>
                                            {{$fisico->peso}}
                                            </p>
                                            <p>
                                            <label>Talla:</label>
                                            {{$fisico->talla}}
                                            </p>
                                            <p>
                                            <label>IMC:</label>
                                            {{$fisico->imc}}
                                            </p>
                                            <p>
                                            <label>Alergías:</label>
                                            {{$fisico->alergias}}
                                            </p>
                                            <p>
                                            <label>Glucosa:</label>
                                            {{$fisico->glucosa}}
                                            </p>
                                            <p>
                                            <label>Dianostico:</label>
                                            {{$fisico->diagnostico}}
                                            </p>
                                            </span> <br/>
                                        <span style="font-weight: bold;">Antecedentes Patológicos:</span> <br/>
                                        <span style="font-weight: bold;">Antecedentes No Patológicos:</span> <br/>
                                        <span style="font-weight: bold;">Antecedentes Heredofamiliares:</span> <br/>
                                        <span style="font-weight: bold;">Ago:</span> <br/>
                                        <span style="font-weight: bold;">Notas de Evolución:</span> <br/>
                                        <span style="font-weight: bold;">Laboratorios:</span> <br/>
                                        @endif

                                    </textarea>
                                    <div class="row">
                                        <div class="col-sm-12 text-center mt-5">
                                            <button class="btn btn-light" type="reset">Cancelar</button>
                                            <button type="submit" name="guardar" id="guardar"
                                                    class="btn btn-primary  text-center">
                                                Guardar
                                            </button>

                                        </div>
                                    </div>
                                </form>
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
        </section>
        <!-- /.content -->
    </div>


    @if (Session::has("ok-crear"))

        <script>
            notie.alert({type: 1, text: '¡La historia clinica ha sido creada correctamente!', time: 10})
        </script>

    @endif

    @if (Session::has("ok-editar"))

        <script>
            notie.alert({type: 1, text: '¡La historía clinica ha sido actualizada correctamente!', time: 10})
        </script>

    @endif

    @if ($errors->any())
        <script>
            // $("#editarPaciente").modal()
            notie.alert({type: 3, text: '¡Error al actualizar el Registro !', time: 10})
        </script>
    @endif

@endsection('content')
