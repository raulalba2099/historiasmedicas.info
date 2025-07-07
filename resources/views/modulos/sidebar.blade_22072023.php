<?php
    use App\Http\Controllers\EspecialidadController;
?>


  <aside class="main-sidebar background-fuerte elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('/citas') }}" class="brand-link">
{{--      <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">--}}
      <p class="user brand-text  text-center text-white bree-berif font-italic">
         Dr {{auth()->user()->name}}
      </p>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
     <!-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Alexander Pierce</a>
        </div>
      </div>-->

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        <!--  <li class="nav-item menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./index.html" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dashboard v1</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index2.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dashboard v2</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index3.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dashboard v3</p>
                </a>
              </li>
            </ul>
          </li>-->
        <!--=====================================
                    Botón Pacientes
                  ======================================-->
            <li class="nav-item text-white">
              <a href="{{ url('/pacientes') }}" class="nav-link text-white">
                <i class="nav-icon fas fa-user-injured"></i>

                <p class=>Pacientes</p>
              </a>
            </li>

            <!--=====================================
                    Botón Calendario
                  ======================================-->
            <li class="nav-item text-white">
                <a href="{{ url('/citas') }}" class="nav-link text-white">
                    <i class="nav-icon fas fa-calendar-alt"></i>

                    <p class=>Calendario</p>
                </a>
            </li>

             <!--=====================================
                    Botón Citas Médicas
                  ======================================-->
            <li class="nav-item text-white">
               <a href="{{ url('/citas-crear') }}" class="nav-link text-white">
                   <i class="nav-icon fas fa-hand-holding-medical"></i>

                <p class=>Citas Médicas</p>
              </a>
            </li>

            <!--=====================================
                   Botón Citas Médicas
                 ======================================-->

            @if( $especialñidad =  EspecialidadController::especilidadUser())
                @if($especialñidad->esp_id == 1)
            <li class="nav-item text-white">
                <a href="{{ url('/membrete') }}" class="nav-link text-white" target="_blank">
                    <i class="nav-icon fas fa-sticky-note"></i>

                    <p class=> Hoja Membretada </p>
                </a>
            </li>
                @endif
            @endif

            <li class="nav-item">
                <a href="#" class="nav-link text-white">
                    <i class="nav-icon fas fa-edit"></i>
                    <p>
                        Configuracón
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ url('/historia-clinica-secciones') }}" class="nav-link text-white">
                            <i class="far fa-circle nav-icon"></i>
                            <p> Secciones H C  </p>
                        </a>
                    </li>
                </ul>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ url('/historia-clinica-subsecciones') }}" class="nav-link text-white">
                            <i class="far fa-circle nav-icon"></i>
                            <p> Subsecciones H C  </p>
                        </a>
                    </li>
                </ul>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ url('/historia-clinica-preguntas') }}" class="nav-link text-white">
                            <i class="far fa-circle nav-icon"></i>
                            <p> Preguntas  </p>
                        </a>
                    </li>
                </ul>
            </li>

            <!--=====================================
                   Botón Expedientes
                 ======================================-->
            <li class="nav-item text-white">
                <a href="{{ url('/expediente') }}" class="nav-link text-white">
                    <i class="nav-icon fas fa-file-medical"></i>
                    <p class=>Expedientes</p>
                </a>
            </li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
