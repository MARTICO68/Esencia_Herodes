<?php
include("../../conn/conn.php");
include("../../template/top.php");
revisarPrivilegio(4);

$idProyecto = isset($_GET['id_proyecto']) ? $_GET['id_proyecto'] : '';
$idProyectoEncriptado = base64_encode($idProyecto);

if (isset($_GET['id_proyecto'])) {
    $idProyectoEncriptado = $_GET['id_proyecto'];
    $idProyecto = base64_decode($idProyectoEncriptado);
}

if (isset($_GET['id_eliminar'])) {
    $idEliminar = $_GET['id_eliminar'];

    $sqlEliminar = "UPDATE tingresos SET estado = 2 WHERE id = '$idEliminar'";
    $queryEliminar = mysqli_query($conn, $sqlEliminar);

    if ($queryEliminar) {
        ?>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Swal.fire({
                title: 'Eliminación Exitosa',
                text: 'El registro de ingreso ha sido eliminado con éxito.',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'ingresos.php?id_proyecto=<?= $idProyectoEncriptado ?>';
                }
            });
        </script>
        <?php
    } else {
        ?>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Swal.fire({
                title: 'Error al eliminar el registro',
                text: 'Ha ocurrido un error al intentar eliminar el registro de ingreso.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        </script>
        <?php
    }
    exit();
}

$buscar = '';

if (isset($_GET['buscar'])) {
    $buscar = $_GET['buscar'];
}

$sql = "SELECT * FROM tingresos WHERE estado = 1 AND idProyecto = '$idProyecto'";

if (!empty($buscar)) {
    $sql .= " AND idProyecto LIKE '%$buscar%'";
}

$query = mysqli_query($conn, $sql);
$total = 0;
?>

<div class="card m-4">
    <div class="card-body">
        <div class= "row text-center">
            <div class="col-12">
                <h5>Ingresos</h5>
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col-12 text-right p-2 mb-2">
                <a href="administracion.php?id_proyecto=<?= urlencode($idProyecto) ?>" class="btn btn-sm btn-dark"><i class="fas fa-fw fa-arrow-left"></i> Regresar </a>
            </div>
        </div>

        <form action="" method="get">
            <div class="row text-left mb-3">
                <div class="col-md-3">
                    <input type="text" name="buscar" placeholder="Buscar por nombre" class="form-control" autocomplete="off" value="<?= $buscar ?>">
                </div>
                <div class="col-md-9">
                    <button type="submit" class="btn btn-sm btn-dark"><i class="fas fa-search"></i> Buscar</button>
                </div>
            </div>
        </form>

        <?php
        if (mysqli_num_rows($query) == 0) {
            ?>
            <div class="row text-center">
                <div class="col-12">
                    <a href="NI.php?id_proyecto=<?= urlencode($idProyectoEncriptado) ?>" class="btn-sm btn btn-outline-success"><i class="fas fa-fw fa-plus"></i></a>
                    <br>
                    <img class="img-fluid" src="<?= $baseURL ?>img/nohay.gif"><br>
                    No hay registros de ingresos.
                </div>
            </div>
            <?php
        } else {
            ?>
            <div class="table-responsive">
                <table class="table table-striped table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <th style="min-width:150px">
                            <a href="NI.php?id_proyecto=<?= urlencode($idProyectoEncriptado) ?>" class="btn-sm btn btn-outline-success"><i class="fas fa-fw fa-plus"></i></a>
                            <a href="reportesPla.php?<?= urlencode('id_proyecto=' . $_GET['id_proyecto']) ?>" class="btn-sm btn btn-outline-danger"><i class="fas fa-fw fa-download"></i></a>
                        </th>
                        <th>Fecha</th>
                        <th># fanegas</th>
                        <th>Precio</th>
                        <th>Total</th>
                        <th>Subtotal</th>
                    </thead>
                    <tbody>
                        <?php while ($rowClientes = mysqli_fetch_assoc($query)) { ?>
                            <tr>
                                <td style="min-width:150px">
                                    <a href="EI.php?id_editar=<?= $rowClientes['id'] ?>&id_proyecto=<?= urlencode($idProyectoEncriptado) ?>"
                                        class="btn-sm btn btn-outline-info"><i class="fa fa-fw fa-edit"></i></a>
                                        <a href="#" class="btn-sm btn btn-danger delete-record" data-id="<?=$rowClientes['id']?>"><i class="fas fa-fw fa-trash"></i></a>
                                </td>
                                <td><?= $rowClientes['fecha'] ?></td>
                                <td><?= $rowClientes['numero'] ?></td>
                                <td><?= $rowClientes['precio'] ?></td>
                                <td><?= $rowClientes['total'] ?></td>
                                <td class="text-right">
                                    <?php
                                    echo '&cent; ' . number_format($subtotal = $rowClientes['total'], 2);
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
                            <td class="text-right"><strong>Total</strong></td>
                            <td class="text-right"><strong>&cent; <?= number_format($total, 2) ?></strong> </td>
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
                            title: '¿Está seguro(a) de eliminar?',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Sí, eliminar!',
                            cancelButtonText: 'Cancelar'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = 'ingresos.php?id_eliminar=' + idEliminar + '&id_proyecto=' + encodeURIComponent('<?= $idProyectoEncriptado ?>');
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
