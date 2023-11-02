<?php 
//Donde veamos estos includes, es referente a partes del proyecto que se mostraran por todo el sistema
include("../../conn/conn.php");
revisarPrivilegio(4);
$idProyecto = isset($_GET['id_proyecto']) ? $_GET['id_proyecto'] : '';
$idProyectoEncriptado = base64_encode($idProyecto);
if (isset($_GET['id_proyecto'])) {
    // Recupera el ID del proyecto desde la URL y desencripta usando base64_decode
    $idProyectoEncriptado = $_GET['id_proyecto'];
    $idProyecto = base64_decode($idProyectoEncriptado);
}
//Aqui realizamos el metodo para eliminar el campo correspondiente
if (isset($_GET['id_eliminar'])){
    $idEliminar = $_GET['id_eliminar'];

    $sqlEliminar = "UPDATE tinventario SET estado = 2 WHERE id = '$idEliminar'";
    $queryEliminar = mysqli_query($conn, $sqlEliminar);

    header("location: inventario.php?id_proyecto=$idProyecto");
    exit();
}

include("../../template/top.php");

// Inicializa la variable $queryClientes
$queryClientes = null;

// Consulta inicial para mostrar todos los registros
$sqlClientes = "SELECT * FROM tinventario WHERE estado = 1";
$queryClientes = mysqli_query($conn, $sqlClientes);
?>

<div class="card m-4">
  <div class="card-body">
  <h5>Inventario</h5>
  <hr>
  <div class="row text-right">
      <div class="col-12">
          <a href="NI.php?id_proyecto=<?=urlencode($idProyectoEncriptado)?>" class="btn btn-sm btn-dark"><i class="fas fa-fw fa-folder-plus"></i> Nuevo Inventario</a>
      </div>
  </div>

<!-- Formulario de búsqueda por nombre y/o fechas -->
<form method="POST" action="" class="">
  <div class="row mb-3">
        <div class="col-md-3">
            <h6>Nombre</h6>
            <input type="text" id="nombre" placeholder="Buscar por nombre" name="nombre" class="form-control shadow-sm animate__animated animate__zoomIn">
        </div>
        <div class="col-md-3">
            <h6>Fecha Inicial</h6>
            <input type="date" id="fecha_inicio" placeholder="Buscar por fecha inicial" name="fecha_inicio" class="form-control shadow-sm animate__animated animate__zoomIn">
        </div>
        <div class="col-md-3">
            <h6>Fecha Final</h6>
            <input type="date" id="fecha_fin" name="fecha_fin" class="form-control shadow-sm animate__animated animate__zoomIn">
        </div>
        <div class="col-md-3">
            <hr>
            <button type="submit" class="btn btn-sm btn-dark"><i class="fas fa-search"></i> Buscar</button>
        </div>
  </div>
</form>

  <?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $nombre = $_POST['nombre'];
      $fecha_inicio = $_POST['fecha_inicio'];
      $fecha_fin = $_POST['fecha_fin'];

      // Construye la consulta SQL basada en los campos completados
      $sqlClientes = "SELECT * FROM tinventario WHERE estado = 1";

      if (!empty($nombre)) {
          $sqlClientes .= " AND nombre LIKE '%$nombre%'";
      }

      if (!empty($fecha_inicio) && !empty($fecha_fin)) {
          $sqlClientes .= " AND fecha BETWEEN '$fecha_inicio' AND '$fecha_fin'";
      }

      $queryClientes = mysqli_query($conn, $sqlClientes);
  }
  
  if (!$queryClientes) {
    echo '<div class="row text-center">
              <div class="col-12">
                  NO HAY INVENTARIO
              </div>
          </div>';
  } else if (mysqli_num_rows($queryClientes) == 0) {
      echo '<div class="row text-center">
                <div class="col-12">
                    NO HAY INVENTARIO
                </div>
            </div>';
  } else {
  ?>
  <div class="table-responsive">
    <table class="table table-sm table-striped table-bordered">
        <thead class="text-dark">
            <th>Acciones</th>
            <th>Nombre</th>
            <th>Fecha</th>
            <th>Descripcion</th>
        </thead>

        <tbody>
            <?php
            while($rowClientes=mysqli_fetch_array($queryClientes)){
              ?>
              <tr>
                <td style="min-width:150px">
                  <a href="EI.php?id_editar=<?=$rowClientes['id']?>" class="btn btn-sm btn-outline-info"><i class="fa fa-fw fa-edit"></i></a>
                  <a href="#" class="btn btn-sm btn-danger delete-btn" data-id="<?=$rowClientes['id']?>"><i class="fas fa-fw fa-trash"></i></a>
                <td><?=$rowClientes['nombre']?></td>
                <td><?=$rowClientes['fecha']?></td>
                <td><?=$rowClientes['descripcion']?></td>
              </tr>
              <?php
            }
            ?>
        </tbody>
    </table>
  </div>

  <script>
    // Agrega un evento click a todos los botones de eliminar
    const deleteButtons = document.querySelectorAll(".btn-danger");
    deleteButtons.forEach(function(deleteButton) {
      deleteButton.addEventListener("click", function(event) {
        event.preventDefault();
        const idEliminar = this.dataset.id;
        Swal.fire({
          title: '¿Está seguro(a) que desea eliminar el inventario?',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Sí, eliminar!',
          cancelButtonText: 'Cancelar'
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.href = `inventario.php?id_eliminar=${idEliminar}`;
          }
        });
      });
    });
  </script>
  <?php
  }
  ?>
</div>
</div>
<?php 
include("../../template/bottom.php");
?>
