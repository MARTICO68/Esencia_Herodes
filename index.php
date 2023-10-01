<?php 
include("conn/conn.php");
$titulo = "Dashboard";
include("template/top.php"); ?>



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

<script>
$(document).ready(function() {
  $('.nav-item').on('click', function() {
    $(this).addClass('selected');
    $(this).siblings().removeClass('selected');
  });

  $('.nav-item').on('mouseover', function() {
    $(this).addClass('hovered');
  });

  $('.nav-item').on('mouseout', function() {
    $(this).removeClass('hovered');
  });
});
</script>

<?php include("template/bottom.php"); ?>
                    