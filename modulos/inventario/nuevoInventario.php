<?php 
include("../../conn/conn.php");
include("../../template/top.php");
revisarPrivilegio(4);
if (isset($_POST['guardar'])){
    $identificacion = $_POST['identificacion'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $puesto = $_POST['puesto'];
    $telefono = $_POST['telefono'];

    $sqlClientes = "INSERT INTO templeados 
    (identificacion, nombre, apellidos, puesto, telefono, estado) VALUES 
    ('$identificacion', '$nombre', '$apellidos', '$puesto', '$telefono', 1)";
    $queryClientes = mysqli_query($conn, $sqlClientes);

    ?>
    <script>
        alert('El cliente fue guardado exitosamente.');
        document.location.href = 'empleados.php';
    </script>
    <?php 
    exit();
}

?>

<div class="card m-4">
    <div class="card-body">
    <h4>Nuevo Empleado</h4>
    <hr>
    
    <div class= "row text-right" class="user">
        <div class="col-12">
            <a href="empleados.php" class="btn btn-primary btn-user"><i class="fas fa-fw fa-arrow-left mr-2"></i>Regresar</a>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-md-6">
            <form class="user" action="" method="post">

                <div class="row">
                    <div class="col-md-6">
                        <label for="identificacion" class="animate__animated animate__slideInLeft" ><i class="fas fa-fw fa-id-card animate__animated animate__slideInLeft"></i> Identificación:</label>
                        <input type="text" id="identificacion" name="identificacion" class="form-control shadow-sm animate__animated animate__zoomIn">

                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label for="nombre" class="animate__animated animate__slideInLeft"><i class="fas fa-fw fa-user animate__animated animate__slideInLeft"></i> Nombre:</label>
                        <input type="text" id="nombre" name="nombre" class="form-control shadow-sm animate__animated animate__zoomIn">
                    </div>
                

                
                    <div class="col-md-6">
                        <label for="apellidos" class="animate__animated animate__slideInLeft"><i class="far fa-fw fa-user-circle animate__animated animate__slideInLeft"></i> Apellidos:</label>
                        <input type="text" id="apellidos" name="apellidos" class="form-control shadow-sm animate__animated animate__zoomIn">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label for="puesto" class="animate__animated animate__slideInLeft"><i class="fas fa-fw fa-user animate__animated animate__slideInLeft"></i> Puesto: </label>
                        <input type="text" id="puesto" name="puesto" class="form-control shadow-sm animate__animated animate__zoomIn">
                    </div>
                
                    <div class="col-md-6">
                        <label for="telefono" class="animate__animated animate__slideInLeft"><i class="fas fa-fw fa-phone animate__animated animate__slideInLeft"></i> Teléfono: </label>
                        <input type="text" id="telefono" name="telefono" class="form-control shadow-sm animate__animated animate__zoomIn">
                    </div>
                </div>

                <div class="row text-center m-4">
                    <div class="col-12">
                        <button type="submit" class="btn btn-dark btn-user animate__animated animate__zoomIn " name="guardar" ><i class="fas fa-fw fa-save animate__animated animate__zoomIn"></i> Guardar</button>
                        <hr>
                    </div>
                </div>
            
            </form>
        </div>
    </div>
</div>
<?php 
include("../../template/bottom.php");
?>