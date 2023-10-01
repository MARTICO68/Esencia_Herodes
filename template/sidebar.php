<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
<!-- Agrega la librería de SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<style>
.nav-item {
  border: 1px solid #ccc;
  border-radius: 5px;
  box-shadow: 2px 2px 5px #ccc;
  transition: all 0.2s ease-in-out;
}

.nav-item:hover {
  transform: translateY(-5px);
  box-shadow: 4px 4px 10px #ccc;
}

.nav-item.selected {
  background-color: #ccc;
}

.nav-item.hovered {
  box-shadow: 4px 4px 10px #ccc;
  transform: translateY(-5px);
}
</style>
<style>
    /* Estilos para la tabla */
    table {
        font-family: Arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
        margin: 20px 0;
    }
    th, td {
        text-align: left;
        padding: 8px;
    }
    th {
        background-color: #4CAF50;
        color: white;
    }
    tr:nth-child(even) {
        background-color: #f2f2f2;
    }
    /* Estilos para los botones */
    .btn {
        background-color: #008CBA;
        color: white;
        border: none;
        padding: 6px 12px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 14px;
        margin: 4px 2px;
        cursor: pointer;
        border-radius: 4px;
    }
    .btn-danger {
        background-color: #f44336;
    }
</style>
<head>
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
  />
</head>

<style>
  /* Style for navigation links */
  .nav-item {
    margin-bottom: 10px;
  }
  .nav-link {
    color: #fff;
    font-size: 16px;
    font-weight: bold;
    text-decoration: none;
    padding: 10px;
    display: block;
    background-color: #333;
    border-radius: 5px;
  }
  .nav-link:hover {
    background-color: #555;
  }
  .nav-link i {
    margin-right: 10px;
  }
  .nav-link span {
    vertical-align: middle;
  }
</style>

<!-- Sidebar navigation -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
  <img src="<?php echo $baseURL?>img/logo2.png" height="70px">
</a>
<hr class="sidebar-divider my-0">

<ul class="nav flex-column">
  <li class="nav-item active">
    <a class="nav-link" href="<?php echo $baseURL?>index.php">
      <i class="fas fa-fw fa-laptop-house"></i>
      <span>Inicio</span>
    </a>
  </li>

  <?php 
  // Loop through privileges and generate navigation links
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
</ul>
</ul>

<!-- End of Sidebar -->