<?php
//Donde veamos estos includes, es referente a partes del proyecto que se mostraran por todo el sistema
include("../../conn/conn.php");
revisarPrivilegio(4);
$idProyecto = isset($_GET['id_proyecto']) ? $_GET['id_proyecto'] : '';
$idProyectoEncriptado = base64_encode($idProyecto);
if (isset($_GET['id_proyecto'])) {
    // Recupera el ID del proyecto desde la URL y desencripta usando base64_decode
    $idProyectoEncriptado = $_GET['id_proyecto'];
    $idProyecto = base64_decode($idProyectoEncriptado);
}
//Aqui realizamos el metodo para eliminar el campo correspondiente
if (isset($_GET['id_eliminar'])){
    $idEliminar = $_GET['id_eliminar'];

    $sqlEliminar = "UPDATE thoras SET estado = 2 WHERE id = '$idEliminar'";
    $queryEliminar = mysqli_query($conn, $sqlEliminar);

    header("location: planilla.php?id_proyecto=$idProyectoEncriptado");
    exit();
}
include("../../template/top.php");
$buscar = '';

if (isset($_GET['buscar'])) {
    $buscar = $_GET['buscar'];
}
// Consulta SQL para buscar registros
$sql = "SELECT * FROM thoras WHERE estado = 1 AND idProyecto = '$idProyecto'";
if (!empty($buscar)) {
    // Modifica la consulta para buscar por nombre
    $sql .= " AND idEmpleado LIKE '%$buscar%'";
}
$query = mysqli_query($conn, $sql);
$total = 0; // Inicializa la variable $total
?>

<div class="card m-4">
    <div class="card-body">
        <div class="row text-center">
            <div class="col-12">
                <h5>Registro de Horas de Trabajo</h5>
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col-12 text-right mb-3">
                <a href="administracion.php?id_proyecto=<?=urlencode($idProyecto)?>" class="btn btn-sm btn-dark"><i class="fas fa-fw fa-arrow-left"></i> Regresar </a>
            </div>
        </div>

        <form action="" method="get">
            <div class="row text-left mb-3">
                <div class="col-3">
                    <input type="text" name="buscar" placeholder="Buscar por nombre" class="form-control" autocomplete="off" value="<?=$buscar?>">
                </div>
                <div class="col-9">
                    <button type="submit" class="btn btn-sm btn-dark"><i class="fas fa-search"></i> Buscar</button>
                </div>
            </div>
        </form>

        <?php
        if (mysqli_num_rows($query) == 0){
            ?>
            <div class="row text-center">
                <div class="col-12">
                    <a href="NP.php?id_proyecto=<?=urlencode($idProyectoEncriptado)?>" class="btn-sm btn btn-outline-success"><i class="fas fa-fw fa-plus"></i></a> 
                    <br>              
                    <img class="img-fluid" src="<?=$baseURL?>img/nohay.gif" ><br>         
                    No hay registros de horas de trabajo.  
                </div>
            </div>
            <?php
        } else {
            ?>
            <div class="table-responsive">
                <table class="table table-striped table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <th style="min-width:150px">
                            <a href="NP.php?id_proyecto=<?=urlencode($idProyectoEncriptado)?>" class="btn-sm btn btn-outline-success"><i class="fas fa-fw fa-plus"></i></a>
                            <a href="reportesPla.php?<?=urlencode('id_proyecto=' .$_GET['id_proyecto'])?>" class="btn-sm btn btn-outline-danger"><i class="fas fa-fw fa-download"></i></a>
                        </th>
                        <th>Nombre</th>
                        <th>Fecha</th>
                        <th># de cajuelas / fanegas</th>
                        <th>Precio</th>
                        <th>Total</th>
                        <th>Subtotal</th>
                    </thead>
                    <tbody>
                        <?php while($rowClientes=mysqli_fetch_assoc($query)){ ?>
                        <tr>
                            <td style="min-width:150px">
                                <a href="EP.php?id_editar=<?=$rowClientes['id']?>&id_proyecto=<?=urlencode($idProyectoEncriptado)?>" class="btn-sm btn btn-outline-info"><i class="fa fa-fw fa-edit"></i></a>
                                <a href="planilla.php?id_eliminar=<?=$rowClientes['id']?>&id_proyecto=<?=urlencode($idProyectoEncriptado)?>" onclick="return confirm('¿Está seguro(a) que desea eliminar?')" class="btn-sm btn btn-danger"><i class="fas fa-fw fa-trash"></i></a>
                            </td>
                            <td><?=$rowClientes['idEmpleado']?></td>
                            <td><?=$rowClientes['fecha']?></td>
                            <td><?=$rowClientes['numero']?></td>
                            <td><?=$rowClientes['precio']?></td>
                            <td><?=$rowClientes['total']?></td>
                            <td class="text-right">
                                <?php
                                //metodo para sumar el total
                                echo '&cent; '.number_format($subtotal = $rowClientes['total'],2);
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
                            <td class="text-right"><strong>Total</strong></td>
                            <td class="text-right"><strong>&cent; <?=number_format($total,2)?></strong> </td>
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
