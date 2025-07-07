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
                        <h1>Estudios</h1>
                    </div>
                </div>

                <a href="{{ url('/') }}/consulta/{{$consulta[0]->cit_id}}" class="btn btn-primary btn-sm mt-4">
                    <i class="fas fa-file-medical"></i> <span>Consulta</span>
                </a>
{{--                <a href="{{ url('/') }}/receta/{{$consulta[0]->cit_id}}" class="btn btn-primary btn-sm mt-4">--}}
{{--                    <i class="fas fa-file-medical"></i> <span>Receta</span>--}}

{{--                </a>--}}

                <a href="{{ url('/') }}/estudios/{{$consulta[0]->cit_id}}" class="btn btn-primary btn-sm mt-4">
                    <i class="fas fa-file-medical"></i> <span>Estudios</span>
                </a>
                @if($especialidad->esp_id == 1)
                <a href="{{ url('/') }}/historia/{{$consulta[0]->cit_id}}" class="btn btn-primary btn-sm mt-4">
                    <i class="fas fa-file-medical"></i> <span>Historia Clínica</span>

                </a>
                @endif
                @if($especialidad->esp_id == 2)
                    <a href="{{ url('/') }}/menu/{{$consulta[0]->cit_id}}}" class="btn btn-primary btn-sm mt-4">
                        <i class="fas fa-file-medical"></i> <span>Menu</span>
                    </a>
                @endif

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
                                            {{ $consulta[0]->pac_nombre}}
                                            {{ $consulta[0]->pac_paterno}}
                                            {{ $consulta[0]->pac_materno}}
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
                                            {{ $consulta[0]->pac_nacimiento  }}
                                        </h6>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <h6>
                                            <span class="font-weight-bold">Fecha y hora de cita:</span>
                                            {{ date('d-M-Y', strtotime($consulta[0]->cit_fecha))  }}
                                        </h6>
                                    </div>
                                </div>
                            </div>
                            <div class="card body mt-2">
                                <div class="row">
                                    <div class="col-sm-12 text-center">
                                        <span class="font-weight-bold"> Estudios </span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-10 m-2 m-auto">
                                        <div class="container mt-2">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <button title="Agregar" id="btnNuevo" type="button"
                                                            class="btn btn-primary" data-toggle="modal"
                                                            data-target="#agregaEstudio">
                                                        <i class="fas fa-plus-square"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="table-responsive mt-2">
                                            <table id="tablaEstudios"
                                                   class="table table-striped table-bordered table-condensed"
                                                   style="width:100%">
                                                <thead class="text-center">
                                                <tr class="badge-primary">
                                                    <th>#</th>
                                                    <th>Nombre</th>
                                                    <th>Observaciones</th>
                                                    <th>Fecha</th>
                                                    <th>Archivo</th>
                                                    <th>Acciones</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @forelse($estudios as $key => $estudio)

                                                    <tr>
{{--                                                        <td class="text-center">{{$key + 1}}</td>--}}
                                                        <td class="text-center">{{$estudio->est_id}}</td>
                                                        <td>{{ $estudio->est_nombre}}</td>
                                                        <td>{{ $estudio->est_observaciones}}</td>
                                                        <td>{{ date('d-M-Y', strtotime(now())) }}</td>
                                                        <td class="text-center">
                                                            @if($estudio->est_archivo != '')
                                                                <a title="Descargar" href="{{ url('/') }}/estudios_descargar/{{$estudio->est_id}}"
                                                                   class="">
                                                                      <i class="fas fa-solid fa-download"></i>

                                                                </a>
                                                            @else
                                                                <span>Sin Asignar</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <div class='text-center'>
                                                                <div class='btn-group'>
                                                                    <button title="Editar" id="{{$estudio->est_id}}"
                                                                            type="button" class="btn btn-sm btn-primary"
                                                                            data-toggle="modal"
                                                                            data-target="#editarEstudio_{{$estudio->est_id}}">
                                                                        <i class='fas fa-pencil-alt'></i>
                                                                    </button>
                                                                    <button
                                                                        title="Eliminar"
                                                                        class="btn btn-danger btn-sm eliminarRegistro ml-2"
                                                                        ruta="{{url('/')}}/estudios"
                                                                        action="{{url('/')}}/estudios/{{$estudio->est_id}} "
                                                                        method="DELETE">
                                                                        @csrf
                                                                        <i class="fas fa-trash-alt"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        @empty
                                                            <td class="text-center" colspan="11">No existen estudios
                                                                para este paciente
                                                            </td>
                                                    </tr>
                                                      @endif
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


    <!--Agregar Estudio -->
    <div class="modal fade" id="agregaEstudio" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-mediano" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Agrega Estudio
                    </h5>
                </div>
                <form action="{{url('/')}}/estudios" class="bg-light "
                      method="post" novalidate name="agregaEstudioForm" id="agregaEstudioForm" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <i class="fas fa-calendar-alt"></i>
                                        </div>
                                    </div>
                                    <input type="hidden" name="cit_id" id="cit_id" value="{{$consulta[0]->cit_id}}">
                                    <input type="hidden" name="pac_id" id="pac_id" value="{{$consulta[0]->pac_id}}">
                                    <input class="form-control" type="date" name="est_fecha" id="est_fecha"
                                           value="{{date('Y-m-d',strtotime(now()))}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <i class="fas fa-file-medical-alt"></i>
                                        </div>
                                    </div>
                                    <input class="form-control" type="text" name="est_nombre" id="est_nombre"
                                           placeholder="Nombre del estudio">
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
                                    <textarea name="est_observaciones" id="est_observaciones" cols="" rows="5"
                                              class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="input-group mb-3">
                                    <input class="" type="file" name="est_archivo" id="est_archivo"
                                           placeholder="Nombre del estudio">
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

    @foreach($estudios as $estudio)
    <!--Editar Estudio -->
    <div class="modal fade" id="editarEstudio_{{$estudio->est_id}}" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-mediano" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Edita Estudio
                    </h5>
                </div>
                <form action="{{url('/')}}/estudios/{{$consulta[0]->cit_id}}" class="bg-light "
                      method="post" novalidate name="editarEstudioForm" id="editarEstudioForm"
                      enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <i class="fas fa-calendar-alt"></i>
                                        </div>
                                    </div>
                                    <input type="hidden" name="est_id" id="cit_id" value="{{$consulta[0]->cit_id}}">
                                    <input type="hidden" name="pac_id" id="pac_id" value="{{$consulta[0]->pac_id}}">
                                    <input type="hidden" name="est_id" id="est_id" value="{{$estudio->est_id}}">
                                    <input class="form-control" type="date" name="est_fecha" id="est_fecha"
                                           value="{{date('Y-m-d', strtotime($estudio->est_fecha))}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <i class="fas fa-file-medical-alt"></i>
                                        </div>
                                    </div>
                                    <input class="form-control" type="text" name="est_nombre" id="est_nombre"
                                           placeholder="Nombre del estudio" value="{{$estudio->est_nombre}}">
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
                                    <textarea name="est_observaciones" id="est_observaciones" cols="" rows="5" class="form-control">{{$estudio->est_observaciones}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="input-group mb-3">
                                    <input class="" type="file" name="est_archivo" id="est_archivo"
                                           placeholder="">
                                    <input type="hidden" name="est_archivo_actual" id="est_archivo_actual"
                                           value="{{$estudio->est_archivo}}">
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

    @if (Session::has("ok-crear"))

        <script>
            notie.alert({type: 1, text: '¡El estudio ha sido creado correctamente!', time: 10})
        </script>

    @endif

    @if (Session::has("error-extension"))

        <script>
            notie.alert({type: 3, text: '¡Tipo de Archivo no Valido!', time: 5})
        </script>

    @endif

    @if (Session::has("error-tamanio"))

        <script>
            notie.alert({type: 3, text: '¡Tamaño de Archivo no Valido!', time: 10})
        </script>

    @endif

    @if (Session::has("ok-editar"))

        <script>
            notie.alert({type: 1, text: '¡El estudio ha sido actualizada correctamente!', time: 10})
        </script>

    @endif

    @if ($errors->any())
        <script>
            // $("#editarPaciente").modal()
            notie.alert({type: 3, text: '¡Error al actualizar el Registro !', time: 10})
        </script>
    @endif

@endsection('content')
