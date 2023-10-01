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
?>
  
<div class="card m-4">
  <div class="card-body">
  <h4>Nuevo INVENTARIO</h4>
  <hr>
  <div class="row text-right m-2">
      <div class="col-12">
          <a href="nuevoInventario.php" class="btn btn-primary"><i class="fas fa-fw fa-folder-plus mr-2"></i>Nuevo Empleado</a>
      </div>
  </div>

  <?php
  $sqlClientes = "SELECT * FROM tinventario WHERE estado = 1";
  $queryClientes = mysqli_query($conn, $sqlClientes);


  if (mysqli_num_rows($queryClientes) == 0){
  ?>
  <div calss="row text-center">
      <div class="col-12">
          NO HAY INVENTARIO
      </div>
  </div>
  <?php
  }else{
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