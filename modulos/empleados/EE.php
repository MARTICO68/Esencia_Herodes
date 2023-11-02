<?php 
//Donde veamos estos includes, es referente a partes del proyecto que se mostraran por todo el sistema 
include('../../conn/conn.php');
revisarPrivilegio(4);
$idEditar = 0;
if (isset($_GET['id_editar'])){
    $idEditar = $_GET['id_editar'];
}
//Aqui realizamos el metodo para actualizar los datos en la BD
if (isset($_POST['guardar'])){
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

    ?>
    <script>
        alert('El Empleado fue Editado exitosamente.');
        document.location.href = 'empleados.php';
    </script>
    <?php
    exit();
}

include('../../template/top.php');
?>
<div class="card m-4">
    <div class="card-body">
        <h5>Editar Empleado</h5>
        <hr>
        <div class="row text-right">
            <div class="col-12">
                <a href="empleados.php" class="btn btn-sm btn-dark"><i class="fas fa-fw fa-arrow-left"></i> Regresar</a>
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
                                <label for="identificacion" class="animate__animated animate__slideInLeft"></i> Identificación:</label>
                                <input type="text" id="identificacion" autocomplete="off" value="<?=$rowEditar['identificacion']?>" name="identificacion" class="form-control shadow-sm animate__animated animate__zoomIn">

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <label for="nombre" class="animate__animated animate__slideInLeft"></i> Nombre:</label>
                                <input type="text" id="nombre" autocomplete="off" required type="text" value="<?=$rowEditar['nombre']?>" name="nombre" class="form-control shadow-sm animate__animated animate__zoomIn">
                            </div>
                    
                            <div class="col-md-6">
                                <label for="apellidos" class="animate__animated animate__slideInLeft"></i> Apellidos:</label>
                                <input type="text" id="apellidos" autocomplete="off" required type="text" value="<?=$rowEditar['apellidos']?>" name="apellidos" class="form-control shadow-sm animate__animated animate__zoomIn">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <label for="puesto" class="animate__animated animate__slideInLeft"></i> Puesto:</label>
                                <input type="text" id="puesto" autocomplete="off" required type="text" value="<?=$rowEditar['puesto']?>" name="puesto" class="form-control shadow-sm animate__animated animate__zoomIn">
                            </div>
                        
                            <div class="col-md-6">
                                <label for="telefono" class="animate__animated animate__slideInLeft"></i> Teléfono: </label>
                                <input type="text" id="telefono" autocomplete="off" required type="text" value="<?=$rowEditar['telefono']?>" name="telefono" class="form-control shadow-sm animate__animated animate__zoomIn">
                            </div>
                        </div>
                        <br>
                        <div class="row text-center m-4">
                            <div class="col-12">
                                <button type="submit" class="btn btn-dark btn-sm animate__animated animate__zoomIn" name="guardar"><i class="fas fa-fw fa-save"></i> Guardar</button>
                                <hr>
                            </div>
                        </div>  
                    </form>           
                    <?php } ?>

            </div>
        <div class="col-12 col-md-6 text-center">                                                        
            <img class="img-fluid" src="<?=$baseURL?>img/user.gif" height="550px"><br>                                           
        </div>
    </div>
</div>
<?php 
include('../../template/bottom.php');
?>