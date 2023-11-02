<?php
// Donde veamos estos includes, es referente a partes del proyecto que se mostrarán por todo el sistema
include("../../conn/conn.php");

revisarPrivilegio(4);

// Aquí realizamos el método para eliminar el campo correspondiente
if (isset($_GET['id_eliminar'])) {
    $idEliminar = $_GET['id_eliminar'];

    $sqlEliminar = "UPDATE tproyectos SET estado = 2 WHERE id = '$idEliminar'";
    $queryEliminar = mysqli_query($conn, $sqlEliminar);

    header('location: proyectos.php');
    exit();
}

include("../../template/top.php");
?>

<div class="card m-4">
    <div class="card-body">
        <h5>Proyectos</h5>
        <hr>
        <div class="row mb-2">
            <div class="col-lg-12 text-right">
                <a href="nuevoproyectos.php" class="btn btn-sm btn-dark"><i class="fas fa-fw fa-plus"></i> Nuevo Proyecto</a>
            </div>
        </div>

        <?php
        $sqlClientes = "SELECT * FROM tproyectos WHERE estado = 1";
        $queryClientes = mysqli_query($conn, $sqlClientes);

        if (mysqli_num_rows($queryClientes) == 0) {
        ?>
            <div class="row text-center">
                <div class="col-12">
                    NO hay Proyectos
                </div>
            </div>
        <?php
        } else {
        ?>
            <div class="table-responsive">
                <table class="table table-sm table-striped table-bordered">
                    <thead class="text-dark">
                        <th>Acciones</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Fecha inicial</th>
                        <th>Fecha de finalización</th>
                    </thead>
                    <tbody>
                        <?php
                        while ($rowClientes = mysqli_fetch_array($queryClientes)) {

                            ?>
                            <tr>
                                <td style="min-width:150px">
                                    <a href="EPRO.php?id_editar=<?= $rowClientes['id'] ?>" class="btn-sm btn btn-outline-info"><i class="fa fa-fw fa-edit"></i></a>
                                    <!-- Agrega el SweetAlert2 -->
                                    <a href="#" class="btn-sm btn btn-danger" data-id="<?= $rowClientes['id'] ?>"><i class="fas fa-fw fa-trash"></i></a>
                                    <a href="administracion.php?id_proyecto=<?= $rowClientes['id'] ?>" class="btn-sm btn btn-outline-success"><i class="fas fa-fw fa-folder"></i></a>
                                </td>
                                <td><?= $rowClientes['nombre'] ?></td>
                                <td><?= $rowClientes['descripcion'] ?></td>
                                <td><?= $rowClientes['fechaini'] ?></td>
                                <td><?= $rowClientes['fechafin'] ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                // Agrega un evento click a todos los botones de eliminar
                const deleteButtons = document.querySelectorAll(".btn-danger");
                deleteButtons.forEach(function (deleteButton) {
                    deleteButton.addEventListener("click", function (event) {
                        // Previene el comportamiento predeterminado del enlace
                        event.preventDefault();

                        // Obtiene el ID del proyecto a eliminar
                        const idEliminar = this.dataset.id;

                        // Muestra un mensaje de confirmación con SweetAlert2
                        Swal.fire({
                            title: '¿Está seguro(a) que desea eliminar?',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Sí, eliminar!',
                            cancelButtonText: 'Cancelar'
                        }).then((result) => {
                            // Si el usuario hace clic en "Sí, eliminar!", redirige a la página de eliminación
                            if (result.isConfirmed) {
                                window.location.href = 'proyectos.php?id_eliminar=' + idEliminar;
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

<div class="card m-4">
    <div class="card-body">
        <h5>Gastos e Ingresos por Proyecto</h5>
        <hr>
        <div class="table-responsive">
            <table id="tabla-proyectos" class="table table-sm table-striped table-bordered">
                <thead class="text-dark">
                    <th>Proyecto</th>
                    <th>Total Gastos</th>
                    <th>Total Ingresos</th>
                    <th>Subtotal</th>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

    <div class="card-footer">
        <strong>Total: <span id="total-subtotal">0</span></strong>
    </div>
</div>

<style>
    .negativo {
        color: red;
    }

    .positivo {
        color: green;
    }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function actualizarTabla() {
        $.ajax({
            type: 'GET',
            url: 'actualizarDatos.php', // URL del archivo PHP que devuelve los datos actualizados
            dataType: 'json',
            success: function (data) {
                let totalSubtotal = 0; // Variable para almacenar la suma de subtotales

                // Limpia la tabla actual
                $('#tabla-proyectos tbody').empty();

                // Recorre los datos y actualiza la tabla
                $.each(data, function (index, proyecto) {
                    // Agrega la clase 'negativo' si el subtotal es negativo y 'positivo' si es positivo
                    const subtotalClass = (proyecto.subtotal < 0) ? 'negativo' : 'positivo';
                    $('#tabla-proyectos tbody').append(
                        '<tr>' +
                        '<td>' + proyecto.nombre + '</td>' +
                        '<td>' + '₡ ' + proyecto.totalGastos + '</td>' +
                        '<td>' + '₡ ' + proyecto.totalIngresos + '</td>' +
                        '<td class="' + subtotalClass + '">' + '₡ ' + proyecto.subtotal + '</td>' +
                        '</tr>'
                    );

                    // Suma el subtotal al totalSubtotal
                    totalSubtotal += parseFloat(proyecto.subtotal);
                });

                // Actualiza el total de subtotales en el elemento HTML
                $('#total-subtotal').text('₡' + totalSubtotal);
            }
        });
    }

    $(document).ready(function () {
        actualizarTabla();
        setInterval(actualizarTabla, 60000); // Actualizar cada 60 segundos
    });
</script>

<?php
include("../../template/bottom.php");
?>
