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
                        <h1>Receta</h1>
                    </div>
                </div>
                <a  href="{{ url('/') }}/historia/{{$consulta->cit_id}}" class="btn btn-primary btn-sm mt-4" >
                    <i class="fas fa-file-medical"></i> <span>Historia Clínica</span>

                </a>
                <a href="{{ url('/') }}/consulta/{{$consulta->cit_id}}" class="btn btn-primary btn-sm mt-4">
                    <i class="fas fa-file-medical"></i> <span>Consulta</span>
                </a>
                <a href="{{ url('/') }}/receta/{{$consulta->cit_id}}" class="btn btn-primary btn-sm mt-4">
                    <i class="fas fa-file-medical"></i> <span>Receta</span>
                </a>
                <a href="{{ url('/') }}/estudios/{{$consulta->cit_id}}" class="btn btn-primary btn-sm mt-4" >
                    <i class="fas fa-file-medical"></i> <span>Estudios</span>
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
                                <div class="row">
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
                            </div>
                            <div class="row mt-3">
                                <div class="col-sm-12 text-center bg-pr">
                                    <span class="font-weight-bold"> Receta </span>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-sm-10 m-2 m-auto">
                                    @if($statusReceta == 400)
                                        <div class="container mb-5">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <button title="Agregar" id="btnNuevoReceta" type="button"
                                                            class="btn btn-primary">
                                                        <i class="fas fa-plus-square"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row container container-fluid mb-5 caja p-4 d-none">
                                            <form action="{{url('/')}}/receta" class="bg-light form-inline w-100 p-4 "
                                                  method="post" novalidate name="agregaRecetaForm" id="recetaForm">
                                                @csrf
                                                <input type="hidden" name="fila" class="fila" id="fila" value="0">
                                                <input type="hidden" name="numero_inputs" id="numero_inputs" value="">
                                                <input type="hidden" name="cit_id" id="cit_id"
                                                       value="{{$consulta->cit_id}}">

                                                <span class="col-sm-7 text-center font-weight-bold">Medicamento</span>
                                                <span class="col-sm-2 text-center font-weight-bold">Dosis</span>
                                                <span class="col-sm-2 text-center font-weight-bold">Duración</span>
                                                <span class="col-sm-1"></span>
                                                <div class="col-sm-12 mt-2 float-right d-none">
                                                    <button type="submit" name="guardarReceta" id="btnGuardarReceta"
                                                            class="btn btn-primary float-right">
                                                        Guardar Receta
                                                    </button>
                                                    <button id="cancelar" type="reset"
                                                            class="btn btn-light float-right">Cancelar
                                                    </button>
                                                </div>
                                                <hr/>
                                            </form>
                                        </div>
                                    @else
                                        <div class="container mb-5">
                                            <div class="row">
                                                <div class="col-sm-1">
                                                    <button title="Modificar Receta" title="Agregar" id="btnNuevoReceta"
                                                            type="button"
                                                            class="btn btn-warning text-white">
                                                        <i class="fas fa-plus-square"></i>
                                                    </button>
                                                </div>
                                                <div class="col-sm-3 mt-3 mt-sm-0 ml-md-4 ml-lg-0">
                                                    <a href="{{ url('/') }}/receta_pdf/{{$consulta->cit_id}}" title="Descargar Receta" title="Agregar" id="btnNuevoReceta"
                                                            class="btn btn-primary text-white" target="_blank">
                                                        <i class="fas fa-file-download"></i>
                                                         Descargar Receta
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row container container-fluid mb-5  caja p-4" id="receta">
                                            <form action="{{url('/')}}/receta" class="bg-light form-inline w-100 p-4 "
                                                  method="post" novalidate name="agregaRecetaForm" id="recetaForm">
                                                @csrf
                                                <input type="hidden" name="numero_inputs" id="numero_inputs"
                                                       value="{{$cantidadRegistros}}">
                                                <input type="hidden" name="cit_id" id="cit_id"
                                                       value="{{$consulta->cit_id}}">

                                                <span class="col-sm-7 text-center font-weight-bold ">Medicamento</span>
                                                <span class="col-sm-2 text-center font-weight-bold ">Dosis</span>
                                                <span class="col-sm-2 text-center font-weight-bold ">Duración</span>
                                                <span class="col-sm-1 text-center font-weight-bold "></span>
                                                @foreach($receta as $key => $medicamento)
                                                    <input type="hidden" name="rec_id" id="rec_id"
                                                           value="{{$medicamento->rec_id}}">
{{--                                                    <label for="" class="col-sm-1"> {{$key + 1}}  </label>--}}
                                                    <input class="form-control input-nuevo col-sm-7  mt-2"
                                                           type="text" name="medicamento_{{$key + 1}}"
                                                           value="{{$medicamento->rec_medicamento}}"
                                                           placeholder="Medicamento">
                                                    <input class="form-control input-nuevo  col-sm-2  mt-2"
                                                           type="text" name="dosis_{{$key + 1}}"
                                                           value="{{$medicamento->rec_dosis}}"
                                                           placeholder="Dosis">
                                                    <input class="form-control input-nuevo  col-sm-2 mt-2"
                                                           type="text" name="duracion_{{$key + 1}}"
                                                           value="{{$medicamento->rec_duracion}}"
                                                           placeholder="Duración">
                                                    <input type="hidden" name="fila" class="fila" id="fila"
                                                           value="{{$cantidadRegistros}}">
                                                    <a title="Eliminar" class="btn btn-danger btn-sm eliminarRegistro ml-2 mt-3 mt-md-0 text-white"
                                                       style="cursor: pointer"
                                                       tabla="0"
                                                       ruta="{{url('/')}}/receta-elimina"
                                                       action="{{url('/')}}/receta-elimina/{{$medicamento['rec_id']}} "
                                                       method="DELETE" >
                                                        @csrf
                                                        <i class="fas fa-trash-alt text-white"></i>
                                                    </a>
                                                @endforeach
                                                <div class="col-sm-12 mt-4 float-right botones">
                                                    <button type="submit" name="guardarReceta" id="btnGuardarReceta"
                                                            class="btn btn-primary float-right text-center">
                                                        Guardar Receta
                                                    </button>
                                                    <a href="{{url('/')}}/receta/{{$consulta->cit_id}}"
                                                       title="Cancelar" id="cancelar"
                                                            class="btn btn-light float-right">Cancelar
                                                    </a>
                                                </div>
                                            </form>
                                        </div>
                                    @endif
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
                                    <input type="text" name="url" id="url" value="{{url('/')}}/receta/{{$consulta->cit_id}}">
                                    <input type="hidden" name="cit_id" id="cit_id" value="{{$consulta->cit_id}}">
                                    <input type="hidden" name="fecha" id="fecha" value=" {{date('Y-m-d')}}">
                                    <input class="form-control" type="text" name="medicamento" id="medicamento"
                                           value="{{old('rec_medicamento')}}"
                                           placeholder="Medicamento">
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
            // notie.alert({type: 3, text: '¡Error al actualizar el Registro !', time: 10});
        </script>
    @endif

@endsection('content')
