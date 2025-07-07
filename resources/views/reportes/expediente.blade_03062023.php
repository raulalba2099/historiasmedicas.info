@extends('plantilla')
@section('content')
    <div class="content-wrapper" style="min-height: 247px;">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-2">
                        <h1>Expediente</h1>
                    </div>
                </div>

{{--                <a  href="{{ url('/') }}/expediente-estudios/{{$paciente->pac_id}}" class="btn btn-primary btn-sm mt-4" >--}}
{{--                    <i class="fas fa-file-medical"></i> <span>Estudios</span>--}}
{{--                </a>--}}

{{--                <a  href="{{ url('/') }}/expediente-historia/{{$paciente->pac_id}}" class="btn btn-primary btn-sm mt-4" >--}}
{{--                    <i class="fas fa-file-medical"></i> <span>Historia Clínica</span>--}}
{{--                </a>--}}

{{--                <a  href="{{ url('/') }}/expediente-notas/{{$paciente->pac_id}}" class="btn btn-primary btn-sm mt-4" >--}}
{{--                    <i class="fas fa-file-medical"></i> <span>Notas de Evolución</span>--}}
{{--                </a>--}}

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

                                    </div>
                                    <div class="col-sm-6">
                                        <h6 class="float-right">
                                            <span class="font-weight-bold">Fecha de Hoy:</span>
                                            {{ date('d-M-Y') }}
                                        </h6>
                                    </div>
                                </div>

                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="table-responsive fuenteTabla">
                                            <table id="tablaPacientes" class="table   table-condensed" style="width:100%" >
                                                <thead class="text-center">
                                                <tr class="badge-primary">
                                                    <th>Id Paciente</th>
                                                    <th>Número</th>
                                                    <th>Nombre</th>
                                                    <th>Apellido Paterno</th>
                                                    <th>Apellido Materno</th>
                                                    <th>Fecha Nacimiento</th>
                                                    <th>Edad</th>
                                                    <th>Género</th>
                                                    <th>Dirección</th>
                                                    <th>Teléfono</th>
                                                    <th>Correo</th>
                                                    <th>Acciones</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @forelse($pacientes as $paciente)
                                                    <tr>
                                                        <td class="text-center"> {{$paciente['pac_id']}} </td>
                                                        <td class="text-center"> {{$paciente['pac_numero']}} </td>
                                                        <td> {{$paciente['pac_nombre']}} </td>
                                                        <td> {{$paciente['pac_paterno']}} </td>
                                                        <td> {{$paciente['pac_materno']}} </td>
                                                        <td class="text-center"> {{ date('d-m-Y',strtotime($paciente['pac_nacimiento'])) }} </td>
                                                        <td class="text-center"> {{ $paciente['pac_edad'] }} </td>
                                                        <td class="text-center"> {{$paciente['pac_genero']}} </td>
                                                        <td> {{$paciente['pac_direccion']}} </td>
                                                        <td> {{$paciente['pac_telefono']}} </td>
                                                        <td> {{$paciente['pac_correo']}} </td>
                                                        <td>
                                                            <div class='text-center'>
                                                                <div class='btn-group'>
                                                                    <a href="{{url('/')}}/expediente-estudios/{{$paciente['pac_id']}}"
                                                                       title="Expediente" id="{{$paciente['pac_id']}}" type="button"
                                                                       class="btn btn-sm btn-primary editarPaciente">
                                                                        <i class="fas fa-folder-plus"></i>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        @empty
                                                            <td class="text-center" colspan="11">No existen Pacientes</td>
                                                    </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div>
                                    <!-- /.card-body -->
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
