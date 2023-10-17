<?php
include("../../conn/conn.php");
revisarPrivilegio(4);
$idProyecto = $_GET['id_proyecto'];

if (isset($_GET['id_eliminar'])){
    $idEliminar = $_GET['id_eliminar'];

    $sqlEliminar = "UPDATE thoras SET estado = 2 WHERE id = '$idEliminar'";
    $queryEliminar = mysqli_query($conn, $sqlEliminar);

    header('location: proyectos.php?id_proyecto=' . $idProyecto);
    exit();
}

include("../../template/top.php");

// Variable para almacenar el valor de búsqueda
$buscar = '';

if (isset($_GET['buscar'])) {
    $buscar = $_GET['buscar'];
}

// Consulta SQL para buscar registros
$sql = "SELECT * FROM thoras WHERE estado = 1 AND idProyecto = '$idProyecto'";

if (!empty($buscar)) {
    $sql .= " AND idEmpleado LIKE '%$buscar%'";
}

$query = mysqli_query($conn, $sql);

// Calcular el total de gastos de planilla
$totalGastosPlanilla = 0;
while ($rowClientes = mysqli_fetch_assoc($query)) {
    $totalGastosPlanilla += $rowClientes['total'];
}

// Consulta SQL para obtener el monto_total de la tabla tplanillas
$sqlMontoTotal = "SELECT total FROM thoras WHERE idProyecto = '$idProyecto'";
$queryMontoTotal = mysqli_query($conn, $sqlMontoTotal);

// Obtiene el valor de monto_total
$montoTotal = 0;


// Calcular el total final sumando el montoTotal y los gastos de planilla
$totalFinal = $montoTotal + $totalGastosPlanilla;










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

$totalFin = $totalFinal2 + $totalFinal;

 
?>

<div class="card">
    <div class="card-body">
        <?php
            $sqlProyecto = "SELECT * FROM tproyectos WHERE id = '$idProyecto'";
            $queryProyecto = mysqli_query($conn, $sqlProyecto);
            
            while($rowProyecto = mysqli_fetch_assoc($queryProyecto)){
                ?>
                <div class="row text-center">
                    <div class="col-12">
                        <h4>Administracion del proyecto: <?=$rowProyecto['nombre']?></h4>
                        <hr>
                    </div>
                </div>
                <?php
            }
        ?>
        <div class="row">
            <div class="col-12 text-right p-2 mb-2">
                <a href="proyectos.php" class="btn btn-dark"><i class="fas fa-fw fa-arrow-left"></i> Regresar </a>
            </div>
        </div>

        <form action="" method="get">
            <div class="row text-right">
                <div class="col-8 col-md-4 pt-2">
                    <input type="text" name="buscar" placeholder="Digite el nombre y presione enter" class="form-control" autocomplete="off" value="<?=$buscar?>">
                    <button type="submit" class="btn btn-sm"></button>
                </div>
            </div>
        </form>

        <?php
        if (mysqli_num_rows($query) == 0){
            ?>
            <div class="row text-center">
                <div class="col-12">
                    <a href="NP.php?id_proyecto=<?=$idProyecto?>" class="btn-sm btn btn-outline-success"><i class="fas fa-fw fa-plus"></i></a> 
                    <br>              
                    <img class="img-fluid" src="<?=$baseURL?>img/nohay.gif" ><br>         
                    No hay planillas en este proyecto.  
                </div>
            </div>
            <?php
        } else {
            ?>
            <div class="table-responsive">
                <table class="table table-sm table-striped table-bordered">
                    <thead>
                        <th style="min-width:150px">
                            <a href="planilla.php?id_proyecto=<?=urlencode($idProyecto)?>" class="btn-sm btn btn-outline-success"><i class="fas fa-fw fa-table"></i></a>
                            <a href="gastos.php?id_proyecto=<?=urlencode($idProyecto)?>" class="btn-sm btn btn-outline-success"><i class="fas fa-fw fa-building"></i></a>
                            <a href="excel.php?id_proyecto=<?=$idProyecto?>" class="btn-sm btn btn-outline-success"><i class="fas fa-fw fa-file"></i></a>
                        </th>
                        <th>Gasto de Planillas</th>
                        <th>Gasto de Materiales</th>
                        <th>Total de Gastos</th>
                        <th>Total de Ingresos</th>
                        <th>Subtotal</th>
                    </thead>
                    <tbody>
                        <?php while($rowClientes = mysqli_fetch_assoc($query)){ ?>
                        <tr>
                            <td style="min-width:150px">
                                
                            </td>
                            <td><?=$rowClientes['idEmpleado']?></td>
                            <td><?=$rowClientes['fecha']?></td>
                            <td><?=$rowClientes['total']?></td>
                            <td class="text-right">
                                <?php
                                echo '&cent; '.number_format($subtotal = $rowClientes['total'],2);
                                ?>
                            </td>
                        </tr>
                        <?php } ?>
                        <tr>
                            <td class="text-right"><strong>Total</strong></td>
                            <td class="text-right"><strong>&cent; <?=number_format($totalFinal, 2)?></strong></td>
                            <td class="text-right"><strong>&cent; <?=number_format($totalFinal2, 2)?></strong></td>
                            <td class="text-right"><strong>&cent; <?=number_format($totalFin, 2)?></strong></td>
                            <td></td>
                            <td></td>
                            
                        </tr>
                    </tbody>
                </table>
            </div>
        <?php
        }
        ?>
    </div>
</div>

<?php
include("../../template/bottom.php");
?>
