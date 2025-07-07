<?php
    use App\Http\Controllers\HistoriaClinicaSubSeccionesController;
?>

@extends('plantilla')
@section('content')

<div class="content-wrapper" style="min-height: 247px;">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Secciones</h1>
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
             <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#crearSeccion">
             Crea Nueva Sección
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
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Estado</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
               @forelse($secciones as $seccion)
                <tr>
                  <td class="text-center"> {{$seccion['orden']}} </td>
                  <td class="text-left"> {{$seccion['nombre']}} </td>
                  <td class="text-left"> {{$seccion['descripcion']}} </td>
                  <td class="text-left estado" id="estado_{{$seccion['id']}}"> {{HistoriaClinicaSubSeccionesController::estadoString($seccion->estado)}} </td>
                  <td>
                    <div class='text-center'>
                      <div class='btn-group'>
                          @if($seccion->estado == 1)
                              <button  title="Editar" id="editar_{{$seccion['id']}}" type="button"
                                       class="ml-2 btn btn-sm btn-primary editarSeccion editar"
                                       data-toggle="modal" data-target="#editarSeccion_{{$seccion->id}}">
                                  <i class='fas fa-pencil-alt'></i>
                              </button>
                              <button fila ='{{$seccion->id}}' title="Habilitar" class="btn btn-success btn-sm habilitarRegistro ml-2" ruta="{{url('/')}}/secciones-habilitar"
                                      action="{{url('/')}}/secciones-habilitar/{{$seccion->id}} "
                                      method="PUT" pagina="administradores"  id="habilitar_{{$seccion['id']}}" disabled>
                                  @csrf
                                  <i class="fas fa-check-circle"></i>
                              </button>
                              <button fila ='{{$seccion['id']}}' title="Deshabilitar" class="btn btn-warning btn-sm deshabilitarRegistro ml-2" ruta="{{url('/')}}/secciones-deshabilitar"
                                      action="{{url('/')}}/secciones-deshabilitar/{{$seccion->id}} "
                                      method="PUT" pagina="administradores" id="deshabilitar_{{$seccion['id']}}">
                                  @csrf
                                  <i class="fas fa-times-circle"></i>
                              </button>
                          @elseif($seccion->estado == 2)
                              <button  title="Editar" id="editar_{{$seccion['id']}}" type="button"
                                       class="ml-2 btn btn-sm btn-primary editarSeccion editar"
                                       data-toggle="modal" data-target="#editarSeccion_{{$seccion->id}}" disabled>
                                  <i class='fas fa-pencil-alt'></i>
                              </button>
                              <button fila ='{{$seccion->id}}' title="Habilitar" class="btn btn-primary btn-sm habilitarRegistro ml-2" ruta="{{url('/')}}/secciones-habilitar"
                                      action="{{url('/')}}/secciones-habilitar/{{$seccion->id}} "
                                      method="PUT" pagina="administradores"  id="habilitar_{{$seccion['id']}}" >
                                  @csrf
                                  <i class="fas fa-check-circle"></i>
                              </button>
                              <button fila ='{{$seccion['id']}}' title="Deshabilitar" class="btn btn-warning btn-sm deshabilitarRegistro ml-2" ruta="{{url('/')}}/secciones-deshabilitar"
                                      action="{{url('/')}}/secciones-deshabilitar/{{$seccion->id}} "
                                      method="PUT" pagina="administradores" id="deshabilitar_{{$seccion['id']}}" disabled>
                                  @csrf
                                  <i class="fas fa-times-circle"></i>
                              </button>
                          @endif
                          <button title="Eliminar" class="btn btn-danger btn-sm eliminarRegistro ml-2" ruta="{{url('/')}}/secciones"
                                  action="{{url('/')}}/secciones/{{$seccion->id}} "
                                  method="DELETE" pagina="administradores" >
                              @csrf
                              <i class="fas fa-trash-alt"></i>
                          </button>

                      </div>
                    </div>
                  </td>
                  @empty
                  <td class="text-center" colspan="11">No existen Secciones
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
Editar Sección
======================================-->
@forelse($secciones as $seccion)
<div class="modal fade" id="editarSeccion_{{$seccion->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="exampleModalLabel">
                  <h4>Editar Sección </h4>
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
            </div>
          <form action="{{url('/')}}/secciones/{{$seccion->id}}" class="bg-light needs-validation" method="post" novalidate>
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
                            <input class="form-control" type="text" name="orden" id="orden" value="{{$seccion->orden}}">
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                  <div class="col-md-12">
                    <div class="input-group mb-3 form-group">
                      <div class="input-group-append">
                        <div class="input-group-text">
                            <i class="fas fa-notes-medical"></i>
                        </div>
                      </div>
                      <input id="nombre" type="text" class="form-control nombre @error('nombre')
                      is-invalid @enderror" name="nombre" value="{{ $seccion->nombre  }}"
                             autocomplete="nombre" placeholder="Nombre">
                        <span class="invalid-feedback" role="alert">
                        {{$errors->first('nombre')}}
                        </span>
                  </div>
                </div>
                </div>
                <div class="row mt-3">
                  <div class="col-md-12">
                    <div class="input-group mb-3 form-group">
                      <div class="input-group-append">
                        <div class="input-group-text">
                            <i class="fas fa-notes-medical"></i>
                        </div>
                      </div>
                        <textarea class="form-control" name="descripcion" id="descripcion" >{{$seccion->descripcion}} </textarea>
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
Agregar Secciòn
======================================-->

<div class="modal fade" id="crearSeccion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog"  role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="exampleModalLabel">
                    <h4>Agregar Sección </h4>
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{url('/')}}/secciones" class="bg-light needs-validation" method="post" novalidate>
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
                                <input type="hidden" name="es_cita" id="es_cita" value="0">
                                <input id="nombre" type="text" class="form-control nombre @error('nombre')
                      is-invalid @enderror" name="nombre" value="{{old('nombre')}}"
                                       autocomplete="nombre" placeholder="Nombre">
                                <span class="invalid-feedback" role="alert">
                        {{$errors->first('nombre')}}
                        </span>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="input-group mb-3 form-group">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <i class="fas fa-notes-medical"></i>
                                    </div>
                                </div>
                                <textarea class="form-control" name="descripcion" id="descripcion" placeholder="Descripción"></textarea>
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




@if (Session::has("ok-crear-seccion"))

  <script>
      notie.alert({ type: 1, text: '¡La sección ha sido creado correctamente!', time: 10 })
 </script>

@endif

@if (Session::has("ok-editar-seccion"))
    <script>
        notie.alert({ type: 1, text: '¡La seccón ha sido actualizado correctamente!', time: 10 })
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
