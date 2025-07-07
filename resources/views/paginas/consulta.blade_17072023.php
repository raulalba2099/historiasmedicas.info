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
                        <h1>Consulta</h1>
                    </div>
                </div>

             <div class="menu">
                <a href="{{ url('/') }}/consulta/{{$consulta->cit_id}}" class="btn btn-primary btn-sm mt-4">
                    <i class="fas fa-file-medical"></i> <span>Consulta</span>
                </a>
{{--                <a href="{{ url('/') }}/receta/{{$consulta->cit_id}}" class="btn btn-primary btn-sm mt-4">--}}
{{--                    <i class="fas fa-file-medical"></i> <span>Receta</span>--}}

{{--                </a>--}}

                <a href="{{ url('/') }}/estudios/{{$consulta->cit_id}}" class="btn btn-primary btn-sm mt-4">
                    <i class="fas fa-file-medical"></i> <span>Estudios</span>
                </a>

                @if($especialidad->esp_id == 1)
                <a href="{{ url('/') }}/historia/{{$consulta->cit_id}}" class="btn btn-primary btn-sm mt-4">
                    <i class="fas fa-file-medical"></i> <span>Historia Clínica</span>

                </a>
                 @endif
                @if($especialidad->esp_id == 2)
                    <a href="{{ url('/') }}/menu/{{$consulta->cit_id}}" class="btn btn-primary btn-sm mt-4">
                        <i class="fas fa-file-medical"></i> <span>Menu</span>
                    </a>
                @endif
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
                            <div class="card-body mt-2">
                                <div class="row">
                                    <div class="col-sm-10 m-2 m-auto caja ">
                                        <div class="row">
                                            <div class="col-sm-12 text-center">
                                                <span class="font-weight-bold"> Exámen Físico </span>
                                            </div>
                                        </div>
                                        <div class="container mt-2">
                                            <form action="{{url('/')}}/examen-fisico" class="bg-light "
                                                  method="post" novalidate name="agregaNotaForm" id="agregaNotaForm">
                                                @csrf
                                                <div class="row mt-3">
                                                    <div class="col-sm-4">
                                                        Presón Arterial Sistólica
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-append">
                                                                <div class="input-group-text">
                                                                    <i class="fas fa-heartbeat"></i>
                                                                </div>
                                                            </div>
                                                            <input class="form-control text-right presion_arterial" type="text"
                                                                   name="sistolica"
                                                                   id="sistolica"
                                                                   value="{{ (!empty($fisico) ? $fisico->presion_arterial_sistolica : '' )  }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        Presón Arterial Diastólica
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-append">
                                                                <div class="input-group-text">
                                                                    <i class="fas fa-heartbeat"></i>
                                                                </div>
                                                            </div>
                                                            <input class="form-control text-right presion_arterial" type="text"
                                                                   name="diastolica" id="diastolica"
                                                                   value="{{ (!empty($fisico) ? $fisico->presion_arterial_diastolica : '' )  }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        Presón Arterìal Media
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-append">
                                                                <div class="input-group-text">
                                                                    <i class="fas fa-heartbeat"></i>
                                                                </div>
                                                            </div>
                                                            <input type="hidden" name="cit_fecha" id="cit_fecha"
                                                                   value="{{$consulta->cit_fecha}}">
                                                            <input type="hidden" name="cit_id" id="ci_id"
                                                                   value="{{$consulta->cit_id}}">
                                                            <input type="hidden" name="pac_id" id="pac_id"
                                                                   value="{{$consulta->pac_id}}">
                                                            <input class="form-control text-right" type="text"
                                                                   name="arterial" id="arterial"
                                                                   value="{{ (!empty($fisico) ? number_format($fisico->presion_arterial, 1) : '' )  }}" readonly />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mt-3">
                                                    <div class="col-sm-4">
                                                        Frecuencia Cardiaca
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-append">
                                                                <div class="input-group-text">
                                                                    <i class="fas fa-heartbeat"></i>
                                                                </div>
                                                            </div>
                                                            <input type="hidden" name="cit_fecha" id="cit_fecha"
                                                                   value="{{$consulta->cit_fecha}}">
                                                            <input type="hidden" name="cit_id" id="ci_id"
                                                                   value="{{$consulta->cit_id}}">
                                                            <input type="hidden" name="pac_id" id="pac_id"
                                                                   value="{{$consulta->pac_id}}">
                                                            <input class="form-control text-right" type="text"
                                                                   name="cardiaca" id="cit_id"
                                                                   value="{{ (!empty($fisico) ? $fisico->frecuencia_cardiaca : '' )  }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        Frecuencia Respiratoria
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-append">
                                                                <div class="input-group-text">
                                                                    <i class="fas fa-lungs"></i>
                                                                </div>
                                                            </div>
                                                            <input class="form-control text-right" type="text"
                                                                   name="respiratoria" id="cit_id"
                                                                   value="{{ (!empty($fisico) ? $fisico->frecuencia_respiratoria : '' )  }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        Saturación de Oxigeno
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-append">
                                                                <div class="input-group-text">
                                                                    <i class="fas fa-heartbeat"></i>
                                                                </div>
                                                            </div>
                                                            <input class="form-control text-right" type="text"
                                                                   name="saturacion" id="saturacion"
                                                                   value="{{!empty($fisico) ? $fisico->saturacion : '' }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mt-3">
                                                    <div class="col-sm-4">
                                                        Temperatura
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-append">
                                                                <div class="input-group-text">
                                                                    <i class="fas fa-thermometer"></i>
                                                                </div>
                                                            </div>
                                                            <input class="form-control text-right" type="text"
                                                                   name="temperatura" id="cit_id"
                                                                   value="{{!empty($fisico) ? $fisico->temperatura : '' }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        Peso
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-append">
                                                                <div class="input-group-text">
                                                                    <i class="fas fa-weight"></i>
                                                                </div>
                                                            </div>
                                                            <input class="form-control text-right calcula_imc" type="text"
                                                                   name="peso" id="peso"
                                                                   value="{{!empty($fisico) ? $fisico->peso : '' }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        Talla
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-append">
                                                                <div class="input-group-text">
                                                                    <i class="fas fa-ruler-vertical"></i>
                                                                </div>
                                                            </div>
                                                            <input class="form-control text-right calcula_imc" type="text"
                                                                   name="talla" id="talla"
                                                                   value="{{!empty($fisico) ? $fisico->talla : ''  }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mt-3">
                                                    <div class="col-sm-4">
                                                        IMC
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-append">
                                                                <div class="input-group-text">
                                                                    <i class="fas fa-male"></i>
                                                                </div>
                                                            </div>
                                                            <input class="form-control text-right" type="text"
                                                                   name="imc" id="imc"
                                                                   value="{{!empty($fisico) ? number_format($fisico->imc, 1) : '' }}" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-8">
                                                        Alergias
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-append">
                                                                <div class="input-group-text">
                                                                    <i class="fas fa-file-medical-alt"></i>
                                                                </div>
                                                            </div>
                                                            <input class="form-control" type="text" name="alergias"
                                                                   id="alergias"
                                                                   value="{{!empty($fisico) ? $fisico->alergias : ''  }}">
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        Glucosa
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-append">
                                                                <div class="input-group-text">
                                                                    <i class="fas fa-male"></i>
                                                                </div>
                                                            </div>
                                                            <input class="form-control text-right" type="text"
                                                                   name="glucosa" id="glucosa"
                                                                   value="{{!empty($fisico) ? $fisico->glucosa : '' }}">
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-8">
                                                        Diagnóstico
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-append">
                                                                <div class="input-group-text">
                                                                    <i class="fas fa-file-medical-alt"></i>
                                                                </div>
                                                            </div>
                                                            <input class="form-control" type="text" name="diagnostico"
                                                                   id="cit_id"
                                                                   value="{{!empty($fisico) ? $fisico->diagnostico : ''  }}">
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="botones text-center mt-2">
                                                    <button type="submit" class="btn btn-primary " name="guardarFisico">
                                                        Guardar
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <hr/>
                                @if($especialidad->esp_id != 2)
                                <div class="caja-mediana  m-0 m-auto">
                                    <div class="row mt-5" id="medicamentos">
                                        <div class="col-sm-12 text-center">
                                            <span class="font-weight-bold">Medicamentos </span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-10 m-2 m-auto">
                                            <div class="table-responsive mt-2">
                                                <table id="tablaMedicamentos"
                                                       class="table table-striped table-bordered table-condensed"
                                                       style="width:100%">
                                                    <thead class="text-center">
                                                    <tr class="badge-primary">
                                                        <th>Medicamento</th>
                                                        <th>Dosis</th>
                                                        <th>Duracion</th>
                                                        <th>Fecha</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($medicamentos as $medicamento)
                                                        <tr>
                                                            <td>{{ $medicamento['medicamento']}}</td>
                                                            <td class="text-center">{{$medicamento['dosis']}}</td>
                                                            <td class="text-center">{{$medicamento['duracion']}}</td>
                                                            <td class="text-center">{{$medicamento['fecha']}}</td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                @endif
                                <hr>
                                <div class="caja-mediana m-0 m-auto">
                                    <div class="row mt-5" id="notas">
                                        <div class="col-sm-12 text-center">
                                            <span class="font-weight-bold"> Notas de Evoluciòn </span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-10 m-2 m-auto">
                                            <div class="container mt-2">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <button title="Agregar" id="btnNuevo" type="button"
                                                                class="btn btn-primary" data-toggle="modal"
                                                                data-target="#agregaNota">
                                                            <i class="fas fa-plus-square"></i>
                                                            Agergar Nota de Evolución
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="table-responsive mt-2">
                                                <table id="tablaNotas"
                                                       class="table table-striped table-bordered table-condensed"
                                                       style="width:100%">
                                                    <thead class="text-center">
                                                    <tr class="badge-primary">
                                                        <th>Id</th>
                                                        <th>Descripción</th>
                                                        <th>Fecha</th>
                                                        <th>Hora</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($notas as $nota)
                                                        <tr>
                                                            <td class="text-center">{{ $nota->not_id}}</td>
                                                            <td class="text-justify">{{ $nota->not_descripcion}}</td>
                                                            <td class="text-center">{{date("d-m-Y",strtotime( $nota->not_fecha))}}</td>
                                                            <td class="text-center">{{date("H:i",strtotime( $nota->not_hora))}}</td>
                                                            <td>
                                                                <div class='text-center'>
                                                                    <div class='btn-group'>
                                                                        <button title="Editar" id="{{$nota->not_id}}"
                                                                                type="button" class="btn btn-sm btn-primary"
                                                                                data-toggle="modal"
                                                                                data-target="#editarNota_{{$nota->not_id}}">
                                                                            <i class='fas fa-pencil-alt'></i>
                                                                        </button>
                                                                        <button
                                                                            class="btn btn-danger btn-sm eliminarRegistro ml-2"
                                                                            ruta="{{url('/')}}/notas"
                                                                            action="{{url('/')}}/notas/{{$nota['not_id']}} "
                                                                            method="DELETE">
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
                                <hr/>
                                @if($especialidad->esp_id != 2)
                                <div class="row mt-2 w-90">
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
                                            <div class="row container container-fluid mb-5 caja-mediana p-4 ">
                                                <div class="row mt-5 m-0 m-auto">
                                                    <div class="col-sm-12 text-center ">
                                                        <span class="font-weight-bold"> Receta </span>
                                                    </div>
                                                </div>
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
                                            <div class="container mb-5 mt-5">
                                                <div class="row">
                                                    <div class="col-sm-1">
                                                        <button title="Modificar Receta" title="Agregar" id="btnNuevoReceta"
                                                                type="button"
                                                                class="btn btn-warning text-white">
                                                            <i class="fas fa-plus-square"></i>
                                                        </button>
                                                    </div>
                                                    <div class="col-sm-2 mt-5 mt-sm-0 ml-md-4 ml-lg-0" >
                                                        <a href="{{ url('/') }}/receta_pdf/{{$consulta->cit_id}}" title="Descargar Receta" title="Agregar" id="btnNuevoReceta"
                                                           class="btn btn-primary text-white" target="_blank">
                                                            <i class="fas fa-file-download"></i>
                                                            Descargar Receta
                                                        </a>
                                                    </div>
                                                    <div class="col-sm-2 mt-5 mt-sm-0 ml-md-4 ml-lg-0" >
                                                        <a href="{{ url('/') }}/send_pdf/{{$consulta->cit_id}}" title="Descargar Receta" title="Agregar" id="btnNuevoReceta"
                                                           class="btn btn-success text-white" target="_blank">
                                                            <i class="fas fa-envelope"></i>
                                                            Enviar Receta
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>

                                           <div class="caja-mediana">
                                            <div class="row m-0 m-auto">
                                                <div class="col-sm-12 text-center ">
                                                    <span class="font-weight-bold"> Receta </span>
                                                </div>
                                            </div>
                                            <div class="row container container-fluid mb-5 p-4" id="receta">
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
                                                        <button class="btn btn-light float-right" type="reset">
                                                            Cancelar
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                           </div>
                                        @endif
                                    </div>
                                </div>
                                @endif
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


    <!--Agregar Nota -->
    <div class="modal fade" id="agregaNota" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-mediano" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Agrega Nota
                    </h5>
                </div>
                <form action="{{url('/')}}/notas" class="bg-light "
                      method="post" novalidate name="agregaNotaForm" id="agregaNotaForm">
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
                                    <input type="hidden" name="cit_id" id="cit_id" value="{{$consulta->cit_id}}">
                                    <input type="hidden" name="pac_id" id="pac_id" value="{{$consulta->pac_id}}">
                                    <input type="hidden" name="fecha" id="fecha" value=" {{date('Y-m-d')}} ">
                                    <textarea name="descripcion" id="descripcion" cols="" rows="5"
                                              class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar </button>
                        <button type="submit" name="guardarConsulta" id="btnGuardarConsulta" class="btn btn-primary">
                            Guardar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--Editar Nota -->
    @foreach($notas as $nota)
        <div class="modal fade" id="editarNota_{{$nota->not_id}}" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-mediano" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title" id="exampleModalLabel">
                            Edita Nota
                        </h5>
                    </div>
                    <form action="{{url('/')}}/notas/{{$nota->not_id}}" class="bg-light needs-validation" method="post"
                          novalidate>
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="input-group mb-3">
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <i class="fas fa-file-medical"></i>
                                            </div>
                                        </div>
                                        <input type="hidden" name="not_id" id="not_id" value="{{$nota->not_id}}">
                                        <input type="hidden" name="cit_id" id="not_id" value="{{$consulta->cit_id}}">
                                        <input type="hidden" name="pac_id" id="not_id" value="{{$consulta->pac_id}}">
                                        <input type="hidden" name="fecha" id="fecha" value=" {{date('Y-m-d')}} ">
                                        <textarea name="descripcion" id="descripcion" rows="5"
                                                  class="form-control">{{$nota->not_descripcion}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="input-group mb-3">
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <i class="fas fa-clock"></i>
                                            </div>
                                        </div>
                                        <input class="form-control" type="time" name="hora" id="hora"
                                               value="{{date('H:i')}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-dismiss="modal"> Cancelar </button>
                            <button type="submit" name="guardarConsulta" id="btnGuardarConsulta"
                                    class="btn btn-primary">
                                Guardar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Agregar y editar Menu -->
    <div class="modal fade" id="agregaMenu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Agrega Menu
                    </h5>
                </div>
                <form action="{{url('/')}}/menu" class="bg-light "
                      method="post" novalidate name="agregaMenuForm" id="agregaMenuForm">
{{--                    @csrf--}}
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <i class="fas fa-utensils"></i>
                                        </div>
                                    </div>
                                    <select name="comida" id="comida" class="form-control" required>
                                        <option value="0"> -- Seleccione --</option>
                                        <option value="1"> Ayunas </option>
                                        <option value="2"> Desayuno  </option>
                                        <option value="3"> Colación  </option>
                                        <option value="4"> Comida  </option>
                                        <option value="5"> Cena  </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6" id="div-dia">
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <i class="fas fa-calendar-day"></i>
                                        </div>
                                    </div>
                                    <input type="hidden" name="men_id" id="men_id">
                                    <select name="dia" id="dia" class="form-control" required>
                                        <option value="0"> --Seleccion Día-- </option>
                                        <option value="1"> Día 1 </option>
                                        <option value="2"> Día 2 </option>
                                        <option value="3"> Día 3 </option>|
                                        <option value="4"> Día 4 </option>
                                        <option value="5"> Día 5 </option>
                                        <option value="6"> Día 6 </option>
                                        <option value="7"> Día 7 </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                    <input type="hidden" name="cit_id" id="citId" value="{{$consulta->cit_id}}">
                                    <input type="hidden" name="pac_id" id="pac_id" value="{{$consulta->pac_id}}">
                                    <input type="hidden" name="fecha_menu" id="fechaMenu" value="{{$consulta->cit_fecha}}"/>
                                    <textarea  name="descripcion" id="descripcionMenu" cols="" rows="5" class="form-control"></textarea>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="cancelar-menu" class="btn btn-light" data-dismiss="modal">Cancelar </button>
                        <button type="submit" name="guardarMenu" id="btnGuardarMenu" class="btn btn-primary">
                            Guardar
                        </button>
{{--                        @csrf--}}
                    </div>
                </form>
            </div>
        </div>
    </div>


    @if (Session::has("ok-crear-fisico"))

        <script>
            notie.alert({type: 1, text: '¡La exàmen físico ha sido creada correctamente!', time: 10})
        </script>

    @endif

    @if (Session::has("ok-crear-menu"))

        <script>
            notie.alert({type: 1, text: '¡La menu ha sido creada correctamente!', time: 10})
        </script>

    @endif


    @if (Session::has("no-crear-menu"))

        <script>
            notie.alert({type: 3, text: '¡Error al actualizar el registro!', time: 10})
        </script>

    @endif

    @if (Session::has("ok-crear-nota"))

        <script>
            notie.alert({type: 1, text: '¡La nota ha sido creada correctamente!', time: 10})
        </script>

    @endif

    @if (Session::has("ok-editar-nota"))

        <script>
            notie.alert({type: 1, text: '¡La nota ha sido actualizada correctamente!', time: 10})
        </script>

    @endif

    @if (Session::has("ok-crear-receta"))

        <script>
            notie.alert({type: 1, text: '¡La receta ha sido creada correctamente!', time: 2})
        </script>

    @endif

    @if ($errors->any())
        <script>
            // $("#editarPaciente").modal()
            notie.alert({type: 3, text: '¡Error al actualizar el Registro !', time: 10})
        </script>
    @endif

@endsection('content')
