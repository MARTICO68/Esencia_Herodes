<?php
include('../../conn/conn.php');
include('../../template/top.php');
revisarPrivilegio(4);
$idEditar = 0;
if (isset($_GET['id_editar'])) {
    $idEditar = $_GET['id_editar'];
}

if (isset($_POST['guardar'])) {
    $id = $_POST['id'];
    $identificacion = $_POST['identificacion'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $puesto = $_POST['puesto'];
    $telefono = $_POST['telefono'];

    $sqlClientes = "UPDATE templeados SET 
    identificacion = '$identificacion',
    nombre = '$nombre',
    apellidos = '$apellidos',
    puesto = '$puesto',
    telefono = '$telefono'
    WHERE id = '$id'";
    $queryClientes = mysqli_query($conn, $sqlClientes);

    if ($queryClientes) {
        ?>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script>
            swal({
                title: "Éxito",
                text: "El empleado fue editado exitosamente.",
                icon: "success",
            }).then(function () {
                window.location.href = 'empleados.php';
            });
        </script>
        <?php
        exit();
    }
}
?>



<div class="card m-4">
    <div class="card-body">
    <h4>Editar Empleado</h4>
    <hr>
    <div class="row text-right">
        <div class="col-12">
            <a href="empleados.php" class="btn btn-primary"><i class="fas fa-fw fa-arrow-left"></i> Regresar</a>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-md-6">

        <?php 
            $sqlEditar = "SELECT * FROM templeados WHERE id = '$idEditar'";
            $queryEditar = mysqli_query($conn, $sqlEditar);
            while($rowEditar=mysqli_fetch_array($queryEditar)){
            ?>

            <form class="user" action="" method="post">

                <input type="hidden" value="<?=$rowEditar['id']?>" name="id">

                <div class="row">
                    <div class="col-6">
                        <label for="identificacion" class="animate__animated animate__slideInLeft" ><i class="fas fa-fw fa-id-card animate__animated animate__slideInLeft"></i> Identificación:</label>
                        <input type="text" id="identificacion" value="<?=$rowEditar['identificacion']?>" name="identificacion" class="form-control shadow-sm animate__animated animate__zoomIn">

                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label for="nombre" class="animate__animated animate__slideInLeft"><i class="fas fa-fw fa-user animate__animated animate__slideInLeft"></i> Nombre:</label>
                        <input type="text" id="nombre" value="<?=$rowEditar['nombre']?>" name="nombre" class="form-control shadow-sm animate__animated animate__zoomIn">
                    </div>
              
                    <div class="col-md-6">
                        <label for="apellidos" class="animate__animated animate__slideInLeft"><i class="far fa-fw fa-user-circle animate__animated animate__slideInLeft"></i> Apellidos:</label>
                        <input type="text" id="apellidos" value="<?=$rowEditar['apellidos']?>" name="apellidos" class="form-control shadow-sm animate__animated animate__zoomIn">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label for="puesto" class="animate__animated animate__slideInLeft"><i class="far fa-fw fa-user-circle animate__animated animate__slideInLeft"></i> Puesto:</label>
                        <input type="text" id="puesto" value="<?=$rowEditar['puesto']?>" name="puesto" class="form-control shadow-sm animate__animated animate__zoomIn">
                    </div>
                
                    <div class="col-md-6">
                        <label for="telefono" class="animate__animated animate__slideInLeft"><i class="fas fa-fw fa-phone animate__animated animate__slideInLeft"></i> Teléfono: </label>
                        <input type="text" id="telefono" value="<?=$rowEditar['telefono']?>" name="telefono" class="form-control shadow-sm animate__animated animate__zoomIn">
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
<?php 
include('../../template/bottom.php');
?>