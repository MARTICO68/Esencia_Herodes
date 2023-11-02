<?php
//Donde veamos estos includes, es referente a partes del proyecto que se mostraran por todo el sistema 
include("../../conn/conn.php");
include("../../template/top.php");
revisarPrivilegio(4);
//Aqui realizamos el metodo para guardar los datos en la BD
if (isset($_POST['guardar'])){
    $nombre = $_POST['nombre'];
    $fecha = $_POST['fecha'];
    $descripcion = $_POST['descripcion'];

    $sqlClientes = "INSERT INTO tinventario 
    (nombre, fecha, descripcion, estado) VALUES 
    ('$nombre', '$fecha', '$descripcion', 1)";
    $queryClientes = mysqli_query($conn, $sqlClientes);

    if ($queryClientes) {
        // El inventario se guardó con éxito, muestra un mensaje de confirmación
        echo '<script>
            Swal.fire({
                title: "Guardado exitosamente",
                icon: "success",
                confirmButtonText: "OK"
            }).then(() => {
                window.location.href = "inventario.php";
            });
        </script>';
    } else {
        // Hubo un error al guardar el inventario, muestra un mensaje de error
        echo '<script>
            Swal.fire({
                title: "Error al guardar",
                text: "Hubo un error al guardar el inventario. Por favor, inténtalo de nuevo.",
                icon: "error",
                confirmButtonText: "OK"
            });
        </script>';
    }
    exit();
}
?>

<div class="card m-4">
    <div class="card-body">
    <h5>Nuevo inventario</h5>
    <hr>
    
    <div class= "row text-right" class="user">
        <div class="col-12">
            <a href="inventario.php" class="btn btn-dark btn-sm"><i class="fas fa-fw fa-arrow-left"></i>Regresar</a>
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
                        <label for="fecha" class="animate__animated animate__slideInLeft"></i>Fecha: </label>
                        <input type="date" id="fecha" autocomplete="off" required type="text" name="fecha" required class="form-control shadow-sm animate__animated animate__zoomIn">
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <label for="descripcion" class="animate__animated animate__slideInLeft"></i> Descripcion:</label>
                        <input type="text" id="descripcion" autocomplete="off" required type="text" name="descripcion" class="form-control shadow-sm animate__animated animate__zoomIn">
                    </div>
                </div>
                <br>
                <div class="row text-center m-4">
                    <div class="col-12">
                        <button type="submit" class="btn btn-dark btn-save btn-sm animate__animated animate__zoomIn" name="guardar" ><i class="fas fa-fw fa-save animate__animated animate__zoomIn"></i> Guardar</button>
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
