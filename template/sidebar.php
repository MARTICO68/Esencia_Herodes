<!-- Sidebar -->
<link href="<?=$baseURL?>css/sb-admin-2.min.css" rel="stylesheet">
<ul class="navbar-nav  sidebar sidebar-dark accordion" style="background-color:#292929" id="accordionSidebar">
<!-- Agrega la librería de SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="modals.css">

<!-- Sidebar navigation -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?php echo $baseURL?>index.php">
    <div class="sidebar-brand-icon rotate-n-15">
        <i class="fas fa-laugh-wink"></i>
    </div>
    <div class="sidebar-brand-text mx-3">Esencia Herodes</div>
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<ul class="nav flex-column" >
  <li class="nav-item active">
    <a class="nav-link" href="<?php echo $baseURL?>index.php">
      <i class="fas fa-fw fa-laptop-house"></i>
      <span>Inicio</span>
    </a>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider">

  <!-- Heading -->
  <div class="sidebar-heading">
      Interfaz
  </div>

  <?php 
  // Aqui generamos que se pueda agregar los privilegios para el sistema
  $sqlPrivilegios = "SELECT * FROM tprivilegios WHERE estado = 1 ORDER BY nombre";
  $queryPrivilegios = mysqli_query($conn, $sqlPrivilegios);

  while($rowPrivilegios = mysqli_fetch_array($queryPrivilegios)){
      $sqlPU = "SELECT * FROM tprivilegiosusuario WHERE idUsuario = '$idUsuario' AND idPrivilegio = '".$rowPrivilegios['id']."'";
      $queryPU = mysqli_query($conn, $sqlPU);
      if (mysqli_num_rows($queryPU) == 1){
  ?>
  <li class="nav-item">
    <a class="nav-link" href="<?=$baseURL.$rowPrivilegios['url']?>">
      <i class="fas fa-fw fa-<?=$rowPrivilegios['icono']?>"></i>
      <span><?=$rowPrivilegios['nombre']?></span>
    </a>
  </li>
  <?php 
      }
  }
  ?>
  <!-- Divider -->
  <hr class="sidebar-divider">

  <!-- Divider -->
  <hr class="sidebar-divider d-none d-md-block">

  <!-- Sidebar Toggler (Sidebar) -->
  <div class="text-center d-none d-md-inline">
      <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>
  </ul>
</ul>
</ul>

<!-- End of Sidebar -->