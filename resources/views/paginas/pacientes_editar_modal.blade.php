<div class="modal fade" id="editarPaciente_{{$paciente->pac_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-mediano" style="width: 500px;" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="exampleModalLabel">
                    <h4>Agrega Paciente </h4>
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{url('/')}}/pacientes" class="bg-light needs-validation" method="post" novalidate>
                @csrf
                <div class="modal-body">
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="input-group mb-3 form-group">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <i class="fas fa-hashtag"></i>
                                    </div>
                                </div>
                                <input type="text" name="es_cita" id="es_cita" value="0">
                                <input id="pac_numero" type="pac_numero" class="form-control pac_numero @error('pac_numero') is-invalid @enderror" name="pac_numero" value="{{ $ultimoNumeroPaciente + 1 }}"  autocomplete="pac_numero" placeholder="Número Paciente">
                                <span class="invalid-feedback" role="alert">
                        {{$errors->first('pac_numero')}}
                      </span>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="input-group mb-3 form-group">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <i class="nav-icon fas fa-user-injured"></i>
                                    </div>
                                </div>
                                <input id="pac_nombre" type="pac_nombre" class="form-control pac_nombre @error('pac_nombre')
                                is-invalid @enderror" name="pac_nombre" value="{{ old('pac_nombre') }}" placeholder="Nombre Paciente">
                                <span class="invalid-feedback" role="alert">
                       {{$errors->first('pac_nombre')}}
                    </span>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <i class="fas fa-signature"></i>
                                    </div>
                                </div>
                                <input id="pac_paterno" type="text" class="form-control pac_paterno @error('pac_paterno') is-invalid @enderror" name="pac_paterno" value="{{ old('pac_paterno') }}" required  placeholder="Apellido Paterno" autofocus>
                                <span class="invalid-feedback" role="alert">
                       {{$errors->first('pac_paterno')}}
                    </span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <i class="fas fa-signature"></i>
                                    </div>
                                </div>
                                <input id="pac_materno" type="email" class="form-control pac_materno @error('pac_materno') is-invalid @enderror" name="pac_materno" value="{{ old('pac_materno') }}"  autocomplete="pac_materno" placeholder="Apellido Materno" autofocus>
                                <span class="invalid-feedback" role="alert">
                       {{$errors->first('pac_materno')}}
                    </span>
                            </div>
                        </div>

                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                </div>
                                <input id="date" type="date" class="form-control pac_nacimiento @error('pac_naciemiento') is-invalid @enderror" name="pac_nacimiento" value="{{ date('Y-m-d') }}" required placeholder="Fecha Nacimiento" autofocus>
                                <span class="invalid-feedback" role="alert">
                          <strong>
                            {{$errors->first('pac_naciemiento')}}</strong>
                      </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <i class="fas fa-venus-mars"></i>
                                    </div>
                                </div>
                                <select name="pac_genero" id="pac_genero" class="form-control pac_genero @error('pac_genero') is-invalid @enderror">
                                    <option value="M">Masculino</option>
                                    <option value="F">Femenino</option>
                                </select>
                                <span class="invalid-feedback" role="alert">
                          <strong>
                            {{$errors->first('pac_genero')}}</strong>
                      </span>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <i class="fas fa-map"></i>
                                    </div>
                                </div>
                                <input id="pac_direccion" type="pac_direccion" class="form-control pac_direccion @error('pac_direccion') is-invalid @enderror" name="pac_direccion" value="{{ old('pac_direccion') }}"  autocomplete="pac_direccion" placeholder="Dirección" autofocus>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-5">
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <i class="fas fa-mobile-alt"></i>
                                    </div>
                                </div>
                                <input id="pac_telefono" type="text" class="form-control pac_telefono @error('pac_telefono') is-invalid @enderror" name="pac_telefono" value="{{ old('pac_telefono') }}" required autocomplete="pac_telefono" placeholder="Telefono" autofocus>
                                <span class="invalid-feedback" role="alert">
                       {{$errors->first('pac_telefono')}}
                    </span>
                            </div>
                        </div>

                        <div class="col-md-7">
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                </div>
                                <input id="pac_correo" type="email" class="form-control pac_correo @error('pac_correo') is-invalid @enderror" name="pac_correo" value="{{ old('pac_correo') }}"  placeholder="Correo" >
                                <span class="invalid-feedback" role="alert">
                       {{$errors->first('pac_correo')}}
                    </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                    <button type="submit" name="guardarEquipo" id="btnGuardar" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
