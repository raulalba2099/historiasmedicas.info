@extends('plantilla')
@section('content')

    <div class="content-wrapper" style="min-height: 247px;">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Hoja Membretada</h1>
                    </div>
                    {{--        <div class="col-sm-6">--}}
                    {{--          <ol class="breadcrumb float-sm-right">--}}
                    {{--            <li class="breadcrumb-item"><a href="{{url('/')}}">Registrar</a></li>--}}
                    {{--            <li class="breadcrumb-item active">Administradores</li>--}}
                    {{--          </ol>--}}
                    {{--        </div>--}}
                </div>
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
                                {{--             <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#crearPaciente">--}}
                                {{--              Crear nuevo Paciente--}}
                                {{--             </button>--}}
                            </div>
                            <div class="card-body">
                                <form action="{{url('/')}}/membrete" class="bg-light " method="post" novalidate
                                      name="formMembrete" id="formMembrete" target="_blank">
                                    @csrf
                                    @method('POST')
                                    <div class="container container-fluid  m-0 m-auto" id="">
                                        <div class="row mt-3">
                                            <div class="col-md-8 m-0 m-auto">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-append">
                                                        <div class="input-group-text">
                                                            <i class="fas fa-calendar-alt"></i>
                                                        </div>
                                                    </div>
                                                    <input id="fecha" type="date" class="form-control fecha"
                                                           name="fecha" value="{{date("Y-m-d")}}" required autofocus>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-md-8 m-0 m-auto">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-append">
                                                        <div class="input-group-text">
                                                            <i class="fas fa-calendar-alt"></i>
                                                        </div>
                                                    </div>
                                                    <textarea class="form-control" name="textoMembrete" id="ardeaMembrete"
                                                              cols="30"
                                                              rows="20"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="botones text-center">
                                            <button type="reset" class="btn btn-light" data-dismiss="modal">Cancelar
                                            </button>
                                            <button type="submit" name="btnMembrete" id="btnMembrete"
                                                    class="btn btn-primary">
                                                Guardar
                                            </button>
                                        </div>
                                    </div>
                                </form>
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

    @if (Session::has("ok-crear"))

        <script>
            notie.alert({type: 1, text: '¡El Paciente ha sido creado correctamente!', time: 10})
        </script>

    @endif

    @if ($errors->any())
        <script>
            // $("#editarPaciente").modal()
            notie.alert({type: 3, text: '¡Error al actualizar el paciente!', time: 10});
        </script>
    @endif

@endsection('content')
