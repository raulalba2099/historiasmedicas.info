<aside class="main-sidebar  elevation-4 background-fuerte">
    <!-- Brand Logo -->
    <div class="text-center">
        <a href="{{url('/')}}" class="brand-link">
       <img src="{{url('/')}}/imgs/logo.gif" alt="logo" width="87px" height="80px">

    </a>
    </div>


    <!-- Sidebar -->
    <div class="sidebar os-host os-theme-light os-host-overflow os-host-overflow-y os-host-resize-disabled os-host-transition os-host-scrollbar-horizontal-hidden"><div class="os-resize-observer-host observed"><div class="os-resize-observer" style="left: 0px; right: auto;"></div></div><div class="os-size-auto-observer observed" style="height: calc(100% + 1px); float: left;"><div class="os-resize-observer"></div></div><div class="os-content-glue" style="margin: 0px -8px; width: 249px; height: 699px;"></div><div class="os-padding"><div class="os-viewport os-viewport-native-scrollbars-invisible" style="overflow-y: scroll;"><div class="os-content" style="padding: 0px 8px; height: 100%; width: 100%;">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info liga-clara ml-3">
          <a href="#" class="d-block text-white">Eduardo Mártinez</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
   <!--  <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>

      </div> -->

         <!-- Sidebar Menu -->
      <nav class="mt-2">

        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
           <!--=====================================
                    Botón Pacientes
                  ======================================-->
            <li class="nav-item text-white">
              <a href="{{ url("/pacientes") }}" class="nav-link">
                <i class="nav-icon fas fa-user-injured"></i>

                <p class=>Pacientes</p>
              </a>
            </li>

             <!--=====================================
                    Botón Citas Médicas
                  ======================================-->
            <li class="nav-item text-white">
              <a href="{{ url("/citas") }}" class="nav-link">
                <i class="nav-icon fas fa-calendar-alt"></i>

                <p class=>Citas Médicas</p>
              </a>
            </li>

              <!--=====================================
                    Botón Expedientes
                  ======================================-->
            <li class="nav-item text-white">
              <a href="{{ url("/") }}" class="nav-link">
              <i class="nav-icon fas fa-file-medical"></i>
                <p class=>Expedientes</p>
              </a>
            </li>

             <!--=====================================
                    Botón Reportes
                  ======================================-->
            <li class="nav-item text-white">
              <a href="{{ url("/") }}" class="nav-link">
             <i class="nav-icon fas fa-notes-medical"></i>
                <p class=>Reportes</p>
              </a>
            </li>

        </ul>

     </nav>
    </div></div></div><div class="os-scrollbar os-scrollbar-horizontal os-scrollbar-auto-hidden os-scrollbar-unusable"><div class="os-scrollbar-track"><div class="os-scrollbar-handle" style="width: 100%; transform: translate(0px, 0px);"></div></div></div><div class="os-scrollbar os-scrollbar-vertical os-scrollbar-auto-hidden"><div class="os-scrollbar-track"><div class="os-scrollbar-handle" style="height: 51.5085%; transform: translate(0px, 0px);"></div></div></div><div class="os-scrollbar-corner"></div></div>
    <!-- /.sidebar -->
  </aside>
