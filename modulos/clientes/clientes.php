<?php 
include("../../conn/conn.php");
revisarPrivilegio(4);

if (isset($_GET['id_eliminar'])){
    $idEliminar = $_GET['id_eliminar'];

    $sqlEliminar = "UPDATE tclientes SET estado = 2 WHERE id = '$idEliminar'";
    $queryEliminar = mysqli_query($conn, $sqlEliminar);

    header('location: clientes.php');
    exit();
}

$titulo = "Clientes";
include("../../template/top.php");
?>

<div class= "row text-right m-2">
    <div class="col-12">
        <a href="nuevoCliente.php" class="btn btn-primary"><i class="fas fa-fw fa-folder-plus"></i>Nuevo Cliente</a>
    </div>
</div>

<?php
$sqlClientes = "SELECT * FROM tclientes WHERE estado = 1";
$queryClientes = mysqli_query($conn, $sqlClientes);


if (mysqli_num_rows($queryClientes) == 0){
?>
<div calss="row text-center">
    <div class="col-12">
        NO HAY Clientes
    </div>
</div>
<?php
}else{
?>
<table class="table table-sm table-striped">
    <thead class="bg-dark text-light">
        <th></th>
        <th>Identificación</th>
        <th>Nombre</th>
        <th>Apellidos</th>
        <th>Telefono</th>
        <th>Email</th>
    </thead>

    <tbody>
        <?php
        while($rowClientes=mysqli_fetch_array($queryClientes)){
          ?>
          <tr>
              <td>
                  <a href="editarClientes.php?id_editar=<?=$rowClientes['id']?>" class="btn btn-secondary"><i class="fa fa-fw fa-pen"></i></a>
                  <a href="Clientes.php?id_eliminar=<?=$rowClientes['id']?>" onclick="return confirm('¿Está seguro(a) que desea eliminar?')" class="btn btn-danger"><i class="fas fa-fw fa-trash"></i></a>
              </td>
              <td><?=$rowClientes['identificacion']?></td>
              <td><?=$rowClientes['nombre']?></td>
              <td><?=$rowClientes['apellidos']?></td>
              <td><?=$rowClientes['telefono']?></td>
              <td><?=$rowClientes['email']?></td> 
          </tr>
          <?php
        }
        ?>
    </tbody>
</table>

<?php


}

?>

<?php 
include("../../template/bottom.php");
?>