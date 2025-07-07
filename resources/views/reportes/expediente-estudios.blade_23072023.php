@extends('plantilla')
@section('content')

    <?php
        use App\Http\Controllers\PacienteController;
        $pac = new PacienteController();
    ?>

    <div class="content-wrapper" style="min-height: 247px;">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Expediente Estudios</h1>
                    </div>
                </div>

                <a  href="{{ url('/') }}/expediente-estudios/{{$paciente->pac_id}}" class="btn btn-primary btn-sm mt-4" >
                    <i class="fas fa-file-medical"></i> <span>Estudios</span>
                </a>

                <a  href="{{ url('/') }}/expediente-fisico/{{$paciente->pac_id}}" class="btn btn-primary btn-sm mt-4" >
                    <i class="fas fa-file-medical"></i> <span>Exámen Físico</span>
                </a>

                <a  href="{{ url('/') }}/expediente-historia/{{$paciente->pac_id}}" class="btn btn-primary btn-sm mt-4" >
                    <i class="fas fa-file-medical"></i> <span>Historia Clínica</span>
                </a>

                <a  href="{{ url('/') }}/expediente-notas/{{$paciente->pac_id}}" class="btn btn-primary btn-sm mt-4" >
                    <i class="fas fa-file-medical"></i> <span>Notas de Evolución </span>
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
                                            {{ $paciente ->pac_nombre}}
                                            {{ $paciente ->pac_paterno}}
                                            {{ $paciente ->pac_materno}}
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
                                            <span class="font-weight-bold">Edad</span>
                                            {{$paciente->pac_nacimiento  }}
                                        </h6>

                                    </div>
                                </div>

                            </div>
                            <div class="card-body">
                                <div class="row mt-5">
                                    <div class="col-sm-12 text-center">
                                        <span class="font-weight-bold"> Estudios </span>
                                    </div>
                                </div>
                                    <div class="row">
                                        <div class="col-sm-11 m-2 m-auto">
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
            // notie.alert({type: 3, text: '¡Error al actualizar el Registro !', time: 10});
        </script>
    @endif

@endsection('content')
