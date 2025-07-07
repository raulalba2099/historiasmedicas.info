@extends('plantilla')
@section('content')

    <?php

    use App\Http\Controllers\HistoriaClinicaRespuestasController;
    use App\Http\Controllers\PacienteController;
    $pac = new PacienteController();
    $resp = new HistoriaClinicaRespuestasController();
    ?>

    <div class="content-wrapper" style="min-height: 247px;">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Expediente Historia Clínica</h1>
                    </div>
                </div>
                <a href="{{ url('/') }}/expediente-estudios/{{$paciente->pac_id}}" class="btn btn-primary btn-sm mt-4">
                    <i class="fas fa-file-medical"></i> <span>Estudios</span>
                </a>

                <a  href="{{ url('/') }}/expediente-fisico/{{$paciente->pac_id}}" class="btn btn-primary btn-sm mt-4" >
                    <i class="fas fa-file-medical"></i> <span>Exámen Físico</span>
                </a>

                <a href="{{ url('/') }}/expediente-historia/{{$paciente->pac_id}}" class="btn btn-primary btn-sm mt-4">
                    <i class="fas fa-file-medical"></i> <span>Historia Clínica</span>
                </a>

                <a href="{{ url('/') }}/expediente-notas/{{$paciente->pac_id}}" class="btn btn-primary btn-sm mt-4">
                    <i class="fas fa-file-medical"></i> <span>Notas de Evolución</span>
                </a>

                @if(auth()->user()->esp_id != 2)
                    <a  href="{{ url('/') }}/recetas/{{$paciente->pac_id}}" class="btn btn-primary btn-sm mt-4" >
                        <i class="fas fa-file-medical"></i> <span>Recetas </span>
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
                                <div class="row mt-2">
                                    <div class="col-sm-6">
                                        <h6>
                                            <span class="font-weight-bold">Paciente:</span>
                                            {{ $paciente->pac_nombre}}
                                            {{ $paciente->pac_paterno}}
                                            {{ $paciente->pac_materno}}
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
                            <div class="card body mt-2 caja  m-0 m-auto mt-4 mb-4" style="width: 90%;">
                                @if(!empty($respuestas))
                                    @if(!empty($secciones))
                                        @foreach($secciones as $key => $seccion)
                                            <div class="row p-r-3 pl-3 mb-3">
                                                <div class="col-sm-12 bg-primary">
                                                    <h5>{{$seccion['sec_nombre']}}</h5>
                                                </div>
                                            </div>
                                            <div class="row  pl-3 pr-3">
                                                @if(!empty($seccion['sec_subsecciones']))
                                                    @foreach($seccion['sec_subsecciones'] as $subseccion)
                                                        <div class="col-sm-6 border">
                                                            <div class="color-fuerte">
                                                                <h5 class="">{{$subseccion['nombre']}}</h5>
                                                            </div>
                                                            @if(!empty($subseccion['preguntas']))
                                                                @foreach($subseccion['preguntas'] as $pregunta)
                                                                    @if($pregunta['tipo'] == 1)
                                                                        @if(!empty($pregunta['respuesta']))
                                                                            @if($pregunta['respuesta'] != '')
                                                                            <span class="color-claro ml-3">
                                                                              {{ $pregunta['respuesta']}}
                                                                            </span>
                                                                                <br/>
                                                                            @endif
                                                                        @endif
                                                                    @endif
                                                                    @if($pregunta['tipo'] == 2)
                                                                        <div class="col-sm-3">
                                                                            <div>
                                                                                @if($pregunta['tipo'] == 2)

                                                                                        @if(!empty($pregunta['respuesta']))
                                                                                            @if($pregunta['respuesta'] == '1')
                                                                                            <span class="color-claro ml-3">
                                                                                                {{ $pregunta['descripcion']}}
                                                                                            </span>
                                                                                            @endif
                                                                                        @endif
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                    @if($pregunta['tipo'] == 3)
                                                                        <div class="col-sm-12 pb-3 color-claro">
                                                                            <div class="col-sm-6">
                                                                            <span
                                                                                class="font-weight-bold">{{$pregunta['descripcion']}}</span>
                                                                                <div class="color-claro ml-3">
                                                                                    {{--                                                                                <span>{{$pregunta['respuesta']}}</span>--}}

                                                                                    @if(!empty($pregunta['respuesta']))
                                                                                        @if($pregunta['respuesta'] == 1)
                                                                                            {{'Positivo'}}
                                                                                        @endif
                                                                                        @if($pregunta['respuesta'] == 2)
                                                                                            {{'Negativo'}}
                                                                                        @endif
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        @endforeach
                                        {{--                                    <span class="text-center"> No existe historìa clinica configurada</span>--}}
                                    @endif
                                @else
                                  <div class=" m-0 m-auto">
                                      <span>No existe Historia Clínica para este paciente</span>
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

@endsection('content')
