<?php 
//Donde veamos estos includes, es referente a partes del proyecto que se mostraran por todo el sistema
include("../../conn/conn.php");
include("../../template/top.php");
revisarPrivilegio(4);
//Aqui realizamos el metodo para guardar los datos en la BD
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
    <h5>Nuevo proyecto</h5>
    <hr>
    
    <div class= "row text-right">
        <div class="col-12">
            <a href="proyectos.php" class="btn btn-sm btn-dark"><i class="fas fa-fw fa-arrow-left"></i>Regresar</a>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-md-6">
            <form class="user" action="" method="post">

                <div class="row">
                    <div class="col-md-6">
                        <label for="nombre" class="animate__animated animate__slideInLeft"></i> Nombre:</label>
                        <input type="text" id="nombre" autocomplete="off" required type="text" name="nombre" class="form-control shadow-sm animate__animated animate__zoomIn">
                    </div>
                </div>

                <div class="row">             
                    <div class="col-md-6">
                        <label for="descripcion" class="animate__animated animate__slideInLeft"></i> Descripcion:</label>
                        <input type="text" id="descripcion" autocomplete="off" required type="text" name="descripcion" class="form-control shadow-sm animate__animated animate__zoomIn">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label for="fechaini" class="animate__animated animate__slideInLeft"></i> Fecha inicial: </label>
                        <input type="date" id="fechaini" value="<?= $fechaini?>" name="fechaini" required type="text" class="form-control shadow-sm animate__animated animate__zoomIn">
                    </div>
                
                    <div class="col-md-6">
                        <label for="fechafin" class="animate__animated animate__slideInLeft"></i> Fecha de finalizacion: </label>
                        <input type="date" id="fechafin" value="<?= $fechaini?>" name="fechafin" required type="text" class="form-control shadow-sm animate__animated animate__zoomIn">
                    </div>
                </div>

                <div class="row text-center m-4">
                    <div class="col-12">
                        <button type="submit" class="btn btn-dark btn-block btn-user animate__animated animate__zoomIn" name="guardar" ><i class="fas fa-fw fa-save animate__animated animate__zoomIn"></i> Guardar</button>
                        <hr>
                    </div>
                </div>
            
            </form>
        </div>
        <div class="col-12 col-md-6 text-center">                                                        
            <img class="img-fluid" src="<?=$baseURL?>img/proyecto.gif" height="550px"><br>                                           
        </div>
    </div>
</div>
<?php 
include("../../template/bottom.php");
?>