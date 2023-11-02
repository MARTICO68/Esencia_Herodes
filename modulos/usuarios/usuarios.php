<?php 
include('../../conn/conn.php');
revisarPrivilegio(3);
if (isset($_GET['id_eliminar'])){
    $idEliminar = $_GET['id_eliminar'];

    $sqlEliminar = "UPDATE tusuarios SET estado = 2 WHERE id = '$idEliminar'";
    $queryEliminar = mysqli_query($conn, $sqlEliminar);

    header('location: usuarios.php');
    exit();
}


if (isset($_GET['id_cerrar'])){
    $idCerrar = $_GET['id_cerrar'];

    $codigoAleatorio = rand(100000000, 99999999);

    $sqlCerrar = "UPDATE tusuarios SET codigo = '$codigoAleatorio' WHERE id = '$idCerrar'";
    $queryCerrar = mysqli_query($conn, $sqlCerrar);

    header('location: usuarios.php');
    exit();
}

include('../../template/top.php');
?>
<div class="card m-4">
    <div class="card-body">
    <h5>Usuarios</h5>
    <hr>
    <div class="row text-right">
    <div class="col-12 mb-4">
        <a href="NU.php" class="btn btn-sm btn-dark"><i class="fas fa-fw fa-plus"></i> Nuevo Usuario</a>
    </div>
</div>


<?php 
$sqlCliente = "SELECT * FROM tusuarios WHERE estado = 1";
$queryCliente = mysqli_query($conn, $sqlCliente);

if (mysqli_num_rows($queryCliente) == 0){
?>
<div class="row text-center">
    <div class="col-12">
        No hay usuarios para mostrar.
    </div>
</div>
<?php 
}else{
?>
<div class="table-responsive">
<table class="table table-sm table-striped table-bordered">
    <thead class="text-dark">
        <th>Acciones</th>
        <th>Nombre</th>
        <th>Usuario</th> 
    </thead>
    <tbody>
        <?php 
        while($rowCliente=mysqli_fetch_array($queryCliente)){
            ?>
            <tr>
                <td style="min-width:150px">
                    <a href="EU.php?id_editar=<?=$rowCliente['id']?>" class="btn btn-sm btn-outline-info"><i class="fa fa-fw fa-edit"></i></a>
                    <a href="usuarios.php?id_eliminar=<?=$rowCliente['id']?>" onclick="return confirm('¿Está seguro(a) que desea eliminar?')" class="btn btn-sm btn-danger"><i class="fas fa-fw fa-trash"></i></a>
                    <a href="usuarios.php?id_cerrar=<?=$rowCliente['id']?>" class="btn btn-sm btn-outline-secondary" onclick="return confirm('¿Está seguro que desea cerrar la sesión de este usuario?')"><i class="fas fa-fw fa-lock"></i></a>
                </td>
                <td><?=$rowCliente['nombre']?></td>
                <td><?=$rowCliente['usuario']?></td>
            </tr>
            <?php 
        }
        ?>
    </tbody>
</table>
</div>
<?php
}

?>
    </div>
</div>
<?php 
include('../../template/bottom.php');
?>