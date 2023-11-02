<?php 
include("../../conn/conn.php");
revisarPrivilegio(4);
if (isset($_POST['guardar'])){
    $identificacion = $_POST['identificacion'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $telefono = $_POST['telefono'];

    $sqlClientes = "INSERT INTO tpeones 
    (identificacion, nombre, apellidos, telefono, estado) VALUES 
    ('$identificacion', '$nombre', '$apellidos', '$telefono', 1)";
    $queryClientes = mysqli_query($conn, $sqlClientes);

    ?>
    <script>
        alert('El cliente fue guardado exitosamente.');
        document.location.href = 'peones.php';
    </script>
    <?php 
    exit();
}



$titulo = "peones -> Nuevo peones";
include("../../template/top.php");
?>

<div class= "row text-right">
    <div class="col-12">
        <a href="peones.php" class="btn btn-primary"><i class="fas fa-fw fa-arrow-left "></i>Regresar</a>
    </div>
</div>





<div class="row">
    <div class="col-12">
        <form action="" method="post">

            <div class="row">
                <div class="col-12">
                    <label for="identificacion" class="animate__animated animate__slideInLeft" ><i class="fas fa-fw fa-id-card animate__animated animate__slideInLeft"></i> Identificación:</label>
                    <input type="text" id="identificacion" name="identificacion" class="form-control shadow-sm animate__animated animate__zoomIn">

                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <label for="nombre" class="animate__animated animate__slideInLeft"><i class="fas fa-fw fa-user animate__animated animate__slideInLeft"></i> Nombre:</label>
                    <input type="text" id="nombre" name="nombre" class="form-control shadow-sm animate__animated animate__zoomIn">
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <label for="apellidos" class="animate__animated animate__slideInLeft"><i class="far fa-fw fa-user-circle animate__animated animate__slideInLeft"></i> Apellidos:</label>
                    <input type="text" id="apellidos" name="apellidos" class="form-control shadow-sm animate__animated animate__zoomIn">
                </div>
            </div>


            <div class="row">
                <div class="col-12">
                    <label for="telefono" class="animate__animated animate__slideInLeft"><i class="fas fa-fw fa-phone animate__animated animate__slideInLeft"></i> Teléfono: </label>
                    <input type="text" id="telefono" name="telefono" class="form-control shadow-sm animate__animated animate__zoomIn">
                </div>
            </div>

            <div class="row text-center m-4">
                <div class="col-12">
                    <button type="submit" class="btn btn-primary animate__animated animate__zoomIn" name="guardar" ><i class="fas fa-fw fa-check animate__animated animate__zoomIn"></i> Guardar</button>
                </div>
            </div>
          
        </form>
    </div>

<?php 
include("../../template/bottom.php");
?>