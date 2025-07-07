<?php
    use App\Http\Controllers\HistoriaClinicaPreguntasController;

?>

@extends('plantilla')
@section('content')

<div class="content-wrapper" style="min-height: 247px;">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Preguntas</h1>
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
             <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#crearPregunta">
             Crea Nueva Pregunta
             </button>
            </div>
  <div class="card-body">
    <div class="row">
      <div class="col-lg-12">
        <div class="table-responsive fuenteTabla">
          <table id="tablaPacientes" class="table table-striped table-bordered table-condensed table-re" style="width:100%" >
            <thead class="text-center">
              <tr class="badge-primary">
{{--                <th>Id Sección</th>--}}
                <th>Orden</th>
                  <th>Tipo</th>
                <th>Descripción</th>
                <th>Subseccion</th>
                <th>Estado</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
               @forelse($preguntas as $pregunta)
                <tr>
                  <td class="text-center"> {{$pregunta->orden}} </td>
                  <td class="text-center"> {{$pregunta->tipo}} </td>
                  <td class="text-left"> {{$pregunta->descripcion}} </td>
                  <td class="text-left"> {{HistoriaClinicaPreguntasController::showSubseccion($pregunta->id_subseccion)->nombre}} </td>
                  <td class="text-center estado" id="estado_{{$pregunta->id}}"> {{ HistoriaClinicaPreguntasController::estadoString($pregunta->estado)}} </td>
                  <td>
                    <div class='text-center'>
                      <div class='btn-group'>
                          @if($pregunta->estado == 1)
                              <button fila = "{{$pregunta->id}}"  title="Editar" id="editar_{{$pregunta['_id']}}" type="button"
                                       class="ml-2 btn btn-sm btn-primary editarSeccion"
                                       data-toggle="modal" data-target="#editarPregunta_{{$pregunta->id}}">
                                  <i class='fas fa-pencil-alt'></i>
                              </button>
                              <button fila='{{$pregunta->id}}' title="Habilitar"
                                      class="btn btn-success btn-sm habilitarRegistro ml-2"
                                      ruta="{{url('/')}}/preguntas-habilitar"
                                      action="{{url('/')}}/preguntas-habilita/{{$pregunta->id}} "
                                      method="PUT" pagina="administradores" id="habilitar_{{$pregunta['id']}}" disabled>
                                  @csrf
                                  <i class="fas fa-check-circle"></i>
                              </button>
                              <button fila='{{$pregunta['id']}}' title="Deshabilitar"
                                      class="btn btn-warning btn-sm deshabilitarRegistro ml-2"
                                      ruta="{{url('/')}}/preguntas-deshabilitar"
                                      action="{{url('/')}}/preguntas-deshabilitar/{{$pregunta->id}} "
                                      method="PUT" pagina="administradores" id="deshabilitar_{{$pregunta['id']}}">
                                  @csrf
                                  <i class="fas fa-times-circle"></i>
                              </button>
                          @elseif($pregunta->estado ==2)
                              <button fila = "{{$pregunta->id}}"  title="Editar" id="editar_{{$pregunta['id']}}" type="button"
                                       class="ml-2 btn btn-sm btn-primary editarSeccion"
                                       data-toggle="modal" data-target="#editarPregunta_{{$pregunta->id}}" disabled>
                                  <i class='fas fa-pencil-alt'></i>
                              </button>
                              <button fila='{{$pregunta->id}}' title="Habilitar"
                                               class="btn btn-success btn-sm habilitarRegistro ml-2"
                                               ruta="{{url('/')}}/preguntas-habilitar"
                                               action="{{url('/')}}/preguntas-habilitar/{{$pregunta->id}} "
                                               method="PUT" pagina="administradores" id="habilitar_{{$pregunta['id']}}" >
                                  @csrf
                                  <i class="fas fa-check-circle"></i>
                              </button>
                              <button fila='{{$pregunta['id']}}' title="Deshabilitar"
                                      class="btn btn-warning btn-sm deshabilitarRegistro ml-2"
                                      ruta="{{url('/')}}/preguntas-deshabilitar"
                                      action="{{url('/')}}/preguntas-deshabilitar/{{$pregunta->id}} "
                                      method="PUT" pagina="administradores" id="deshabilitar_{{$pregunta['id']}}" disabled>
                                  @csrf
                                  <i class="fas fa-times-circle"></i>
                              </button>
                          @endif

                          <button class="btn btn-danger btn-sm eliminarRegistro ml-2" ruta="{{url('/')}}/preguntas"
                                  action="{{url('/')}}/preguntas/{{$pregunta->id}} "
                                  method="DELETE" pagina="administradores" >
                              @csrf
                              <i class="fas fa-trash-alt"></i>
                          </button>
                      </div>
                    </div>
                  </td>
                  @empty
                  <td class="text-center" colspan="11">No existen Preguntas
                  </td>
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
Editar Pregunta
======================================-->
@forelse($preguntas as $pregunta)
<div class="modal fade" id="editarPregunta_{{$pregunta->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="exampleModalLabel">
                    <h4>Editar Pregunta </h4>
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{url('/')}}/preguntas/{{$pregunta->id}}" class="bg-light needs-validation" method="post" novalidate>
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="input-group mb-3 form-group">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <i class="fas fa-notes-medical"></i>
                                    </div>
                                </div>
                                <input class="form-control" type="number" name="orden" id="orden" placeholder="Orden" value="{{$pregunta->orden}}">
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-sm-12">
                            <div class="input-group mb-3 form-group">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <i class="fas fa-notes-medical"></i>
                                    </div>
                                </div>
                                <select class="form-control" name="id_tipo" id="id_tipo" required>
                                    <option value="">-- Tipo--</option>
                                    <option value="1" {{ ($pregunta->tipo == 1) ? 'selected' : '' }} >Abierta</option>
                                    <option value="2" {{ ($pregunta->tipo == 2) ? 'selected' : '' }}  >Seleccion Mñultiple</option>
                                    <option value="3" {{ ($pregunta->tipo == 3) ? 'selected' : '' }}  >Seleccion Sencilla</option>
                                </select>
                                <span class="invalid-feedback" role="alert">
                                         {{$errors->first('id_tipo')}}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-sm-12">
                            <div class="input-group mb-3 form-group">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <i class="fas fa-notes-medical"></i>
                                    </div>
                                </div>
                                <select class="form-control" name="id_subseccion" id="id_subseccion" required>
                                    <option value="">--Seleccione Subsección--</option>
                                    @foreach($subsecciones as $subseccion)
                                        <option value="{{$subseccion->id}}"
                                        {{ ($subseccion->id == $pregunta->id_subseccion) ? "selected" : ''}}
                                        > {{$subseccion->nombre }}</option>
                                    @endforeach
                                </select>
                                <span class="invalid-feedback" role="alert">
                                         {{$errors->first('id_seccion')}}
                                    </span>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-sm-12">
                            <div class="input-group mb-3 form-group">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <i class="fas fa-notes-medical"></i>
                                    </div>
                                </div>
                                <input id="descripcion" type="text" class="form-control descripcion @error('descripcion')
                      is-invalid @enderror" name="descripcion" value="{{$pregunta->descripcion}}"
                                       autocomplete="off" placeholder="Descripción" >
                                <span class="invalid-feedback" role="alert">
                        {{$errors->first('descripcion')}}
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


<!--=====================================
Agregar Pregunta
======================================-->

<div class="modal fade" id="crearPregunta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="exampleModalLabel">
                    <h4>Agregar Pregunta </h4>
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{url('/')}}/preguntas" class="bg-light needs-validation" method="post" novalidate>
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="input-group mb-3 form-group">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <i class="fas fa-notes-medical"></i>
                                    </div>
                                </div>
                                <input class="form-control" type="number" name="orden" id="orden" placeholder="Orden" value="0">
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-sm-12">
                            <div class="input-group mb-3 form-group">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <i class="fas fa-notes-medical"></i>
                                    </div>
                                </div>
                                <select class="form-control" name="id_tipo" id="id_tipo" required>
                                    <option value="">--Seleccione Tipo--</option>
                                    <option value="1">Abierta</option>
                                    <option value="2">Seleccion Multiple</option>
                                    <option value="3">Seleccion Sencilla</option>
                                </select>
                                <span class="invalid-feedback" role="alert">
                                         {{$errors->first('id_tipo')}}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-sm-12">
                            <div class="input-group mb-3 form-group">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <i class="fas fa-notes-medical"></i>
                                    </div>
                                </div>
                                <select class="form-control" name="id_subseccion" id="id_subseccion" required>
                                    <option value="">--Seleccione Subsección--</option>
                                  @foreach($subsecciones as $subseccion)
                                        <option value="{{$subseccion->id}}"> {{$subseccion->nombre }}</option>
                                    @endforeach
                                </select>
                                <span class="invalid-feedback" role="alert">
                                         {{$errors->first('id_seccion')}}
                                    </span>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-sm-12">
                            <div class="input-group mb-3 form-group">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <i class="fas fa-notes-medical"></i>
                                    </div>
                                </div>
                                <input id="descripcion" type="text" class="form-control descripcion @error('descripcion')
                      is-invalid @enderror" name="descripcion" value="{{old('descripcion')}}"
                                       autocomplete="off" placeholder="Descripción" >
                                <span class="invalid-feedback" role="alert">
                        {{$errors->first('descripcion')}}
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


{{--Editar Baner--}}

  <script>
 // $("#crearPaciente").modal()
  </script>




@if (Session::has("ok-crear"))

  <script>
      notie.alert({ type: 1, text: '¡La pregunta ha sido creada correctamente!', time: 10 })
 </script>

@endif

@if (Session::has("ok-editar"))
    <script>
        notie.alert({ type: 1, text: '¡La pregunta ha sido actualizada correctamente!', time: 10 })
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
    notie.alert({ type: 3, text: '¡Error al actualizar la pregunta!', time: 10 });
    </script>
@endif

@endsection('content')
