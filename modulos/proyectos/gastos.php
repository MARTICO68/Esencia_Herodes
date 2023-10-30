<?php
include("../../conn/conn.php");
revisarPrivilegio(4);

// Asegúrate de que $idProyecto se haya definido correctamente antes de usarlo.
$idProyecto = isset($_GET['id_proyecto']) ? $_GET['id_proyecto'] : '';
$idProyectoEncriptado = base64_encode($idProyecto);

if (isset($_GET['id_proyecto'])) {
    // Recupera el ID del proyecto desde la URL y desencripta usando base64_decode
    $idProyectoEncriptado = $_GET['id_proyecto'];
    $idProyecto = base64_decode($idProyectoEncriptado);

    // Ahora, $idProyecto contiene el ID del proyecto desencriptado y puedes utilizarlo en tu página.
}

// Verifica si se debe eliminar un registro
if (isset($_GET['id_eliminar'])) {
    $idEliminar = $_GET['id_eliminar'];
    // Realiza la eliminación y luego redirige
    $sqlEliminar = "UPDATE tgastos SET estado = 2 WHERE id = '$idEliminar'";
    $queryEliminar = mysqli_query($conn, $sqlEliminar);
    if ($queryEliminar) {
        header("location: gastos.php?id_proyecto=$idProyectoEncriptado");
        exit();
    } else {
        // Manejar error si la consulta de eliminación falla
        echo "Error al eliminar el registro: " . mysqli_error($conn);
    }
}

// Genera la consulta SQL para buscar registros
$sql = "SELECT * FROM tgastos WHERE estado = 1 AND idProyecto = '$idProyecto'";

// Añade condiciones adicionales según lo que necesites
if (!empty($buscar)) {
    $sql .= " AND idEmpleado LIKE '%$buscar%'";
}

$query = mysqli_query($conn, $sql);

if (!$query) {
    // Manejar error si la consulta falla
    echo "Error en la consulta: " . mysqli_error($conn);
}

$total = 0;
include("../../template/top.php");



// Consulta SQL para buscar registros
$sql = "SELECT * FROM tgastos WHERE estado = 1 AND idProyecto = '$idProyecto'";

if (!empty($buscar)) {
    $sql .= " AND idEmpleado LIKE '%$buscar%'";
}

$query = mysqli_query($conn, $sql);

// Calcular el total de gastos de planilla
$totalGastos = 0;
while ($rowClientes = mysqli_fetch_assoc($query)) {
    $totalGastos += $rowClientes['gasto'];
}

// Consulta SQL para obtener el monto_total de la tabla tplanillas
$sqlMontoTotal = "SELECT gasto FROM tgastos WHERE idProyecto = '$idProyecto'";
$queryMontoTotal = mysqli_query($conn, $sqlMontoTotal);

// Obtiene el valor de monto_total
$montoTotal1 = 0;


// Calcular el total final sumando el montoTotal y los gastos de planilla
$totalFinal2 = $montoTotal1 + $totalGastos;
?>

<div class="card">
    <div class="card-body">
        <?php
        
        if(!empty($_REQUEST['fecha_de']) && !empty($_REQUEST['fecha_a'])){
            $fecha_de = $_REQUEST['fecha_de'];
            $fecha_a = $_REQUEST['fecha_a'];

            $buscar = '';

            if($fecha_de > $fecha_a){
                header("location: gastos.php");
            }else if($fecha_de == $fecha_a){
                $where = "fecha LIKE '$fecha_de%'";
                $buscar = "fecha_de=$fecha_de&fecha_a=$fecha_a";
            }else{
                $f_de = $fecha_de.' 00:00:00';
                $f_a = $fecha_a.' 23:59:59';
                $where = "fecha BETWEEN '$f_de' AND '$f_a'";
                $buscar = "fecha_de=$fecha_de&fecha_a=$fecha_a";
            }
          
        }
        $idProyecto = isset($_GET['id_proyecto']) ? $_GET['id_proyecto'] : '';
        $idProyectoEncriptado = base64_encode($idProyecto);

        if (isset($_GET['id_proyecto'])) {
            // Recupera el ID del proyecto desde la URL y desencripta usando base64_decode
            $idProyectoEncriptado = $_GET['id_proyecto'];
            $idProyecto = base64_decode($idProyectoEncriptado);

            // Ahora, $idProyecto contiene el ID del proyecto desencriptado y puedes utilizarlo en tu página.
        }

        $sql = "SELECT * FROM tproyectos WHERE id = '$idProyecto'";
        $query = mysqli_query($conn, $sql);

        while($row = mysqli_fetch_assoc($query)){
            ?>
            <div class="row text-center">
                <div class="col-12">
                    <h4>Economía del proyecto: <?=$row['nombre']?></h4>
                    <hr>
                </div>
            </div>
            <?php
        }
        ?>
        <div class="row text-right p-2 mb-2">
            <div class="col-12">
                <a href="administracion.php?id_proyecto=<?=urlencode($idProyecto)?>" class="btn btn-dark"><i class="fas fa-fw fa-arrow-left"></i> Regresar</a>
            </div>
        </div>
        <?php
            $sql = "SELECT * FROM tgastos WHERE estado = 1 AND idProyecto = '$idProyecto'";
            $query = mysqli_query($conn, $sql);
            if (mysqli_num_rows($query) == 0){
                ?>
                <div class="row text-center">
                    <div class="col-12">   
                        <a href="NG.php?id_proyecto=<?=urlencode($idProyectoEncriptado)?>" class="btn-sm btn btn-outline-success"><i class="fas fa-fw fa-plus"></i></a> 
                        <br>              
                        <img class="img-fluid" src="<?=$baseURL?>img/nohay.gif" ><br>          
                        No hay gastos en este proyecto.  
                    </div>
                </div>
                <?php
            }else{
                ?>               
                    <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <th style="min-width:150px">
                            <a href="NG.php?id_proyecto=<?=urlencode($idProyectoEncriptado)?>" class="btn-sm btn btn-outline-success"><i class="fas fa-fw fa-plus"></i></a>
                            <a href="reportes.php?<?=urlencode('id_proyecto=' .$_GET['id_proyecto'])?>" class="btn-sm btn btn-outline-danger"><i class="fas fa-fw fa-download"></i></a>
                            </th>
                            <th>Nombre</th>
                            <th>Fecha</th>
                            <th>Cantidad</th>   
                            <th>Costo</th>
                            <th>Gasto</th>                       
                            <th>Subtotal</th>                          
                        </thead>
                        <tbody>
                            <?php while($rowClientes=mysqli_fetch_assoc($query)){ ?>
                            <tr>
                                <td style="min-width:150px ">
                                <a href="EG.php?id_editar=<?=$rowClientes['id']?>&id_proyecto=<?=urlencode($idProyectoEncriptado)?>"  class="btn-sm btn btn-outline-dark"><i class="fa fa-fw fa-edit"></i></a>
                                <a href="gastos.php?id_eliminar=<?=$rowClientes['id']?>&id_proyecto=<?=urlencode($idProyectoEncriptado)?>" onclick="return confirm('¿Está seguro(a) que desea eliminar?')" class="btn-sm btn btn-danger"><i class="fas fa-fw fa-trash"></i></a>
                                </td>                               
                                <td><?=$rowClientes['nombre']?></td>
                                <td><?=$rowClientes['fecha']?></td>
                                <td><?=$rowClientes['cantidad']?></td>
                                <td><?=$rowClientes['costo']?></td>
                                <td><?=$rowClientes['gasto']?></td>
                                <td class="text-right">
                                <?php
                                echo '&cent; '.number_format($subtotal = $rowClientes['gasto'],2);
                                $total = $subtotal;
                                ?>
                                </td>
                            </tr>
                            <?php } ?>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>                                                          
                                <td class="text-right"><strong>Total de Gastos</strong></td>
                                <td class="text-right"><strong>&cent; <?=number_format($totalFinal2,2)?></strong> </td>
                            </tr>
                        </tbody>
                    </table>
                    </div>
                
    </div>
</div>

<?php
}
include("../../template/bottom.php");
?>