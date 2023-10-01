<?php 
include("../../conn/conn.php");

revisarPrivilegio(4);

if (isset($_GET['id_eliminar'])){
    $idEliminar = $_GET['id_eliminar'];

    $sqlEliminar = "UPDATE tinventario SET estado = 2 WHERE id = '$idEliminar'";
    $queryEliminar = mysqli_query($conn, $sqlEliminar);

    header('location: inventario.php');
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
  <h4>NUEVO INVENTARIO</h4>
  <hr>
  <div class="row text-right m-2">
      <div class="col-12">
          <a href="nuevoInventario.php" class="btn btn-primary"><i class="fas fa-fw fa-folder-plus mr-2"></i>Nuevo Inventario</a>
      </div>
  </div>

<!-- Formulario de búsqueda por nombre y/o fechas -->
<form method="POST" action="" class="text-center">
    <div class="row m-2">
        <div class="col-3">
            <label for="nombre" class="animate__animated animate__slideInLeft"><i class="fas fa-fw fa-user animate__animated animate__slideInLeft"></i> Nombre:</label>
            <input type="text" id="nombre" name="nombre" class="form-control shadow-sm animate__animated animate__zoomIn">
        </div>
        <div class="col-3">
            <label for="fecha_inicio" class="animate__animated animate__slideInLeft"><i class="fas fa-fw fa-calendar-alt animate__animated animate__slideInLeft"></i> Fecha de inicio:</label>
            <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control shadow-sm animate__animated animate__zoomIn">
        </div>
        <div class="col-3">
            <label for="fecha_fin" class="animate__animated animate__slideInLeft"><i class="fas fa-fw fa-calendar-alt animate__animated animate__slideInLeft"></i> Fecha de fin:</label>
            <input type="date" id="fecha_fin" name="fecha_fin" class="form-control shadow-sm animate__animated animate__zoomIn">
        </div>
        <div class="col-3">
            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Buscar</button>
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
  <table class="table table-sm table-striped">
      <thead class="bg-dark text-light">
          <th></th>
          <th>Nombre</th>
          <th>Fecha</th>
          <th>Descripcion</th>
      </thead>

      <tbody>
          <?php
          while($rowClientes=mysqli_fetch_array($queryClientes)){
            ?>
            <tr>
                <td>
                    <a href="editarInventario.php?id_editar=<?=$rowClientes['id']?>" class="btn btn-secondary"><i class="fa fa-fw fa-pen"></i></a>
                    <!-- Agrega el SweetAlert2 -->
                    <a href="#" class="btn btn-danger delete-btn" data-id="<?=$rowClientes['id']?>"><i class="fas fa-fw fa-trash"></i></a>
                <td><?=$rowClientes['nombre']?></td>
                <td><?=$rowClientes['fecha']?></td>
                <td><?=$rowClientes['descripcion']?></td>
            </tr>
            <?php
          }
          ?>
      </tbody>
  </table>

  <script>
    // Agrega un evento click a todos los botones de eliminar
    const deleteButtons = document.querySelectorAll(".btn-danger");
    deleteButtons.forEach(function(deleteButton) {
      deleteButton.addEventListener("click", function(event) {
        // Previene el comportamiento predeterminado del enlace
        event.preventDefault();
        
        // Obtiene el ID del cliente a eliminar
        const idEliminar = this.dataset.id;
        
        // Muestra un mensaje de confirmación con SweetAlert2
        Swal.fire({
          title: '¿Está seguro(a) que desea eliminar?',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Sí, eliminar!',
          cancelButtonText: 'Cancelar'
        }).then((result) => {
          // Si el usuario hace clic en "Sí, eliminar!", redirige a la página de eliminación
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
