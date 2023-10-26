<?php
include("../../conn/conn.php");

revisarPrivilegio(4);

if (isset($_GET['id_eliminar'])){
    $idEliminar = $_GET['id_eliminar'];

    $sqlEliminar = "UPDATE tproyectos SET estado = 2 WHERE id = '$idEliminar'";
    $queryEliminar = mysqli_query($conn, $sqlEliminar);

    header('location: proyectos.php');
    exit();
}

include("../../template/top.php");
?>

<div class="card m-4">
  <div class="card-body">
    <h4>Nuevo Proyecto</h4>
    <hr>
    <div class="row text-right m-2">
      <div class="col-12">
        <a href="nuevoproyectos.php" class="btn btn-primary"><i class="fas fa-fw fa-folder-plus mr-2"></i>Nuevo Proyecto</a>
      </div>
    </div>

    <?php
    $sqlClientes = "SELECT * FROM tproyectos WHERE estado = 1";
    $queryClientes = mysqli_query($conn, $sqlClientes);

    if (mysqli_num_rows($queryClientes) == 0){
    ?>
    <div class="row text-center">
      <div class="col-12">
        NO hay Proyectos
      </div>
    </div>
    <?php
    } else {
    ?>
    <div class="table-responsive">
      <table class="table table-sm table-striped table-bordered">
        <thead class="bg-dark text-light">
          <th></th>
          <th>Nombre</th>
          <th>Descripción</th>
          <th>Fecha inicial</th>
          <th>Fecha de finalización</th>
        </thead>
        <tbody>
          <?php
          while($rowClientes = mysqli_fetch_array($queryClientes)){
            
            ?>
            <tr>
              <td style="min-width:150px">
                <a href="editarProyectos.php?id_proyecto=<?= $rowClientes['id'] ?>" class="btn-sm btn btn-outline-dark"><i class="fa fa-fw fa-edit"></i></a>
                <!-- Agrega el SweetAlert2 -->
                <a href="#" class="btn-sm btn btn-danger" data-id="<?= $rowClientes['id'] ?>"><i class="fas fa-fw fa-trash"></i></a>
                <a href="administracion.php?id_proyecto=<?= $rowClientes['id'] ?>" class="btn-sm btn btn-outline-success"><i class="fas fa-fw fa-folder"></i></a>
              </td>
              <td><?= $rowClientes['nombre'] ?></td>
              <td><?= $rowClientes['descripcion'] ?></td>
              <td><?= $rowClientes['fechaini'] ?></td>
              <td><?= $rowClientes['fechafin'] ?></td>
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
              window.location.href = `proyectos.php?id_eliminar=${idEliminar}`;
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

<div class="card m-4">
  <div class="card-body">
    <h4>Gastos e Ingresos por Proyecto</h4>
    <hr>
    <div class="table-responsive">
      <table id="tabla-proyectos" class="table table-sm table-striped table-bordered">
        <thead class="bg-dark text-light">
          <th>Proyecto</th>
          <th>Total Gastos</th>
          <th>Total Ingresos</th>
          <th>Subtotal</th>
        </thead>
        <tbody>
          <!-- Aquí se llenarán los datos con JavaScript y AJAX -->
        </tbody>
      </table>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  function actualizarTabla() {
    $.ajax({
      type: 'GET',
      url: 'actualizarDatos.php', // URL del archivo PHP que devuelve los datos actualizados
      dataType: 'json',
      success: function (data) {
        // Limpia la tabla actual
        $('#tabla-proyectos tbody').empty();

        // Recorre los datos y actualiza la tabla
        $.each(data, function (index, proyecto) {
          $('#tabla-proyectos tbody').append(
            '<tr>' +
            '<td>' + proyecto.nombre + '</td>' +
            '<td>' + proyecto.totalGastos + '</td>' +
            '<td>' + proyecto.totalIngresos + '</td>' +
            '<td>' + proyecto.subtotal + '</td>' +
            '</tr>'
          );
        });
      }
    });
  }

  // Llama a la función para actualizar la tabla cuando se carga la página y cada 60 segundos
  $(document).ready(function () {
    actualizarTabla();
    setInterval(actualizarTabla, 60000); // Actualizar cada 60 segundos
  });
</script>

<?php
include("../../template/bottom.php");
?>

