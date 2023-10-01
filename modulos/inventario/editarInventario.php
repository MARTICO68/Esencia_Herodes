<?php
include('../../conn/conn.php');
include('../../template/top.php');
revisarPrivilegio(4);
$idEditar = 0;

if (isset($_GET['id_editar'])){
    $idEditar = $_GET['id_editar'];
}

if (isset($_POST['guardar'])){
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $fecha = $_POST['fecha'];
    $descripcion = $_POST['descripcion'];

    // Realiza la actualización en la base de datos
    $sqlActualizar = "UPDATE tinventario SET
        nombre = '$nombre',
        fecha = '$fecha',
        descripcion = '$descripcion'
        WHERE id = '$id'";
    $queryActualizar = mysqli_query($conn, $sqlActualizar);

    if ($queryActualizar) {
        // La actualización fue exitosa, muestra una alerta de confirmación
        echo '<script>
            Swal.fire({
                title: "Registro modificado exitosamente",
                icon: "success",
                confirmButtonText: "OK"
            }).then(() => {
                window.location.href = "inventario.php";
            });
        </script>';
    } else {
        // Hubo un error en la actualización, muestra una alerta de error
        echo '<script>
            Swal.fire({
                title: "Error al modificar el registro",
                text: "Hubo un problema al actualizar los datos. Por favor, inténtelo de nuevo.",
                icon: "error",
                confirmButtonText: "OK"
            });
        </script>';
    }
}
?>

<div class="card m-4">
    <div class="card-body">
        <h4>Editar Empleado</h4>
        <hr>
        <div class="row text-right">
            <div class="col-12">
                <a href="inventario.php" class="btn btn-primary"><i class="fas fa-fw fa-arrow-left"></i> Regresar</a>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-md-6">
                <?php 
                $sqlEditar = "SELECT * FROM tinventario WHERE id = '$idEditar'";
                $queryEditar = mysqli_query($conn, $sqlEditar);
                while($rowEditar=mysqli_fetch_array($queryEditar)){
                ?>

                <form class="user" action="" method="post">
                    <input type="hidden" value="<?=$rowEditar['id']?>" name="id">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="nombre" class="animate__animated animate__slideInLeft"><i class="fas fa-fw fa-user animate__animated animate__slideInLeft"></i> Nombre:</label>
                            <input type="text" id="nombre" value="<?=$rowEditar['nombre']?>" name="nombre" class="form-control shadow-sm animate__animated animate__zoomIn">
                        </div>
                        <div class="col-md-6">
                            <label for="fecha" class="animate__animated animate__slideInLeft"><i class="far fa-fw fa-user-circle animate__animated animate__slideInLeft"></i> Fecha:</label>
                            <input type="date" id="fecha" value="<?=$rowEditar['fecha']?>" name="fecha" class="form-control shadow-sm animate__animated animate__zoomIn">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="descripcion" class="animate__animated animate__slideInLeft"><i class="far fa-fw fa-user-circle animate__animated animate__slideInLeft"></i> Descripcion:</label>
                            <input type="text" id="descripcion" value="<?=$rowEditar['descripcion']?>" name="descripcion" class="form-control shadow-sm animate__animated animate__zoomIn">
                        </div>
                    </div>

                    <div class="row text-center m-4">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-user" name="guardar"><i class="fas fa-fw fa-check"></i> Guardar</button>
                            <hr>
                        </div>
                    </div>
                </form>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<?php include('../../template/bottom.php'); ?>
