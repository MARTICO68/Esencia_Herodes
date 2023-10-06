<?php
ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte</title>
    <!--<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap4">-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css">
</head>
<body>
<?php
include("../../conn/conn.php");
revisarPrivilegio(4);
$idProyecto = $_GET['id_proyecto'];
$sql = "SELECT * FROM tgastos WHERE estado = 1 AND idProyecto = '$idProyecto'";
$query = mysqli_query($conn, $sql);
?>
<h2 class="text-center">Reporte Economico</h2>
<div class="table-responsive">
<table class="table table-striped table-bordered">
                        <thead>
                            <th>
                            <th>Nombre</th>
                            <th>Fecha</th>
                            <th>Cantidad</th>
                            <th>Costo</th>   
                            <th>Gasto</th>
                            <th>Ingresos</th>                       
                            <th>Subtotal</th>
                            </th>
                        </thead>
                        <tbody>
                            <?php while($rowClientes=mysqli_fetch_assoc($query)){ ?>
                            <tr>
                                <td></td> 
                                                                                                                        
                                <td><?=$rowClientes['nombre']?></td>
                                <td><?=$rowClientes['fecha']?></td>
                                <td><?=$rowClientes['cantidad']?></td>
                                <td><?=$rowClientes['costo']?></td>
                                <td><?=$rowClientes['gasto']?></td>
                                <td><?=$rowClientes['ingresos']?></td>
                                <td class="text-right">
                                <?php
                                echo '&cent; '.number_format($subtotal = $rowClientes['ingresos'] - $rowClientes['gasto'],2);
                                $total += $subtotal;
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
                                <td></td>                                                          
                                <td class="text-right"><strong>Total de Gastos / Ganancias</strong></td>
                                <td class="text-right"><strong>&cent; <?=number_format($total,2)?></strong> </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
</body>
</html>

<?php

$html=ob_get_clean();
//echo $html;

require_once '../../libreria/dompdf/autoload.inc.php';
use Dompdf\Dompdf;
$dompdf = new Dompdf();

$options = $dompdf->getOptions();
$options->set(array('isRemoteEnable' => true));
$dompdf->setOptions($options);

$dompdf->loadHtml($html);

$dompdf->setPaper('letter');
//$dompdf->setPaper('A4', 'landscape');
$dompdf->render();

$dompdf->stream("archivo_.pdf", array("Attachment" => false));
?>
