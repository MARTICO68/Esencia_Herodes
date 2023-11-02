<?php
include("../../conn/conn.php");
revisarPrivilegio(4);

$idProyecto = isset($_GET['id_proyecto']) ? $_GET['id_proyecto'] : '';
$idProyectoEncriptado = base64_encode($idProyecto);

if (isset($_GET['id_proyecto'])) {
    $idProyectoEncriptado = $_GET['id_proyecto'];
    $idProyecto = base64_decode($idProyectoEncriptado);
}

if (isset($_GET['id_eliminar'])) {
    $idEliminar = $_GET['id_eliminar'];

    $sqlEliminar = "UPDATE tgastos SET estado = 2 WHERE id = '$idEliminar'";
    $queryEliminar = mysqli_query($conn, $sqlEliminar);

    if ($queryEliminar) {
        ?>
        <script>
            Swal.fire({
                title: 'Eliminar registro',
                text: '¿Estás seguro(a) de eliminar este registro?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí',
                cancelButtonText: 'No',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'gastos.php?id_eliminar=<?=$idEliminar?>&id_proyecto=<?=urlencode($idProyectoEncriptado)?>';
                }
            });
        </script>
        <?php
    } else {
        ?>
        <script>
            Swal.fire({
                title: 'Error al eliminar',
                text: 'Ha ocurrido un error al eliminar el registro. Por favor, inténtalo de nuevo.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        </script>
        <?php
    }
}

$buscar = '';

if (isset($_GET['buscar'])) {
    $buscar = $_GET['buscar'];
}

$sql = "SELECT * FROM tgastos WHERE estado = 1 AND idProyecto = '$idProyecto'";
if (!empty($buscar)) {
    $sql .= " AND nombre LIKE '%$buscar%'";
}

$query = mysqli_query($conn, $sql);

$total = 0;
include("../../template/top.php");
?>

<div class="card m-4">
    <div class="card-body">
        <div class="row text-center">
            <div class="col-12">
                <h5>Gastos del proyecto</h5>
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
                    <a href="NG.php?id_proyecto=<?=urlencode($idProyectoEncriptado)?>" class="btn-sm btn btn-outline-success"><i class="fas fa-fw fa-plus"></i></a>
                    <br>              
                    <img class="img-fluid" src="<?=$baseURL?>img/nohay.gif" ><br>         
                    No hay gastos en este proyecto.  
                </div>
            </div>
            <?php
        } else {
            ?>
            <div class="table-responsive">
                <table class="table table-striped table-bordered" width="100%" cellspacing="0">
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
                            <td style="min-width:150px">
                                <a href="EG.php?id_editar=<?=$rowClientes['id']?>&id_proyecto=<?=urlencode($idProyectoEncriptado)?>" class="btn-sm btn btn-outline-info"><i class="fa fa-fw fa-edit"></i></a>
                                <a href="#" class="btn-sm btn btn-danger delete-record" data-id="<?=$rowClientes['id']?>"><i class="fas fa-fw fa-trash"></i></a>
                            </td>
                            <td><?=$rowClientes['nombre']?></td>
                            <td><?=$rowClientes['fecha']?></td>
                            <td><?=$rowClientes['cantidad']?></td>
                            <td><?=$rowClientes['costo']?></td>
                            <td><?=$rowClientes['gasto']?></td>
                            <td class="text-right">
                                <?php
                                echo '&cent; '.number_format($subtotal = $rowClientes['gasto'],2);
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
                            <td class="text-right"><strong>Total de Gastos</strong></td>
                            <td class="text-right"><strong>&cent; <?=number_format($total,2)?></strong> </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                const deleteButtons = document.querySelectorAll(".delete-record");
                deleteButtons.forEach(function (deleteButton) {
                    deleteButton.addEventListener("click", function (event) {
                        event.preventDefault();
                        const idEliminar = this.dataset.id;
                        Swal.fire({
                            title: '¿Estás seguro(a) de eliminar?',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Sí, eliminar!',
                            cancelButtonText: 'Cancelar'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = 'gastos.php?id_eliminar=' + idEliminar + '&id_proyecto=' + encodeURIComponent('<?=$idProyectoEncriptado?>');
                            }
                        });
                    });
                });
            </script>
        <?php
        }
        ?>
    </div>
</div>

<?php
include("../../template/bottom.php");
?>