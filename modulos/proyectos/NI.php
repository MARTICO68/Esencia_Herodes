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
<div class="card m-4">
    <div class="card-body">
            <h5>Nuevos ingresos</h5>
            <hr> 
                <div class="col-12 text-right">                                                                 
                    <a href="ingresos.php?id_proyecto=<?=urlencode($idProyecto)?>" class="btn btn-sm btn-dark"><i class="fas fa-fw fa-arrow-left"></i> Regresar</a>                                  
                </div> 
        <div class="row">
            <div class="col-12 col-md-6">                                            
                <form class="user" action="" method="post">                               
                
                <input type="hidden" name="idProyecto" value="<?= isset($_GET['id_proyecto']) ? $_GET['id_proyecto'] : '' ?>"> <!-- Campo oculto para idProyecto -->
                 
                <div class="row">
                <div class="col-md-6">                                                
                <label for="fecha" class="animate__animated animate__slideInLeft">Fecha</label>
                <input type="date" id="fecha" name="fecha" required type="text" value="<?= $fecha?>" class="form-control shadow-sm animate__animated animate__zoomIn" autocomplete="off">                   
                </div>
                </div>

           
                <div class="row">
                    <div class="col-md-6">
                        <label for="numero" class="animate__animated animate__slideInLeft"># de fanegas</label>
                        <input type="number" id="numero" oninput="calcular()" step="0.001" name="numero" required type="number" class="form-control shadow-sm animate__animated animate__zoomIn" autocomplete="off">       
                    </div>
                    <br>
                    <body>                                                                    
                    <div class="col-md-6">
                        <label for="precio" class="animate__animated animate__slideInLeft">Precio por fanega</label>
                        <input type="number" id="precio" oninput="calcular()" name="precio" required type="number" class="form-control shadow-sm animate__animated animate__zoomIn" autocomplete="off">       
                    </div>
                    </div>  
                                                                
                    <div class="row">
                    <div class="col-md-6">
                        <label for="total" class="animate__animated animate__slideInLeft">Total</label>
                        <input type="number" id="total" step="0.001" name="total" required type="number" class="form-control shadow-sm animate__animated animate__zoomIn"  autocomplete="off">       
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
 
                <div class="row text-center m-4">                     
                    <div class="col-12 mb-2">
                    <button type="submit" class="btn btn-dark btn-sm animate__animated animate__zoomIn" name="guardar"><i class="fa fa-save"></i> Guardar</button> 
                    <hr>                              
                </div>                                                                                                     
            </div>                      
        </div>                                                                                                                                                                          
        </form>
        <div class="col-12 col-md-6 text-center">                                             
            <img class="img-fluid" src="<?=$baseURL?>img/inicio1.gif" height="550px"><br>                                       
        </div> 
        
    </div>                                                
</div>
<?php
include("../../template/bottom.php");
?>