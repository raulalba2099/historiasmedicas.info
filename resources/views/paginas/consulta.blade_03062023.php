
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
                <a  href="{{ url('/') }}/historia/{{$consulta->cit_id}}" class="btn btn-primary btn-sm mt-4" >
                    <i class="fas fa-file-medical"></i> <span>Historia Clínica</span>

                </a>
                <a  href="{{ url('/') }}/consulta/{{$consulta->cit_id}}" class="btn btn-primary btn-sm mt-4" >
                    <i class="fas fa-file-medical"></i> <span>Consulta</span>
                </a>
                <a  href="{{ url('/') }}/receta/{{$consulta->cit_id}}" class="btn btn-primary btn-sm mt-4" >
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

                                            {{ $paciente::age($consulta->pac_nacimiento) . ' ' . 'años'  }}

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
                                                        Frecuencia Cardiaca
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-append">
                                                                <div class="input-group-text">
                                                                    <i class="fas fa-heartbeat"></i>
                                                                </div>
                                                            </div>
                                                            <input type="hidden" name="cit_fecha" id="cit_fecha" value="{{$consulta->cit_fecha}}">
                                                            <input type="hidden" name="cit_id" id="ci_id" value="{{$consulta->cit_id}}">
                                                            <input type="hidden" name="pac_id" id="pac_id"
                                                                   value="{{$consulta->pac_id}}">
                                                            <input class="form-control text-right" type="text" name="cardiaca" id="cit_id"
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
                                                            <input class="form-control text-right" type="text" name="respiratoria" id="cit_id"
                                                                   value="{{ (!empty($fisico) ? $fisico->frecuencia_respiratoria : '' )  }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        Presión Arterial
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-append">
                                                                <div class="input-group-text">
                                                                    <i class="fas fa-heartbeat"></i>
                                                                </div>
                                                            </div>
                                                            <input class="form-control text-right" type="text" name="arterial" id="cit_id"
                                                                   value="{{!empty($fisico) ? $fisico->presion_arterial : '' }}">
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
                                                            <input class="form-control text-right" type="text" name="temperatura" id="cit_id"
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
                                                            <input class="form-control text-right" type="text" name="peso" id="cit_id"
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
                                                            <input class="form-control text-right" type="text" name="talla" id="cit_id"
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
                                                            <input class="form-control text-right" type="text" name="imc" id="cit_id"
                                                                   value="{{!empty($fisico) ? $fisico->imc : '' }}">
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
                                                            <input class="form-control" type="text" name="diagnostico" id="cit_id"
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
                                                            class="btn btn-primary" data-toggle="modal" data-target="#agregaNota">
                                                        <i class="fas fa-plus-square"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="table-responsive mt-2">
                                            <table id="tablaNotas" class="table table-striped table-bordered table-condensed" style="width:100%" >
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
                                                      <td  class="text-center">{{ $nota->not_id}}</td>
                                                      <td>{{ $nota->not_descripcion}}</td>
                                                      <td class="text-center">{{date("d-m-Y",strtotime( $nota->not_fecha))}}</td>
                                                      <td class="text-center">{{date("H:i",strtotime( $nota->not_hora))}}</td>
                                                      <td>
                                                          <div class='text-center'>
                                                              <div class='btn-group'>
                                                                  <button  title="Editar" id="{{$nota->not_id}}"
                                                                           type="button" class="btn btn-sm btn-primary"
                                                                           data-toggle="modal" data-target="#editarNota_{{$nota->not_id}}">
                                                                      <i class='fas fa-pencil-alt'></i>
                                                                  </button>
                                                                  <button class="btn btn-danger btn-sm eliminarRegistro ml-2"
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
     <div class="modal fade" id="agregaNota" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog modal-mediano"  role="document">
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
                                         <textarea name="descripcion" id="descripcion" cols="" rows="5" class="form-control"></textarea>
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

    <!--Editar Nota -->
    @foreach($notas as $nota)
    <div class="modal fade" id="editarNota_{{$nota->not_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-mediano"  role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Edita Nota
                    </h5>
                </div>
                <form action="{{url('/')}}/notas/{{$nota->not_id}}" class="bg-light needs-validation" method="post" novalidate>
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
                                    <textarea name="descripcion" id="descripcion"  rows="5" class="form-control">{{$nota->not_descripcion}}</textarea>
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
                                    <input class="form-control" type="time" name="hora" id="hora" value="{{date('H:i')}}">
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
    @endforeach

    @if (Session::has("ok-crear-fisico"))

        <script>
            notie.alert({ type: 1, text: '¡La exàmen físico ha sido creada correctamente!', time: 10 })
        </script>

    @endif

    @if (Session::has("ok-crear-nota"))

        <script>
            notie.alert({ type: 1, text: '¡La nota ha sido creada correctamente!', time: 10 })
        </script>

    @endif

    @if (Session::has("ok-editar-nota"))

        <script>
            notie.alert({ type: 1, text: '¡La nota ha sido actualizada correctamente!', time: 10 })
        </script>

    @endif

    @if ($errors->any())
        <script>
            // $("#editarPaciente").modal()
            notie.alert({ type: 3, text: '¡Error al actualizar el Registro !', time: 10 })
        </script>
    @endif

@endsection('content')
