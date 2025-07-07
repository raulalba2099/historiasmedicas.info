@extends('plantilla')
@section('content')
    <?php

    use App\Http\Controllers\HistoriaClinicaRespuestasController;
    use App\Http\Controllers\PacienteController;

    $resp = new HistoriaClinicaRespuestasController();
    $paciente = new PacienteController();
    ?>
    @if(auth()->user()->esp_id == 2)
        <div class="content-wrapper" style="min-height: 247px;">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-2">
                            <h1>Menus</h1>
                        </div>
                    </div>

                    <a href="{{ url('/') }}/consulta/{{$consulta->cit_id}}" class="btn btn-primary btn-sm mt-4">
                        <i class="fas fa-file-medical"></i> <span>Consulta</span>
                    </a>
                    {{--                <a href="{{ url('/') }}/receta/{{$consulta[0]->cit_id}}" class="btn btn-primary btn-sm mt-4">--}}
                    {{--                    <i class="fas fa-file-medical"></i> <span>Receta</span>--}}

                    {{--                </a>--}}

                    <a href="{{ url('/') }}/estudios/{{$consulta->cit_id}}" class="btn btn-primary btn-sm mt-4">
                        <i class="fas fa-file-medical"></i> <span>Estudios</span>
                    </a>
                    @if(auth()->user()->esp_id == 1)
                        <a href="{{ url('/') }}/historia/{{$consulta->cit_id}}" class="btn btn-primary btn-sm mt-4">
                            <i class="fas fa-file-medical"></i> <span>Historia Clínica</span>

                        </a>
                    @endif
                    @if(auth()->user()->esp_id == 2)
                        <a href="{{ url('/') }}/menu/{{$consulta->cit_id}}}" class="btn btn-primary btn-sm mt-4">
                            <i class="fas fa-utensils"></i> <span>Menu</span>
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
                                                {{ $consulta->pac_nacimiento  }}
                                            </h6>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <h6>
                                                <span class="font-weight-bold">Fecha y hora de cita:</span>
                                                {{ date('d-M-Y', strtotime($consulta->cit_fecha))  }}
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="card body mt-2">
                                    @if(auth()->user()->esp_id ==2)
                                        <div class="row mt-5" id="notas">
                                            <div class="col-sm-12 text-center">
                                                <span class="font-weight-bold">Menu </span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-10 m-2 m-auto">
                                                <div class="container mt-2">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <button title="Agregar" id="btnNuevoMenu" type="button"
                                                                    class="btn btn-primary" data-toggle="modal"
                                                                    data-target="#agregaMenu">
                                                                <i class="fas fa-plus-square"></i>
                                                                Agregar Menu
                                                            </button>
                                                            @if(!empty($menusArray))
                                                            <a href="{{ url('/') }}/menu_pdf/{{$consulta->cit_id}}"
                                                               title="Descargar"
                                                               id="btnDescargarMenu"
                                                               class="btn btn-success text-white" target="_blank">
                                                                <i class="fas fa-download"></i>
                                                                Descargar
                                                            </a>
                                                            <a href="{{ url('/') }}/sendMenu_pdf/{{$consulta->cit_id}}"
                                                               title="Enviar Menu" title="Agregar"
                                                               id="btnEnviarMenu"
                                                               class="btn btn-success text-white" target="_blank">
                                                                <i class="fas fa-envelope"></i>
                                                                Enviar
                                                            </a>
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
                                                                            <i class='fas fa-pencil-alt'></i>

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
                                                                                    <i class='fas fa-pencil-alt'></i>
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
                                                        <input type="hidden" id="recomendacionesId"
                                                               name="recomendacioensId"
                                                               value="@if(!empty($recomendaciones)){{$recomendaciones[0]['rec_id']}} @endif"
                                                        >
                                                        <textarea name="" id="recomendaciones" cols="30" rows="5">@if(!empty($recomendaciones))
                                                                {{$recomendaciones[0]['rec_descripcion']}}
                                                            @endif  </textarea>
                                                    </div>
                                                    <div class="botones-menu text-center mt-3">
                                                        <button type="button" class="btn btn-light"
                                                                data-dismiss="modal">Cancelar
                                                        </button>
                                                        <button type="submit" name="guardarRecomendaciones"
                                                                id="btnGuardarRecomendaciones"
                                                                class="btn btn-primary ml-2">
                                                            Guardar
                                                        </button>
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
            </section>
            <!-- /.content -->
        </div>
        <!-- Agregar y editar Menu -->
        <div class="modal fade" id="agregaMenu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog " role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title" id="exampleModalLabel">
                            Agrega Menu
                        </h5>
                        </h5>
                    </div>
                    <form action="{{url('/')}}/menu" class="bg-light "
                          method="post" novalidate name="agregaMenuForm" id="agregaMenuForm">
                        {{--                    @csrf--}}
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="input-group mb-3">
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <i class="fas fa-utensils"></i>
                                            </div>
                                        </div>
                                        <select name="comida" id="comida" class="form-control" required>
                                            <option value="0"> -- Seleccione --</option>
                                            <option value="1"> Ayunas</option>
                                            <option value="2"> Desayuno</option>
                                            <option value="3"> Colación</option>
                                            <option value="4"> Comida</option>
                                            <option value="5"> Cena</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6" id="div-dia">
                                    <div class="input-group mb-3">
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <i class="fas fa-calendar-day"></i>
                                            </div>
                                        </div>
                                        <input type="hidden" name="men_id" id="men_id">
                                        <select name="dia" id="dia" class="form-control" required>
                                            <option value="0"> --Seleccion Día--</option>
                                            <option value="1"> Día 1</option>
                                            <option value="2"> Día 2</option>
                                            <option value="3"> Día 3</option>
                                            |
                                            <option value="4"> Día 4</option>
                                            <option value="5"> Día 5</option>
                                            <option value="6"> Día 6</option>
                                            <option value="7"> Día 7</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="hidden" name="moduloe_menu" id="moduloMenu" value="1">
                                    <input type="hidden" name="cit_id" id="citId" value="{{$consulta->cit_id}}">
                                    <input type="hidden" name="pac_id" id="pac_id" value="{{$consulta->pac_id}}">
                                    <input type="hidden" name="fecha_menu" id="fechaMenu"
                                           value="{{$consulta->cit_fecha}}"/>
                                    <textarea name="descripcion" id="descripcionMenu" cols="" rows="5"
                                              class="form-control"></textarea>

                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="cancelar-menu" class="btn btn-light" data-dismiss="modal">
                                Cancelar
                            </button>
                            <button type="submit" name="guardarMenu" id="btnGuardarMenu" class="btn btn-primary">
                                Guardar
                            </button>
                            {{--                        @csrf--}}
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!--Agregar Correo -->
        <div class="modal fade" id="enviarMenu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-mediano" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title" id="exampleModalLabel">
                            Enviar Menu
                        </h5>
                    </div>
                    <form action="{{url('/')}}/sendMenu_pdf" class="bg-light "
                          method="POST" novalidate name="sedPdfForm" id="sedPdfForm">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="input-group mb-3">
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <i class="fas fa-envelope"></i>
                                            </div>
                                        </div>
                                        <input type="hidden" name="cit_id" id="cit_id" value="{{$consulta->cit_id}}">
                                        <input type="emial" name="email" id="email" class="form-control" placeholder="Correo" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-12 d-none">
                                    <div class="input-group mb-3">
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <i class="fas fa-pen"></i>
                                            </div>
                                        </div>
                                        <input type="hidden" name="cit_id" id="cit_id" value="{{$consulta->cit_id}}">
                                        <textarea name="mensaje" id="mensaje" cols="" rows="5"
                                                  class="form-control"></textarea>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="reset" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                            <button type="submit" name="guardarConsulta" id="btnGuardarConsulta" class="btn btn-primary">
                                Enviar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    @endif

    @if (Session::has("mensaje-enviado"))

        <script>
            notie.alert({type: 1, text: '¡Le Menu ha sido enviada correctamente!', time: 10})
        </script>

    @endif

    @if (Session::has("mensaje-error"))

        <script>
            notie.alert({type: 3, text: '¡El Menu no se  enviado. Intente de nuevo.!', time: 10})
        </script>

    @endif

    @if (Session::has("ok-crear-menu"))

        <script>
            notie.alert({type: 1, text: '¡El menu ha sido creada correctamente!', time: 10})
        </script>

    @endif


    @if (Session::has("no-crear-menu"))

        <script>
            notie.alert({type: 3, text: '¡Error al actualizar el registro!', time: 10})
        </script>

    @endif

@endsection('content')
