@extends('plantilla')
@section('content')

    <?php

    use App\Http\Controllers\PacienteController;
    use App\Http\Controllers\CalendarioContenidoController;
    use \App\Http\Controllers\CitaController;
    use \App\Http\Controllers\ExamenFisicoController;

    $calendario = new CalendarioContenidoController();
    $fecha = date("Y-m-d");
    $pac = new PacienteController();
    $datos = CitaController::indexAction();

    ?>
    <div class="content-wrapper" style="min-height: 247px;">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Expediente Exámen Físico</h1>
                    </div>
                </div>

                <a href="{{ url('/') }}/expediente-estudios/{{$paciente->pac_id}}" class="btn btn-primary btn-sm mt-4">
                    <i class="fas fa-file-medical"></i> <span>Estudios</span>
                </a>

                <a href="{{ url('/') }}/expediente-fisico/{{$paciente->pac_id}}" class="btn btn-primary btn-sm mt-4">
                    <i class="fas fa-file-medical"></i> <span>Exámen Físico</span>
                </a>

                <a href="{{ url('/') }}/expediente-historia/{{$paciente->pac_id}}" class="btn btn-primary btn-sm mt-4">
                    <i class="fas fa-file-medical"></i> <span>Historia Clínica</span>
                </a>

                <a href="{{ url('/') }}/expediente-notas/{{$paciente->pac_id}}" class="btn btn-primary btn-sm mt-4">
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
                                            <span class="font-weight-bold">Fecha de Consulta:</span>
                                            {{ date('d-M-Y') }}
                                        </h6>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4 h-2" style="height: 20px;">
                                        <h6>
                                            <span class="font-weight-bold">Edad</span>
                                            {{ $paciente->pac_nacimiento }}
                                        </h6>

                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="row text-center" >
                                    <div class="col-sm-12">
                                        <input type="hidden" name="module" id="module" class="module" value="2"
                                               method="GET"
                                               action="{{url('/')}}/expediente-fisico-mostrar/{{$paciente->pac_id}}">
                                        @csrf
                                        <div id="containerCalendar" class="calendar-container" ></div>
                                    </div>
                                </div>
                                <?php
                                print '
                         <script>
                    var $calendar;
                    $(document).ready(function () {
                        let container = $("#containerCalendar").simpleCalendar({
                            fixedStartDay: 0, // begin weeks by sunday
                            disableEmptyDetails: true,
                         events:
                            ['; ?>
                                @foreach($fisicos as $key => $valor)
                                    {{
                                        '{

                                             startDate: new Date(new Date().setHours(new Date().getHours() - '.$valor["horas"].' )).toISOString(),
                                            endDate: new Date(new Date().setHours(new Date().getHours() -  '.$valor["horas"].')).getTime(),


                                        },'
                                    }}
                                @endforeach
                                <?php
                                print '
                                ],
                        });

                        $calendar = container.data("plugin_simpleCalendar")
                    });
                </script>
                  ' ?>
                                <div class="row mt-4" >
                                    <div class="col-sm-10 m-2 m-auto caja"  >
                                        <div class="row">
                                            <div class="col-sm-12 text-center">
                                                <span class="font-weight-bold"> Exámen Físico {{date('d-m-Y',strtotime($fisico?->fecha))}} </span>
                                            </div>
                                        </div>
                                        <div class="container mt-2">
                                            <div class="row mt-3">
                                                <div class="col-sm-4">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    Presón Arterial Sistólica
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-append">
                                                            <div class="input-group-text">
                                                                <i class="fas fa-heartbeat"></i>
                                                            </div>
                                                        </div>

                                                        <input class="form-control text-right" type="text"
                                                               name="sistolica" id="sistolica"
                                                               value="{{ (!empty($fisico) ? $fisico->presion_arterial_sistolica : '' )  }}"
                                                               readonly />
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    Presón Arterial Diastolica
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-append">
                                                            <div class="input-group-text">
                                                                <i class="fas fa-heartbeat"></i>
                                                            </div>
                                                        </div>

                                                        <input class="form-control text-right" type="text"
                                                               name="diastolica" id="diastolica"
                                                               value="{{ (!empty($fisico) ? $fisico->presion_arterial_diastolica : '' )  }}"
                                                               readonly />
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

                                                        <input class="form-control text-right" type="text"
                                                               name="diastolica" id="diastolica"
                                                               value="{{ (!empty($fisico) ? $fisico->presion_arterial : '' )  }}"
                                                               readonly />
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

                                                        <input class="form-control text-right" type="text"
                                                               name="cardiaca" id="cardiaca"
                                                               value="{{ (!empty($fisico) ? $fisico->frecuencia_cardiaca : '' )  }}"
                                                               readonly />
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
                                                               name="respiratoria" id="respiratoria"
                                                               value="{{ (!empty($fisico) ? $fisico->frecuencia_respiratoria : '' )  }}"
                                                               disabled>
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
                                                               value="{{!empty($fisico) ? $fisico->saturacion : '' }}"
                                                               disabled>
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
                                                               name="temperatura" id="temperatura"
                                                               value="{{!empty($fisico) ? $fisico->temperatura : '' }}"
                                                               disabled>
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
                                                        <input class="form-control text-right" type="text" name="peso"
                                                               id="peso"
                                                               value="{{!empty($fisico) ? $fisico->peso : '' }}"
                                                               disabled>
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
                                                        <input class="form-control text-right" type="text" name="talla"
                                                               id="talla"
                                                               value="{{!empty($fisico) ? $fisico->talla : ''  }}"
                                                               disabled>
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
                                                        <input class="form-control text-right" type="text" name="imc"
                                                               id="imc"
                                                               value="{{!empty($fisico) ? number_format($fisico->imc, 1) : '' }}"
                                                               disabled>
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
                                                               value="{{!empty($fisico) ? $fisico->alergias : ''  }}"
                                                               disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    Glucosa
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-append">
                                                            <div class="input-group-text">
                                                                <i class="fas fa-file-medical-alt"></i>
                                                            </div>
                                                        </div>
                                                        <input  class="form-control text-right" type="text" name="alergias"
                                                               id="alergias"
                                                               value="{{!empty($fisico) ? $fisico->glucosa : ''  }}"
                                                               disabled>
                                                    </div>
                                                </div>
                                                <div class="col-sm-8">
                                                    Diagnostico
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-append">
                                                            <div class="input-group-text">
                                                                <i class="fas fa-file-medical-alt"></i>
                                                            </div>
                                                        </div>
                                                        <input class="form-control" type="text" name="alergias"
                                                               id="alergias"
                                                               value="{{!empty($fisico) ? $fisico->diagnostico : ''  }}"
                                                               disabled>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--  <hr/> -->
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer" id="div1">
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

@endsection('content')
