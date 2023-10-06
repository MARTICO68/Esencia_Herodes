<?php
include("../../conn/conn.php");
revisarPrivilegio(4);
$idProyecto = isset($_GET['id_proyecto']) ? $_GET['id_proyecto'] : '';


if(isset($_POST['guardar'])){
    $idPro = $_POST['idProyecto']; // Corrección: Obtener idProyecto desde el formulario
    $nombre = $_POST['nombre'];
    $fecha  = $_POST['fecha'];
    $cantidad = $_POST['cantidad'];
    $costo = $_POST['costo'];
    $gasto = $_POST['gasto'];
    $ingresos = $_POST['ingresos'];

    $sqlClientes = "INSERT INTO tgastos (idProyecto, nombre, fecha, cantidad, costo, gasto, ingresos, estado) VALUES
    ('$idProyecto', '$nombre', '$fecha', '$cantidad', '$costo', '$gasto', '$ingresos', 1)";
    $queryClientes = mysqli_query($conn, $sqlClientes);
    
    ?>
    <script> 
        alert('Datos guardados correctamente');          
        document.location.href = "gastos.php?id_proyecto=<?=urlencode($idProyecto)?>"; // Corrección: Redireccionar correctamente
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
                    <label for="costo">Costo</label>
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
                                c = parseFloat(document.getElementById("cajuelas").value) || 0;
                                d = parseFloat(document.getElementById("precio").value) || 0;
                              
                                e = document.getElementById("gasto").value = a * b;
                                f = document.getElementById("ingresos").value = c * d;
                                document.getElementById("total").value = f - e;                                                                                                            
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
        
                <div class="col-12 col-md-6">
                        <h5 class="text-center">Nuevos Ingresos</h5>
                        <hr>                      
                        <div class="col-12 text-right">                                                                 
                            <a href="gastos.php?id_proyecto=<?=urlencode($_GET['id_proyecto'])?>" class="btn btn-outline-dark"><i class="fas fa-fw fa-arrow-left"></i> Regresar</a>                                  
                                                                                                                                       
                        </div>
                        <div class="row">
                        <div class="col-md-6">
                            <label for="cajuelas"># de cajuelas / fanegas</label>
                            <input type="number" id="cajuelas" oninput="calcular()" step="0.001" name="cajuelas" required type="number" class="form-control form-control-user" autocomplete="off">       
                        </div>
                        <br>
                        <body>                                                                    
                        <div class="col-md-6">
                            <label for="precio">Precio por cajuela / fanega</label>
                            <input type="number" id="precio" oninput="calcular()" name="precio" required type="number" class="form-control form-control-user" autocomplete="off">       
                        </div>
                        </div>                                                         
                         
                        <div class="row">
                        <div class="col-md-6">
                            <label for="ingresos">Ingresos</label>
                            <input type="number" id="ingresos" step="0.001" oninput="calcular()" name="ingresos" required type="number"  class="form-control form-control-user" autocomplete="off">       
                        </div>
                        </div>
                        <div class="row">
                        <div class="col-md-6">
                            <label for="total">Total</label>
                            <input type="number" id="total" step="0.001" name="total" required type="number" class="form-control form-control-user"  autocomplete="off">       
                        </div>   
                        </div>
                                                         
                        </body>
                        <script type="text/javascript">
                                                
                        </script>
                        </script>                                                                                                                                 
                        </form>
                </div>

    </div>                                                
</div>
<?php
include("../../template/bottom.php");
?>
