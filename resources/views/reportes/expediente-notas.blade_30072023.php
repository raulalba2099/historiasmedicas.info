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
                        <h1> Expediente Notas de Evolución</h1>
                    </div>
                </div>

                <a  href="{{ url('/') }}/expediente-estudios/{{$paciente->pac_id}}" class="btn btn-primary btn-sm mt-4" >
                    <i class="fas fa-file-medical"></i> <span>Estudios</span>
                </a>

                <a  href="{{ url('/') }}/expediente-fisico/{{$paciente->pac_id}}" class="btn btn-primary btn-sm mt-4" >
                    <i class="fas fa-file-medical"></i> <span>Exámen Físico</span>
                </a>
                @if(auth()->user()->esp_id == 1)
                <a  href="{{ url('/') }}/expediente-historia/{{$paciente->pac_id}}" class="btn btn-primary btn-sm mt-4" >
                    <i class="fas fa-file-medical"></i> <span>Historia Clínica</span>
                </a>
                @endif

                <a  href="{{ url('/') }}/expediente-notas/{{$paciente->pac_id}}" class="btn btn-primary btn-sm mt-4" >
                    <i class="fas fa-file-medical"></i> <span>Notas de Evolución</span>
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
                                            {{ $paciente->pac_nacimiento  }}
                                        </h6>
                                    </div>
                                </div>

                            </div>
                            <div class="card-body">
                                <div class="row mt-3">
                                    <div class="col-sm-12 text-center bg-pr mt-3">
                                        <span class="font-weight-bold"> Notas de Evolución </span>
                                    </div>
                                </div>
                                 </div>
                                <div class="row">
                                    <div class="col-sm-11 m-2 m-auto">
                                        <div class="table-responsive mt-2">
                                            <table id="tablaNotas" class="table table-striped table-bordered table-condensed" style="width:100%" >
                                                <thead class="text-center">
                                                <tr class="badge-primary">
                                                    <th>Id</th>
                                                    <th>Descripción</th>
                                                    <th>Fecha</th>
                                                    <th>Hora</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($notas as $nota)
                                                    <tr>
                                                        <td  class="text-center">{{ $nota->not_id}}</td>
                                                        <td>{{ $nota->not_descripcion}}</td>
                                                        <td class="text-center">{{date("d-m-Y",strtotime( $nota->not_fecha))}}</td>
                                                        <td class="text-center">{{date("H:i:s",strtotime( $nota->hora))}}</td>
                                                    </tr>

                                                @endforeach
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

            </div></section>
        <!-- /.content -->
    </div>


@endsection('content')
