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
                @if(auth()->user()->esp_id ==1)
                <a href="{{ url('/') }}/expediente-historia/{{$paciente->pac_id}}" class="btn btn-primary btn-sm mt-4">
                    <i class="fas fa-file-medical"></i> <span>Historia Clínica</span>
                </a>
                @endif

                <a href="{{ url('/') }}/expediente-notas/{{$paciente->pac_id}}" class="btn btn-primary btn-sm mt-4">
                    <i class="fas fa-file-medical"></i> <span>Notas de Evolución</span>
                </a>

                @if(auth()->user()->esp_id == 2)
                    <a href="{{ url('/') }}/expediente-menu/{{$paciente->pac_id}}/{{date('Y-m-d')}}" class="btn btn-primary btn-sm mt-4">
                        <i class="fas fa-utensils"></i></i> <span>Menu</span>
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
                                            {{ $paciente ->pac_nombre}}
                                            {{ $paciente ->pac_paterno}}
                                            {{ $paciente ->pac_materno}}
                                        </h6>
                                    </div>
                                    <div class="col-sm-6">
                                        <h6 class="float-right">
                                            <span class="font-weight-bold fechaConsulta">Fecha de Consulta:</span>
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
                                <div class="card-header">
                                </div>
                                <div class="row text-center" >
                                    <div class="col-sm-12">
                                        <input type="hidden" id="espId" name="esp_id" value="{{auth()->user()->esp_id}}">
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
                                                <span class="font-weight-bold"> Exámen Físico </span>
                                                <span class="font-weight-bold  fechaConsulta"> {{ date('d-M-Y', strtotime($fecha)) }} </span>
                                            </div>
                                        </div>
                                        @if(auth()->user()->esp_id !=2)
                                            <div class="container mt-2">
                                                <form action="{{url('/')}}/examen-fisico" class="bg-light "
                                                      method="post" novalidate name="agregaNotaForm" id="agregaNotaForm">
                                                    @csrf
                                                    <div class="row mt-3">
                                                        <div class="col-sm-4">
                                                            Presón Arterial Sistólica
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-append">
                                                                    <div class="input-group-text">
                                                                        <i class="fas fa-heartbeat"></i>
                                                                    </div>
                                                                </div>
                                                                <input class="form-control text-right presion_arterial"
                                                                       type="text"
                                                                       name="sistolica"
                                                                       id="sistolica"
                                                                       value="{{ (!empty($fisico) ? $fisico->presion_arterial_sistolica : '' )  }}" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            Presón Arterial Diastólica
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-append">
                                                                    <div class="input-group-text">
                                                                        <i class="fas fa-heartbeat"></i>
                                                                    </div>
                                                                </div>
                                                                <input class="form-control text-right presion_arterial"
                                                                       type="text"
                                                                       name="diastolica" id="diastolica"
                                                                       value="{{ (!empty($fisico) ? $fisico->presion_arterial_diastolica : '' )  }}">
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
                                                                       name="arterial" id="arterial"
                                                                       value="{{ (!empty($fisico) ? number_format($fisico->presion_arterial, 1) : '' )  }}"
                                                                       readonly/>
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
                                                                <input class="form-control text-right" type="text"
                                                                       name="respiratoria" id="respiratoria"
                                                                       value="{{ (!empty($fisico) ? $fisico->frecuencia_respiratoria : '' )  }}">
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
                                                                       value="{{!empty($fisico) ? $fisico->saturacion : '' }}">
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
                                                                <input class="form-control text-right calcula_imc"
                                                                       type="text"
                                                                       name="peso" id="peso"
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
                                                                <input class="form-control text-right calcula_imc"
                                                                       type="text"
                                                                       name="talla" id="talla"
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
                                                                <input class="form-control text-right" type="text"
                                                                       name="imc" id="imc"
                                                                       value="{{!empty($fisico) ? number_format($fisico->imc, 1) : '' }}"
                                                                       readonly>
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
                                                                       value="{{!empty($fisico) ? $fisico->alergias : ''  }}">
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            Glucosa
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-append">
                                                                    <div class="input-group-text">
                                                                        <i class="fas fa-male"></i>
                                                                    </div>
                                                                </div>
                                                                <input class="form-control text-right" type="text"
                                                                       name="glucosa" id="glucosa"
                                                                       value="{{!empty($fisico) ? $fisico->glucosa : '' }}">
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
                                                                <input class="form-control" type="text" name="diagnostico"
                                                                       id="diagnostico"
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
                                        @endif
                                        @if(auth()->user()->esp_id ==2)
                                            <div class="container mt-2">
                                                <form action="{{url('/')}}/examen-fisico" class="bg-light "
                                                      method="post" novalidate name="agregaNotaForm" id="agregaNotaForm">
                                                    @csrf
                                                    <div class="row mt-3">
                                                        <div class="col-sm-4">
                                                            Porcentaje de Grasa
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-append">
                                                                    <div class="input-group-text">
                                                                        <i class="fas fa-heartbeat"></i>
                                                                    </div>
                                                                </div>
                                                                <input class="form-control text-right presion_arterial"
                                                                       type="text"
                                                                       name="exa_grasa"
                                                                       id="exaGrasa"
                                                                       value="{{ (!empty($fisico) ? $fisico->exa_grasa : '' )  }}" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            Porcentaje de músculo
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-append">
                                                                    <div class="input-group-text">
                                                                        <i class="fas fa-heartbeat"></i>
                                                                    </div>
                                                                </div>
                                                                <input class="form-control text-right presion_arterial"
                                                                       type="text"
                                                                       name="exa_musculo" id="exaMusculo"
                                                                       value="{{ (!empty($fisico) ? $fisico->exa_musculo : '' )  }}" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            Porcentaje de grasa visceral
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-append">
                                                                    <div class="input-group-text">
                                                                        <i class="fas fa-heartbeat"></i>
                                                                    </div>
                                                                </div>
                                                                <input class="form-control text-right" type="text"
                                                                       name="exa_visceral" id="exViceral"
                                                                       value="{{ (!empty($fisico) ? $fisico->exa_visceral : '' )  }}"
                                                                disabled />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-3">
                                                        <div class="col-sm-4">
                                                            Edad Metabólica
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-append">
                                                                    <div class="input-group-text">
                                                                        <i class="fas fa-heartbeat"></i>
                                                                    </div>
                                                                </div>
                                                                <input class="form-control text-right" type="text"
                                                                       name="exa_metabolica" id="exaMetabolica"
                                                                       value="{{ (!empty($fisico) ? $fisico->exa_metabolica : '' )  }}" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            Kilos Totales
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-append">
                                                                    <div class="input-group-text">
                                                                        <i class="fas fa-lungs"></i>
                                                                    </div>
                                                                </div>
                                                                <input class="form-control text-right" type="text"
                                                                       name="exa_kilos" id="exaKilos"
                                                                       value="{{ (!empty($fisico) ? $fisico->exa_kilos : '' )  }}" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            Circunferencía media de brazo (CMB)
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-append">
                                                                    <div class="input-group-text">
                                                                        <i class="fas fa-heartbeat"></i>
                                                                    </div>
                                                                </div>
                                                                <input class="form-control text-right" type="text"
                                                                       name="exa_cmb" id="exaCmb"
                                                                       value="{{!empty($fisico) ? $fisico->exa_cmb : '' }}" disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-3">
                                                        <div class="col-sm-4">
                                                            Circunferencia Medía de Cintura (CCI)
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-append">
                                                                    <div class="input-group-text">
                                                                        <i class="fas fa-thermometer"></i>
                                                                    </div>
                                                                </div>
                                                                <input class="form-control text-right" type="text"
                                                                       name="exa_cci" id="exaCCi"
                                                                       value="{{!empty($fisico) ? $fisico->exa_cci : '' }}" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            Cinrcunferencía de Cadera
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-append">
                                                                    <div class="input-group-text">
                                                                        <i class="fas fa-weight"></i>
                                                                    </div>
                                                                </div>
                                                                <input class="form-control text-right"
                                                                       type="text"
                                                                       name="exa_cca" id="exaCca"
                                                                       value="{{!empty($fisico) ? $fisico->exa_cca : '' }}" disabled>
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
                                                                <input class="form-control text-right calcula_imc"
                                                                       type="text"
                                                                       name="peso" id="peso"
                                                                       value="{{!empty($fisico) ? $fisico->peso : '' }}" disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-3">
                                                        <div class="col-sm-4">
                                                            Talla
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-append">
                                                                    <div class="input-group-text">
                                                                        <i class="fas fa-ruler-vertical"></i>
                                                                    </div>
                                                                </div>
                                                                <input class="form-control text-right calcula_imc"
                                                                       type="text"
                                                                       name="talla" id="talla"
                                                                       value="{{!empty($fisico) ? $fisico->talla : ''  }}" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            IMC
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-append">
                                                                    <div class="input-group-text">
                                                                        <i class="fas fa-male"></i>
                                                                    </div>
                                                                </div>
                                                                <input class="form-control text-right" type="text"
                                                                       name="imc" id="imc"
                                                                       value="{{!empty($fisico) ? number_format($fisico->imc, 1) : '' }}"
                                                                       disabled>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            Alergias
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-append">
                                                                    <div class="input-group-text">
                                                                        <i class="fas fa-file-medical-alt"></i>
                                                                    </div>
                                                                </div>
                                                                <input class="form-control" type="text" name="alergias"
                                                                       id="alergias"
                                                                       value="{{!empty($fisico) ? $fisico->alergias : ''  }}" disabled>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            Glucosa
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-append">
                                                                    <div class="input-group-text">
                                                                        <i class="fas fa-male"></i>
                                                                    </div>
                                                                </div>
                                                                <input class="form-control text-right" type="text"
                                                                       name="glucosa" id="glucosa"
                                                                       value="{{!empty($fisico) ? $fisico->glucosa : '' }}" disabled>
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
                                                                <input class="form-control" type="text" name="diagnostico"
                                                                       id="diagnostico"
                                                                       value="{{!empty($fisico) ? $fisico->diagnostico : ''  }}" disabled>
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
                                        @endif
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
