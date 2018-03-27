    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Concepcion Servicios <small>S.A.</small></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#">Dashboard</a></li>
            <li><a href="#">Settings</a></li>
            <li><a href="<?php echo base_url()."auth/"?>">Inicio</a></li>
            <li><a href="<?php echo base_url()."auth/logout"?>">Salir <span class="glyphicon glyphicon glyphicon-log-out" aria-hidden="true"></span> </a></li>
          </ul>
          <form class="navbar-form navbar-right">
            <input type="text" class="form-control" placeholder="Search...">
            <!--
            <select id="searcher" class="form-control">
              <option value=''>Buscar...</option>
              <option value='EmpreListado'>Empresa Listado</option>
              <option value='EmpreAdd'>Empresa Agregar</option>
            </select>
            -->
          </form>
        </div>
      </div>
    </nav>