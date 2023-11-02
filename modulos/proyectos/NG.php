<?php
include("../../conn/conn.php");
include("../../template/top.php");
revisarPrivilegio(4);

$idProyecto = isset($_GET['id_proyecto']) ? $_GET['id_proyecto'] : '';
$idProyectoEncriptado = base64_encode($idProyecto);

if (isset($_GET['id_proyecto'])) {
    // Recupera el ID del proyecto desde la URL y desencripta usando base64_decode
    $idProyectoEncriptado = $_GET['id_proyecto'];
    $idProyecto = base64_decode($idProyectoEncriptado);
}

if (isset($_POST['guardar'])) {
    $idPro = $_POST['idProyecto']; // Corrección: Obtener idProyecto desde el formulario
    $nombre = $_POST['nombre'];
    $fecha  = $_POST['fecha'];
    $cantidad = $_POST['cantidad'];
    $costo = $_POST['costo'];
    $gasto = $_POST['gasto'];

    $sqlClientes = "INSERT INTO tgastos (idProyecto, nombre, fecha, cantidad, costo, gasto, estado) VALUES
    ('$idProyecto', '$nombre', '$fecha', '$cantidad', '$costo', '$gasto', 1)";
    $queryClientes = mysqli_query($conn, $sqlClientes);

    if ($queryClientes) {
        // Los datos se guardaron exitosamente
        ?>
        <script>
            // Muestra un mensaje de confirmación con SweetAlert2
            Swal.fire({
                title: 'Datos guardados correctamente',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirecciona a la página deseada
                    window.location.href = "gastos.php?id_proyecto=<?=urlencode($idProyectoEncriptado)?>";
                }
            });
        </script>
        <?php
        exit();
    } else {
        // Error al guardar los datos
        ?>
        <script>
            // Muestra un mensaje de error con SweetAlert2
            Swal.fire({
                title: 'Error al guardar los datos',
                text: 'Ha ocurrido un error al guardar los datos. Por favor, inténtalo de nuevo.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        </script>
        <?php
    }
}


?>
<div class="card m-4">
    <div class="card-body">
        <h5>Nuevos gastos</h5>
        <hr>
        <div class="row text-right">
            <div class="col-12">
                <a href="gastos.php?id_proyecto=<?= $idProyectoEncriptado ?>" class="btn btn-sm btn-dark"><i class="fas fa-fw fa-arrow-left"></i> Regresar </a>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-6">
                                                                                  
                <form class="user" action="" method="post">   

                    <input type="hidden" name="idProyecto" value="<?= isset($_GET['id_proyecto']) ? $_GET['id_proyecto'] : '' ?>"> <!-- Campo oculto para idProyecto -->
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <label for="nombre" class="animate__animated animate__slideInLeft">Materiales: </label>
                                <select class="form-control shadow-sm animate__animated animate__zoomIn" name="nombre" id="nombre" autocomplete="off">
                                <?php 
                                $sqlidEmpleado = "SELECT * FROM tinventario WHERE estado = 1";
                                $queryidEmpleado = mysqli_query($conn, $sqlidEmpleado);
                                while($rowidEmpleado = mysqli_fetch_array($queryidEmpleado)){
                                    ?>
                                    <option value="<?=$rowidEmpleado['nombre']?>"><?=$rowidEmpleado['nombre']?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                        <div class="col-md-6">                                                
                        <label for="fecha" class="animate__animated animate__slideInLeft">Fecha</label>
                        <input type="date" id="fecha" name="fecha" required type="text" value="<?= $fecha?>" class="form-control shadow-sm animate__animated animate__zoomIn" autocomplete="off">                   
                        </div>
                        </div>
                        
                        <body>
                        <div class="row">
                            <div class="col-md-6">
                            <label for="cantidad" class="animate__animated animate__slideInLeft">Cantidad</label>
                                <input type="number" id="cantidad" step="0.001" oninput="calcular()" name="cantidad" required type="number"  class="form-control shadow-sm animate__animated animate__zoomIn" autocomplete="off">
                            </div>       
                            <div class="col-md-6">
                            <label for = "costo" class="animate__animated animate__slideInLeft">Costo</label>
                                <input type="number" id="costo" step="0.001" oninput="calcular()" name="costo" required type="number"  class="form-control shadow-sm animate__animated animate__zoomIn" autocomplete="off">
                            </div>
                        </div>   
                        
                        <div class="row">
                        <div class="col-md-6">
                        <label for="gasto" class="animate__animated animate__slideInLeft">Gasto</label>
                            <input type="number" id="gasto" step="0.001" oninput="calcular()" name="gasto" required type="number"  class="form-control shadow-sm animate__animated animate__zoomIn" autocomplete="off">       
                        </div>
                        </div>
                                                            
                        </body>
                        <script type="text/javascript">
                            function calcular(){
                                try{ 
                                    var a = parseFloat(document.getElementById("cantidad").value) || 0,
                                        b = parseFloat(document.getElementById("costo").value) || 0;
                                    
                                        e = document.getElementById("gasto").value = a * b;
                                } catch (e) {}
                            }        
                        </script>
                        </script> 
                        <div class="row text-center m-4">                     
                            <div class="col-12 mb-2">
                                <button type="submit" class="btn btn-dark btn-sm animate__animated animate__zoomIn" name="guardar"><i class="fa fa-save"></i> Guardar</button> 
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
</div>
<?php
include("../../template/bottom.php");
?>
