<?php
header("Content-Type: application/xls");
header("Content-Disposition: attachment; filename= planilla.xls");
$total = 0;
?>

<div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
                <th></th>
                <th>Nombre</th>
                <th>Fecha</th>
                <th>#</th>
                <th>precio</th>
                <th>total</th>
                <th>Sub</th>
            </thead>
            <tbody>
                <?php 
                include("../../conn/conn.php");
                $idProyecto = $_GET['id_proyecto'];
                $sql = "SELECT * FROM thoras WHERE estado = 1 AND idProyecto = '$idProyecto'";
                $query = mysqli_query($conn, $sql);
                while($rowClientes=mysqli_fetch_assoc($query)){ 
                ?>
                <tr>
                    <td style="min-width:150px">
                    <a href="editarPlanilla.php?id_editar=<?=$rowClientes['id']?>" class="btn-sm btn btn-dark"><i class="fa fa-fw fa-edit"></i></a>
                    <a href="planilla.php?id_eliminar=<?=$rowClientes['id']?>" onclick="return confirm('¿Está seguro(a) que desea eliminar?')" class="btn-sm btn btn-danger"><i class="fas fa-fw fa-trash"></i></a>
                    </td>
                    <td><?=$rowClientes['idEmpleado']?></td>
                    <td><?=$rowClientes['fecha']?></td>
                    <td><?=$rowClientes['precio']?></td>
                    <td><?=$rowClientes['total']?></td>
                    <td class="text-right">
                    
                </tr>
                <?php } ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="text-right"><strong>Total</strong></td>
                    <td class="text-right"><strong>&cent; <?=number_format($total,2)?></strong> </td>
                </tr>
            </tbody>
        </table>

</div>

