<?php
//Donde veamos estos includes, es referente a partes del proyecto que se mostraran por todo el sistema
include("../../conn/conn.php");
revisarPrivilegio(4);
$idProyecto = isset($_GET['id_proyecto']) ? $_GET['id_proyecto'] : '';

$idProyectoEncriptado = base64_encode($idProyecto);
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

// Consulta SQL para buscar registros en la tabla thoras
$sqlHoras = "SELECT * FROM thoras WHERE estado = 1 AND idProyecto = '$idProyecto'";

if (!empty($buscar)) {
    $sqlHoras .= " AND idEmpleado LIKE '%$buscar%'";
}
$queryHoras = mysqli_query($conn, $sqlHoras);
// Consulta SQL para buscar registros en la tabla tgastos
$sqlGastos = "SELECT * FROM tgastos WHERE estado = 1 AND idProyecto = '$idProyecto'";
$queryGastos = mysqli_query($conn, $sqlGastos);

// Consulta SQL para buscar registros en la tabla tingresos
$sqlIngresos = "SELECT * FROM tingresos WHERE estado = 1 AND idProyecto = '$idProyecto'";
$queryIngresos = mysqli_query($conn, $sqlIngresos);

// Calcular el total de gastos de planilla
$totalGastosPlanilla = 0;
while ($rowClientes = mysqli_fetch_assoc($queryHoras)) {
    $totalGastosPlanilla += $rowClientes['total'];
}
// Calcular el total de gastos de materiales
$totalGastosMateriales = 0;
while ($rowGastos = mysqli_fetch_assoc($queryGastos)) {
    $totalGastosMateriales += $rowGastos['gasto'];
}
// Calcular el total de ingresos
$totalIngresos = 0;
while ($rowIngresos = mysqli_fetch_assoc($queryIngresos)) {
    $totalIngresos += $rowIngresos['total'];
}

// Calcular el total final sumando los gastos de planilla, gastos de materiales e ingresos
$totalFinal = $totalGastosPlanilla + $totalGastosMateriales - $totalIngresos;
?>
<div class="card m-4">
    <div class="card-body">
        <?php
            $sqlProyecto = "SELECT * FROM tproyectos WHERE id = '$idProyecto'";
            $queryProyecto = mysqli_query($conn, $sqlProyecto);
            
            while($rowProyecto = mysqli_fetch_assoc($queryProyecto)){
                ?>
                <div class="row text-center">
                    <div class="col-12">
                        <h5>Administracion del proyecto: <?=$rowProyecto['nombre']?></h5>
                        <hr>
                    </div>
                </div>
                <?php
            }
        ?>
        <div class="row">
            <div class="col-12 text-right mb-3">
                <a href="proyectos.php" class="btn btn-sm btn-dark"><i class="fas fa-fw fa-arrow-left"></i> Regresar </a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-sm table-striped table-bordered">
                <thead>
                    <th style="min-width:150px">
                        <a href="planilla.php?id_proyecto=<?=urlencode($idProyectoEncriptado)?>" class="btn-sm btn btn-outline-success"><i class="fas fa-fw fa-table"></i></a>
                        <a href="gastos.php?id_proyecto=<?=urlencode($idProyectoEncriptado)?>" class= "btn-sm btn btn-outline-success"><i class="fas fa-fw fa-building"></i></a>
                        <a href="ingresos.php?id_proyecto=<?=urlencode($idProyectoEncriptado)?>" class="btn-sm btn btn-outline-success"><i class="fas fa-fw fa-money-bill"></i></a>
                        <a href="reportes.php?id_proyecto=<?=$idProyecto?>" class="btn-sm btn btn-outline-danger"><i class="fas fa-fw fa-download"></i></a>
                    </th>
                    <th>Gasto de Planillas</th>
                    <th>Gasto de Materiales</th>
                    <th>Total de Ingresos</th>
                    <th>Subtotal</th>
                </thead>
                <tbody>
                    <tr>
                        <td style="min-width:150px">
                        </td>
                        <td><?=$totalGastosPlanilla?></td>
                        <td><?=$totalGastosMateriales?></td>
                        <td><?=$totalIngresos?></td>
                        <td><?=$totalFinal?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
include("../../template/bottom.php");
?>
