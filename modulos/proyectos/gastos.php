<?php
include("../../conn/conn.php");
revisarPrivilegio(4);
$fecha_de = '';
$fecha_a = '';
$idProyecto = isset($_GET['id_proyecto']) ? $_GET['id_proyecto'] : '';

if (isset($_GET['id_eliminar'])){
    $idEliminar = $_GET['id_eliminar'];

    $sqlEliminar = "UPDATE tgastos SET estado = 2 WHERE id = '$idEliminar'";
    $queryEliminar = mysqli_query($conn, $sqlEliminar);

    header('location: proyectos.php?id_proyecto');
    exit();
}
$total = 0;
include("../../template/top.php");
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
        $idProyecto = $_GET['id_proyecto'];
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
                <a href="planilla.php?id_proyecto=<?=urlencode($_GET['id_proyecto'])?>" class="btn btn-dark"><i class="fas fa-fw fa-arrow-left"></i> Regresar</a>
            </div>
        </div>
        <?php
            $sql = "SELECT * FROM tgastos WHERE estado = 1 AND idProyecto = '$idProyecto'";
            $query = mysqli_query($conn, $sql);
            if (mysqli_num_rows($query) == 0){
                ?>
                <div class="row text-center">
                    <div class="col-12">       
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
                            <a href="NG.php?id_proyecto=<?=urlencode($idProyecto)?>" class="btn-sm btn btn-outline-success"><i class="fas fa-fw fa-plus"></i></a>
                            <a href="reportes.php?<?=urlencode('id_proyecto=' .$_GET['id_proyecto'])?>" class="btn-sm btn btn-outline-danger"><i class="fas fa-fw fa-download"></i></a>
                            </th>
                            <th>Nombre</th>
                            <th>Fecha</th>
                            <th>Cantidad</th>   
                            <th>Costo</th>
                            <th>Gasto</th>
                            <th>Ingresos</th>                       
                            <th>Subtotal</th>                          
                        </thead>
                        <tbody>
                            <?php while($rowClientes=mysqli_fetch_assoc($query)){ ?>
                            <tr>
                                <td style="min-width:150px ">
                                <a href="EG.php?<?=urlencode('id_editar=' .$rowClientes['id'])?>" class="btn-sm btn btn-outline-dark"><i class="fa fa-fw fa-edit"></i></a>
                                <a href="gastos.php?id_eliminar=<?=$rowClientes['id']?>" onclick="return confirm('¿Está seguro(a) que desea eliminar?')" class="btn-sm btn btn-danger"><i class="fas fa-fw fa-trash"></i></a>
                                </td>                               
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
                
    </div>
</div>

<?php
}
include("../../template/bottom.php");
?>