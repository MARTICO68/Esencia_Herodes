<?php
//Donde veamos estos includes, es referente a partes del proyecto que se mostraran por todo el sistema
include("../../conn/conn.php");
revisarPrivilegio(4);

if (isset($_GET['id_eliminar'])) {
    $idEliminar = $_GET['id_eliminar'];
    $sqlEliminar = "UPDATE templeados SET estado = 2 WHERE id = '$idEliminar'";
    $queryEliminar = mysqli_query($conn, $sqlEliminar);
    if ($queryEliminar) {
        header('location: empleados.php');
        exit();
    } else {
        // Manejar error si la consulta de eliminación falla
        echo "Error al eliminar el registro: " . mysqli_error($conn);
    }
}

// Inicializa la variable $queryClientes
$queryClientes = null;

// Consulta SQL para mostrar todos los registros
$sqlClientes = "SELECT * FROM templeados WHERE estado = 1";
$queryClientes = mysqli_query($conn, $sqlClientes);

include("../../template/top.php");
?>
<div class="card m-4">
    <div class="card-body">
        <h5>Empleados</h5>
        <hr>
        <div class="row mb-2">
            <div class="col-lg-12 text-right">
                <a href="NE.php" class="btn btn-sm btn-dark"><i class="fas fa-fw fa-plus"></i> Nuevo Empleado</a>
            </div>
        </div>

        <form method="POST" action="" class="">
            <div class="row text-left mb-3">
                <div class="col-md-3">
                    <input type="text" id="buscar" placeholder="Buscar por nombre o identificacion" autocomplete="off" name="buscar" class="form-control shadow-sm animate__animated animate__zoomIn">
                </div>
                <div class="col-md-9">
                    <button type="submit" class="btn btn-sm btn-dark"><i class="fas fa-search"></i> Buscar</button>
                </div>
            </div>
        </form>
      
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $buscar = $_POST['buscar'];

            // Construye la consulta SQL basada en el campo de búsqueda
            $sqlClientes = "SELECT * FROM templeados WHERE estado = 1";

            if (!empty($buscar)) {
                $sqlClientes .= " AND (nombre LIKE '%$buscar%' OR identificacion LIKE '%$buscar%')";
            }

            $queryClientes = mysqli_query($conn, $sqlClientes);
        }
        ?>

        <?php
        if (mysqli_num_rows($queryClientes) == 0) {
            ?>
            <div calss="row text-center">
                <div class="col-12">
                    NO hay Empleados
                </div>
            </div>
            <?php
        } else {
            ?>
            <div class="table-responsive">
                <table class="table table-sm table-striped table-bordered">
                    <thead class="text-dark">
                        <th>Acciones</th>
                        <th>Identificación</th>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th>Puesto</th>
                        <th>Telefono</th>
                    </thead>
                    <tbody>
                        <?php
                        while ($rowClientes = mysqli_fetch_array($queryClientes)) {
                            ?>
                            <tr>
                                <td style="min-width:150px">
                                    <a href="EE.php?id_editar=<?=$rowClientes['id']?>" class="btn btn-sm btn-outline-info"><i class="fa fa-fw fa-edit"></i></a>
                                    <a href="#" class="btn btn-sm btn-danger delete-btn" data-id="<?=$rowClientes['id']?>"><i class="fas fa-fw fa-trash"></i></a>
                                </td>
                                <td><?=$rowClientes['identificacion']?></td>
                                <td><?=$rowClientes['nombre']?></td>
                                <td><?=$rowClientes['apellidos']?></td>
                                <td><?=$rowClientes['puesto']?></td>
                                <td><?=$rowClientes['telefono']?></td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <?php
        }
        ?>
    </div>
</div>

<script>
    // Agrega un evento click a todos los botones de eliminar
    const deleteButtons = document.querySelectorAll(".delete-btn");
    deleteButtons.forEach(function(deleteButton) {
        deleteButton.addEventListener("click", function(event) {
            event.preventDefault();
            const idEliminar = this.dataset.id;
            Swal.fire({
                title: '¿Está seguro(a) que desea eliminar el Empleado?',
                text: "Esta acción no se puede deshacer",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'empleados.php?id_eliminar=' + idEliminar;
                }
            });
        });
    });
</script>
<?php
include("../../template/bottom.php");
?>