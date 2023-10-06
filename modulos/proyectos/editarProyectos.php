<?php 
include('../../conn/conn.php');
revisarPrivilegio(4);
$idEditar = 0;
if (isset($_GET['id_editar'])){
    $idEditar = $_GET['id_editar'];
}

if (isset($_POST['guardar'])){
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $fechaini = $_POST['fechaini'];
    $fechafin = $_POST['fechafin'];
   
    $sqlClientes = "UPDATE tproyectos SET 
    nombre = '$nombre',
    descripcion = '$descripcion',
    fechaini = '$fechaini',
    fechafin = '$fechafin'
    WHERE id = '$id'";
    $queryClientes = mysqli_query($conn, $sqlClientes);

    ?>
    <script>
        alert('El proyecto fue editado exitosamente.');
        document.location.href = 'proyectos.php';
    </script>
    <?php
    exit();
}


include('../../template/top.php');
?>
<div class="card m-4">
    <div class="card-body">
    <h4>Editar Proyecto</h4>
    <hr>
    <div class="row text-right">
        <div class="col-12">
            <a href="proyectos.php" class="btn btn-primary"><i class="fas fa-fw fa-arrow-left"></i> Regresar</a>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-md-6">

        <?php 
            $sqlEditar = "SELECT * FROM tproyectos WHERE id = '$idEditar'";
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
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="descripcion" class="animate__animated animate__slideInLeft"><i class="far fa-fw fa-user-circle animate__animated animate__slideInLeft"></i> Descripcion:</label>
                            <input type="text" id="descripcion" value="<?=$rowEditar['descripcion']?>" name="descripcion" class="form-control shadow-sm animate__animated animate__zoomIn">
                        </div>
                    </div>

                <div class="row">
                    <div class="col-md-6">
                        <label for="fechaini" class="animate__animated animate__slideInLeft"><i class="far fa-fw fa-user-circle animate__animated animate__slideInLeft"></i> Fecha inicial:</label>
                        <input type="text" id="fechaini" value="<?=$rowEditar['fechaini']?>" name="fechaini" class="form-control shadow-sm animate__animated animate__zoomIn">
                    </div>
                
                    <div class="col-md-6">
                        <label for="fechafin" class="animate__animated animate__slideInLeft"><i class="fas fa-fw fa-phone animate__animated animate__slideInLeft"></i> Fecha de finalizacion: </label>
                        <input type="text" id="fechafin" value="<?=$rowEditar['fechafin']?>" name="fechafin" class="form-control shadow-sm animate__animated animate__zoomIn">
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