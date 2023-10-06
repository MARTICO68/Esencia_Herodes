<?php 
include("../../conn/conn.php");
include("../../template/top.php");
revisarPrivilegio(4);
if (isset($_POST['guardar'])){
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $fechaini = $_POST['fechaini'];
    $fechafin = $_POST['fechafin'];

    $sqlClientes = "INSERT INTO tproyectos 
    (nombre, descripcion, fechaini, fechafin, estado) VALUES 
    ('$nombre', '$descripcion', '$fechaini', '$fechafin', 1)";
    $queryClientes = mysqli_query($conn, $sqlClientes);

    ?>
    <script>
        alert('El proyecto fue guardado exitosamente.');
        document.location.href = 'proyectos.php';
    </script>
    <?php 
    exit();
}

?>

<div class="card m-4">
    <div class="card-body">
    <h4>Nuevo proyecto</h4>
    <hr>
    
    <div class= "row text-right" class="user">
        <div class="col-12">
            <a href="proyectos.php" class="btn btn-primary btn-user"><i class="fas fa-fw fa-arrow-left mr-2"></i>Regresar</a>
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
                </div>

                <div class="row">             
                    <div class="col-md-6">
                        <label for="descripcion" class="animate__animated animate__slideInLeft"><i class="far fa-fw fa-user-circle animate__animated animate__slideInLeft"></i> Descripcion:</label>
                        <input type="text" id="descripcion" name="descripcion" class="form-control shadow-sm animate__animated animate__zoomIn">>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label for="fechaini" class="animate__animated animate__slideInLeft"><i class="fas fa-fw fa-user animate__animated animate__slideInLeft"></i> Fecha inicial: </label>
                        <input type="date" id="fechaini" value="<?= $fechaini?>" name="fechaini" class="form-control shadow-sm animate__animated animate__zoomIn">
                    </div>
                
                    <div class="col-md-6">
                        <label for="fechafin" class="animate__animated animate__slideInLeft"><i class="fas fa-fw fa-phone animate__animated animate__slideInLeft"></i> Fecha de finalizacion: </label>
                        <input type="date" id="fechafin" value="<?= $fechaini?>" name="fechafin" class="form-control shadow-sm animate__animated animate__zoomIn">
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