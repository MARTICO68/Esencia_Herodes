<?php 
include("../../conn/conn.php");
include("../../template/top.php");
revisarPrivilegio(4);
if (isset($_POST['guardar'])){
    $nombre = $_POST['nombre'];
    $fecha = $_POST['fecha'];
    $descripcion = $_POST['descripcion'];

    $sqlClientes = "INSERT INTO tinventario 
    (nombre, fecha, descripcion, estado) VALUES 
    ('$nombre', '$fecha', '$descripcion', 1)";
    $queryClientes = mysqli_query($conn, $sqlClientes);

    ?>
    <script>
        alert('El cliente fue guardado exitosamente.');
        document.location.href = 'inventario.php';
    </script>
    <?php 
    exit();
}

?>

<div class="card m-4">
    <div class="card-body">
    <h4>Nuevo inventario</h4>
    <hr>
    
    <div class= "row text-right" class="user">
        <div class="col-12">
            <a href="inventario.php" class="btn btn-primary btn-user"><i class="fas fa-fw fa-arrow-left mr-2"></i>Regresar</a>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-md-6">
            <form class="user" action="" method="post">

                <div class="row">
                    <div class="col-md-6">
                        <label for="nombre" class="animate__animated animate__slideInLeft"><i class="fas fa-fw fa-user animate__animated animate__slideInLeft"></i> Nombre:</label>
                        <input type="text" id="nombre" name="nombre" class="form-control shadow-sm animate__animated animate__zoomIn">
                    </div>
                
                <div class="row">
                    <div class="col-12">
                        <label for="fecha" class="animate__animated animate__slideInLeft"><i class="fas fa-fw fa-calendar-alt animate__animated animate__slideInLeft"></i>Fecha: </label>
                        <input type="date" id="fecha" name="fecha" required class="form-control shadow-sm animate__animated animate__zoomIn">
                    </div>
                </div>
                
                <div class="col-md-6">
                        <label for="descripcion" class="animate__animated animate__slideInLeft"><i class="far fa-fw fa-user-circle animate__animated animate__slideInLeft"></i> Descripcion:</label>
                        <input type="text" id="descripcion" name="descripcion" class="form-control shadow-sm animate__animated animate__zoomIn">
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