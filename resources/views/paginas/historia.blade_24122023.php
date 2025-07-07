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
                        <h1>Historia Clínica</h1>
                    </div>
                </div>

                <a href="{{ url('/') }}/consulta/{{$consulta->cit_id}}" class="btn btn-primary btn-sm mt-4">
                    <i class="fas fa-file-medical"></i> <span>Consulta</span>
                </a>
{{--                <a href="{{ url('/') }}/receta/{{$consulta->cit_id}}" class="btn btn-primary btn-sm mt-4">--}}
{{--                    <i class="fas fa-file-medical"></i> <span>Receta</span>--}}
{{--                </a>--}}
                <a href="{{ url('/') }}/estudios/{{$consulta->cit_id}}" class="btn btn-primary btn-sm mt-4">
                    <i class="fas fa-file-medical"></i> <span>Estudios</span>
                </a>
                <a href="{{ url('/') }}/historia/{{$consulta->cit_id}}" class="btn btn-primary btn-sm mt-4">
                    <i class="fas fa-file-medical"></i> <span>Historia Clínica</span>
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
                                <div class="row mt-2">
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
{{--                                <div class="row mt-3">--}}
{{--                                    <div class="col-sm-6">--}}
{{--                                        <h6>--}}
{{--                                            <span class="font-weight-bold">Razón de su visita:</span>--}}
{{--                                            <textarea class="form-control mt-2" name="" id=""></textarea>--}}
{{--                                        </h6>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                            </div>
                            <div class="card body mt-2 caja  m-0 m-auto mt-3" style="width: 90%;">
                                <form action="{{url('/')}}/historia" class="bg-light needs-validation" method="post" novalidate>
                                    @csrf
                                @if(!empty($secciones))
                                        <input type="hidden" name="pac_id" value="{{$consulta->pac_id}}">
                                        <input type="hidden" name="cit_id" value="{{$consulta->cit_id}}">
                                    @foreach($secciones as $key => $seccion)
                                        <div class="row p-r-3 pl-3 mb-3 mt-3">
                                            <div class="col-sm-3 bg-primary">
                                                <h5>{{$seccion['sec_nombre']}} </h5>
                                            </div>
                                            <div class="col-sm-9 bg-primary">
                                                <h5>{{$seccion['sec_descripcion']}} </h5>
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
                                                                    <div class="col-sm-12 pb-3 color-claro">
                                                                        <input type="hidden" value="{{$pregunta['id']}}" name="idPregunta[]">
                                                                        {{$pregunta['descripcion']}}
                                                                            <input type="text" class="form-control"
                                                                                   name="respuesta[]" value="{{ (!empty($pregunta['respuesta']) ? $pregunta['respuesta'] : '')}}" autocomplete="off">
                                                                    </div>
                                                                @endif
                                                                @if($pregunta['tipo'] == 2)
                                                                    <div class="col-sm-3">
                                                                        <div>
                                                                            <input type="checkbox" class="c"
                                                                                   name="pregunta_{{$pregunta['id']}}"
                                                                                   value="1"
                                                                                   @if(!empty($pregunta['respuesta']))
                                                                                       @if($pregunta['respuesta'] == 1)
                                                                                           {{'checked'}}
                                                                                           @endif
                                                                                   @endif

                                                                            >
                                                                            {{$pregunta['descripcion']}}
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                                @if($pregunta['tipo'] == 3)
                                                                    <div class="col-sm-12 pb-3 color-claro">
                                                                        <div class="col-sm-6">
                                                                        <span
                                                                            class="font-weight-bold">{{$pregunta['descripcion']}}</span>
                                                                            <div>
{{--                                                                                <span>{{$pregunta['respuesta']}}</span>--}}
                                                                                <input type="radio"
                                                                                       name="pregunta_{{$pregunta['id']}}"
                                                                                       value="1"
                                                                                       @if(!empty($pregunta['respuesta']))
                                                                                        @if($pregunta['respuesta'] == 1)
                                                                                            {{'checked'}}
                                                                                        @endif
                                                                                       @endif
                                                                                >
                                                                                Positivo
                                                                                <input type="radio"
                                                                                       name="pregunta_{{$pregunta['id']}}"
                                                                                       value="2"
                                                                                     @if(!empty($pregunta['respuesta']))
                                                                                         @if($pregunta['respuesta'] == 2)
                                                                                        {{'checked'}}
                                                                                        @endif
                                                                                    @endif
                                                                                >
                                                                                Negativo
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
                                    <div class="row">
                                        <div class="col-sm-12 text-center mt-5">
                                            <button class="btn btn-light" type="reset">Cancelar</button>
                                            <button type="submit" name="guardarReceta" id="btnGuardarReceta"
                                                    class="btn btn-primary  text-center">
                                                Guardar
                                            </button>

                                        </div>
                                    </div>
                                </form>
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


    @if (Session::has("ok-crear"))

        <script>
            notie.alert({type: 1, text: '¡La historia clinica ha sido creada correctamente!', time: 10})
        </script>

    @endif

    @if (Session::has("ok-editar"))

        <script>
            notie.alert({type: 1, text: '¡La historía clinica ha sido actualizada correctamente!', time: 10})
        </script>

    @endif

    @if ($errors->any())
        <script>
            // $("#editarPaciente").modal()
            notie.alert({type: 3, text: '¡Error al actualizar el Registro !', time: 10})
        </script>
    @endif

@endsection('content')
