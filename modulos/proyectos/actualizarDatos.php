<?php
include("../../conn/conn.php");

$sqlProyectos = "SELECT p.id, p.nombre, p.descripcion, p.fechaini, p.fechafin, 
                 (SELECT SUM(gasto) FROM tgastos WHERE estado = 1 AND idProyecto = p.id) AS total_gastos, 
                 (SELECT SUM(total) FROM thoras WHERE estado = 1 AND idProyecto = p.id) AS total_planilla, 
                 (SELECT SUM(total) FROM tingresos WHERE estado = 1 AND idProyecto = p.id) AS total_ingresos
                 FROM tproyectos p
                 WHERE p.estado = 1";

$queryProyectos = mysqli_query($conn, $sqlProyectos);

$data = array();

while ($rowProyecto = mysqli_fetch_array($queryProyectos)) {
    $totalGastos = $rowProyecto['total_gastos'] + $rowProyecto['total_planilla'];

    $data[] = array(
        'nombre' => $rowProyecto['nombre'],
        'totalGastos' => $totalGastos,
        'totalIngresos' => $rowProyecto['total_ingresos'],
        'subtotal' => $rowProyecto['total_ingresos'] - $totalGastos
    );
}

echo json_encode($data);
?>
