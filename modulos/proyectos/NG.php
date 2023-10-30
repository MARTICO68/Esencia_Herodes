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
    $nombre = $_POST['nombre'];
    $fecha  = $_POST['fecha'];
    $cantidad = $_POST['cantidad'];
    $costo = $_POST['costo'];
    $gasto = $_POST['gasto'];

    $sqlClientes = "INSERT INTO tgastos (idProyecto, nombre, fecha, cantidad, costo, gasto, estado) VALUES
    ('$idProyecto', '$nombre', '$fecha', '$cantidad', '$costo', '$gasto', 1)";
    $queryClientes = mysqli_query($conn, $sqlClientes);
    
    ?>
    <script> 
        alert('Datos guardados correctamente');          
        document.location.href = "gastos.php?id_proyecto=<?=urlencode($idProyectoEncriptado)?>"; // Corrección: Redireccionar correctamente
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
                <h5 class="text-center">Nuevos gastos</h5>
                <hr>  
                <div class="row text-right">
                    <div class="col-12">
                        <a href="gastos.php?id_proyecto=<?= $idProyectoEncriptado ?>" class="btn btn-dark"><i class="fas fa-fw fa-arrow-left"></i> Regresar </a>
                    </div>
                </div>                                            
                <form class="user" action="" method="post">                               
                
                <input type="hidden" name="idProyecto" value="<?= isset($_GET['id_proyecto']) ? $_GET['id_proyecto'] : '' ?>"> <!-- Campo oculto para idProyecto -->
                
                <div class="row">
                    <div class="col-12 col-md-6">
                        <label for="nombre">Materiales: </label>
                        <select class="form-control" name="nombre" id="nombre" autocomplete="off">
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
                <label for="fecha">Fecha</label>
                <input type="date" id="fecha" name="fecha" required type="text" value="<?= $fecha?>" class="form-control" autocomplete="off">                   
                </div>
                </div>
                
                <body>
                 <div class="row">
                    <div class="col-md-6">
                    <label for="cantidad">Cantidad</label>
                        <input type="number" id="cantidad" step="0.001" oninput="calcular()" name="cantidad" required type="number"  class="form-control" autocomplete="off">
                    </div>       
                    <div class="col-md-6">
                    <label for = "costo">Costo</label>
                        <input type="number" id="costo" step="0.001" oninput="calcular()" name="costo" required type="number"  class="form-control" autocomplete="off">
                    </div>
                 </div>   
                
                 <div class="row">
                 <div class="col-md-6">
                <label for="gasto">Gasto</label>
                    <input type="number" id="gasto" step="0.001" oninput="calcular()" name="gasto" required type="number"  class="form-control" autocomplete="off">       
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
                <hr> 
                <div class="row">                     
                    <div class="col-8 mb-2">
                        <button type="submit" class="btn btn-dark btn-user btn-block" name="guardar"><i class="fa fa-save"></i> Guardar</button>                               
                </div>                                                                                      
                
            </div>                      
        </div>
        
    </div>                                                
</div>
<?php
include("../../template/bottom.php");
?>
