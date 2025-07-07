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

                @if(auth()->user()->esp_id == 4)
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
                                            <span class="font-weight-bold">Fecha de Consulta:</span>
                                            {{ date('d-M-Y', strtotime($fechaMenu)) }}
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
                                        <input type="hidden" id="fechaMenu" name="fechaMenu" value="{{$fechaMenu}}">
                                        <input type="hidden" id="espId" name="esp_id" value="{{auth()->user()->esp_id}}">
                                        <input type="hidden" name="module" id="module" class="module" value="3"
                                               method="GET"
                                               action="{{url('/')}}/expediente-menu/{{$paciente->pac_id}}">
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
                                @foreach($horas as $key => $valor)
                                    {{
                                        '{
                                             startDate: new Date(new Date().setHours(new Date().getHours() - '.$valor.' )).toISOString(),
                                            endDate: new Date(new Date().setHours(new Date().getHours() -  '.$valor.')).getTime(),

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
                                    <div class="col-sm-12 m-2 m-auto caja"  >
                                        @if(auth()->user()->esp_id ==2)
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <!-- Default box -->
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <div class="row">
                                                                    <h6 class="float-right">
                                                                        <span class="font-weight-bold">Fecha de Menu:</span>
                                                                        {{ date('d-M-Y', strtotime($fechaMenu)) }}
                                                                    </h6>
                                                                </div>
                                                                <div class="row mt-5" id="notas">
                                                                    <div class="col-sm-12 text-center">
                                                                        <span class="font-weight-bold">Menu </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="card body mt-2">
                                                                @if(auth()->user()->esp_id ==2)
                                                                    <div class="row">
                                                                        <div class="col-sm-10 m-2 m-auto">
                                                                            <div class="container mt-2">
                                                                                <div class="row">
                                                                                    <div class="col-lg-6">
                                                                                        @if(!empty($menusArray))
{{--                                                                                            <a href="{{ url('/') }}/menu_pdf/{{$paciente->pac_id}}"--}}
{{--                                                                                               title="Descargar"--}}
{{--                                                                                               id="btnDescargarMenu"--}}
{{--                                                                                               class="btn btn-success text-white" target="_blank">--}}
{{--                                                                                                <i class="fas fa-download"></i>--}}
{{--                                                                                                Descargar--}}
{{--                                                                                            </a>--}}
{{--                                                                                            <a href="{{ url('/') }}/sendMenu_pdf/{{$paciente->pac_id}}"--}}
{{--                                                                                               title="Enviar Menu" title="Agregar"--}}
{{--                                                                                               id="btnEnviarMenu"--}}
{{--                                                                                               class="btn btn-success text-white" target="_blank">--}}
{{--                                                                                                <i class="fas fa-envelope"></i>--}}
{{--                                                                                                Enviar--}}
{{--                                                                                            </a>--}}
                                                                                        @endif
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="table-responsive mt-2">
                                                                                <table id="tablaMenus"
                                                                                       class="table responsive table table-striped table-bordered table-condensed"
                                                                                       style="width:100%">
                                                                                    <thead class="text-center">
                                                                                    <tr class="badge-primary">
                                                                                        <th></th>
                                                                                        @for($i = 1; $i<=7; $i++)
                                                                                            <th>Día {{ $i }}</th>
                                                                                        @endfor
                                                                                    </tr>
                                                                                    </thead>
                                                                                    <tbody class="bodyMenus" id="bodyMenus">
                                                                                    @foreach($menusArray as $key => $menu)
                                                                                        <tr id="{{$menu['com_id']}}">
                                                                                            <td>  {{$menu['comida']}} </td>
                                                                                            @if($menu['com_id'] ==1 || $menu['com_id'] == 3 )
                                                                                                <td colspan="7" class=""
                                                                                                    id="men_{{$menu['com_id']}}_{{1}}">
                                                                                                    <div class="float-right editar-comida"
                                                                                                         style="cursor:pointer;"
                                                                                                         men_id="{{$menu['1']['men_id']}}"
                                                                                                         com_id="{{$menu['com_id']}}"
                                                                                                         dia="{{1}}"
                                                                                                    >
{{--                                                                                                        <i class='fas fa-pencil-alt'></i>--}}

                                                                                                    </div>
                                                                                                    <div id="men_{{$menu['com_id']}}_{{1}}"
                                                                                                         class="descripcion"> {!!  $menu['1']['descripcion'] !!}
                                                                                                    </div>
                                                                                                </td>
                                                                                            @else
                                                                                                @for($i = 1; $i<= 7; $i++ )
                                                                                                    <td class=""
                                                                                                        id="men_{{$menu['com_id']}}_{{$i}}">
                                                                                                        @if(!empty($menu[$i]['descripcion']))
                                                                                                            <div class="float-right editar-comida"
                                                                                                                 style="cursor:pointer;"
                                                                                                                 men_id="{{$menu[$i]['men_id']}}"
                                                                                                                 com_id="{{$menu['com_id']}}"
                                                                                                                 dia="{{$i}}"
                                                                                                            >
{{--                                                                                                                <i class='fas fa-pencil-alt'></i>--}}
                                                                                                            </div>
                                                                                                            <div class="descripcion"
                                                                                                                 id="men_{{$menu['com_id']}}_{{$i}}">
                                                                                                                {!! $menu[$i]['descripcion'] !!}
                                                                                                            </div>
                                                                                                        @endif
                                                                                                    </td>
                                                                                                @endfor
                                                                                            @endif
                                                                                        </tr>
                                                                                    @endforeach
                                                                                    </tbody>
                                                                                </table>
                                                                                <div class="recomendaciones border-primary w-75 m-0 m-auto">
                                                                                    <textarea id="recomendaciones" disabled>@if(!empty($recomendaciones))
                                                                                                 {{$recomendaciones[0]['rec_descripcion']}}
                                                                                             @endif  </textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
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
