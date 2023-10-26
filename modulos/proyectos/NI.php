<?php
include("../../conn/conn.php");
revisarPrivilegio(4);
$idProyecto = isset($_GET['id_proyecto']) ? $_GET['id_proyecto'] : ''; // Establece un valor predeterminado si no se proporciona en la URL
$idProyectoEncriptado = base64_encode($idProyecto);
if (isset($_GET['id_proyecto'])) {
 // Recupera el ID del proyecto desde la URL y desencripta usando base64_decode
 $idProyectoEncriptado = $_GET['id_proyecto'];
 $idProyecto = base64_decode($idProyectoEncriptado);

 // Ahora, $idProyecto contiene el ID del proyecto desencriptado y puedes utilizarlo en tu página.
}

if(isset($_POST['guardar'])){
    $idPro = $_POST['idProyecto']; // Corrección: Obtener idProyecto desde el formulario
    $fecha  = $_POST['fecha'];
    $numero = $_POST['numero'];
    $precio = $_POST['precio'];
    $total = $_POST['total'];

    $sqlClientes = "INSERT INTO tingresos (idProyecto, fecha, numero, precio, total, estado) VALUES
    ('$idProyecto', '$fecha', '$numero', '$precio', '$total', 1)";
    $queryClientes = mysqli_query($conn, $sqlClientes);
    
    ?>
    <script> 
        alert('Datos guardados correctamente');          
        document.location.href = "ingresos.php?id_proyecto=<?=urlencode($idProyectoEncriptado)?>"; // Corrección: Redireccionar correctamente
    </script>
    <?php
    exit();
}
include("../../template/top.php");
?>
<link rel="stylesheet" href="modals.css">
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-md-6">
                <h5 class="text-center">Nuevos ingresos</h5>
                <hr>                                              
                <form class="user" action="" method="post">                               
                
                <input type="hidden" name="idProyecto" value="<?= isset($_GET['id_proyecto']) ? $_GET['id_proyecto'] : '' ?>"> <!-- Campo oculto para idProyecto -->
                 
                <div class="col-12 text-right">                                                                 
                <a href="administracion.php?id_proyecto=<?=urlencode($idProyecto)?>" class="btn btn-outline-dark"><i class="fas fa-fw fa-arrow-left"></i> Regresar</a>                                  
                </div> 

                <div class="row">
                <div class="col-md-6">                                                
                <label for="fecha">Fecha</label>
                <input type="date" id="fecha" name="fecha" required type="text" value="<?= $fecha?>" class="form-control" autocomplete="off">                   
                </div>
                </div>

           
                <div class="row">
                    <div class="col-md-6">
                        <label for="numero"># de fanegas</label>
                        <input type="number" id="numero" oninput="calcular()" step="0.001" name="numero" required type="number" class="form-control" autocomplete="off">       
                    </div>
                    <br>
                    <body>                                                                    
                    <div class="col-md-6">
                        <label for="precio">Precio por fanega</label>
                        <input type="number" id="precio" oninput="calcular()" name="precio" required type="number" class="form-control" autocomplete="off">       
                    </div>
                    </div>  
                                                                
                    <div class="row">
                    <div class="col-md-6">
                        <label for="total">Total</label>
                        <input type="number" id="total" step="0.001" name="total" required type="number" class="form-control"  autocomplete="off">       
                    </div>   
                    </div>
        
                    <script type="text/javascript">

                        function calcular(){
                    try{ 
                        var a = parseFloat(document.getElementById("numero").value) || 0,
                            b = parseFloat(document.getElementById("precio").value) || 0;
                            document.getElementById("total").value = a * b;
                    } catch (e) {}

                }        
                </script>                                                               
                </script>

                <hr> 
                <div class="row">                     
                    <div class="col-12 mb-2">
                        <button type="submit" class="btn btn-dark btn-user btn-block" name="guardar"><i class="fa fa-save"></i> Guardar</button>                               
                </div>                                                                                                     
            </div>                      
        </div>
        <div class="col-12 col-md-6 text-center">                                             
                <img class="img-fluid" src="<?=$baseURL?>img/proyecto.gif" height="550px"><br>                                       
            </div>                                                                                                                                                                           
        </form>
        
    </div>                                                
</div>
<?php
include("../../template/bottom.php");
?>