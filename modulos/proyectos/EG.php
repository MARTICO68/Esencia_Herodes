<?php 
include('../../conn/conn.php');
include('../../template/top.php');
revisarPrivilegio(3);
$idProyecto = isset($_GET['id_proyecto']) ? $_GET['id_proyecto'] : ''; // Establece un valor predeterminado si no se proporciona en la URL
$idProyectoEncriptado = base64_encode($idProyecto);
if (isset($_GET['id_proyecto'])) {
 // Recupera el ID del proyecto desde la URL y desencripta usando base64_decode
 $idProyectoEncriptado = $_GET['id_proyecto'];
 $idProyecto = base64_decode($idProyectoEncriptado);

}


$idEditar = 0;
if (isset($_GET['id_editar'])){
    $idEditar = $_GET['id_editar'];
}
if (isset($_POST['guardar'])){
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $fecha = $_POST['fecha'];
    $cantidad = $_POST['cantidad'];
    $costo = $_POST['costo'];
    $gasto = $_POST['gasto'];
   
    $sqlClientes = "UPDATE tgastos SET 
    nombre = '$nombre',
    fecha = '$fecha',
    cantidad = '$cantidad',
    costo = '$costo',
    gasto = '$gasto'
    WHERE id = '$id'";
    $queryClientes = mysqli_query($conn, $sqlClientes);

    ?>
    <script>
        Swal.fire({
            title: 'Gasto Editado exitosamente',
            icon: 'success',
            showCancelButton: false,
            confirmButtonText: 'OK',
        }).then((result) => {
            if (result.isConfirmed) {
                document.location.href = "gastos.php?id_proyecto=<?= $idProyectoEncriptado ?>";
            }
        });
    </script>
    <?php
    exit();
}



?>
<div class="card m-4">
    <div class="card-body">
        <h5>Editar gastos</h5>
        <hr>
<div class="row text-right">
    <div class="col-12">
        <a href="gastos.php?id_proyecto=<?= $idProyectoEncriptado ?>" class="btn btn-sm btn-dark"><i class="fas fa-fw fa-arrow-left"></i> Regresar</a>
    </div>
</div>

<form action="" method="post">

<div class="row">
    <div class="col-12 col-md-6">

        <?php 
            $sqlEditar = "SELECT * FROM tgastos WHERE id = '$idEditar'";
            $queryEditar = mysqli_query($conn, $sqlEditar);
            while($rowEditar=mysqli_fetch_array($queryEditar)){
            ?>
            <form class="user" action="" method="post">
                <input type="hidden" value="<?=$rowEditar['id']?>" name="id">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <label for="nombre" class="animate__animated animate__slideInLeft">Materiales: </label>
                        <select class="form-control shadow-sm animate__animated animate__zoomIn" name="nombre" id="nombre" autocomplete="off">
                        <?php 
                        $sqlidEmpleado = "SELECT * FROM tinventario WHERE estado = 1";
                        $queryidEmpleado = mysqli_query($conn, $sqlidEmpleado);
                        while($rowidEmpleado = mysqli_fetch_array($queryidEmpleado)){
                            ?>
                            <option value="<?=$rowidEmpleado['nombre']?>"><?=$rowidEmpleado['nombre']?></option>
                            <?php
                        }
                        ?>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">                                                
                        <label for="fecha" class="animate__animated animate__slideInLeft">Fecha</label>
                        <input type="date" id="fecha" name="fecha" required type="text" value="<?=$rowEditar['fecha']?>" class="form-control shadow-sm animate__animated animate__zoomIn" autocomplete="off">                   
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label for="cantidad" class="animate__animated animate__slideInLeft">Cantidad:</label>
                        <input type="text" id="cantidad" step="0.001" oninput="calcular()" value="<?=$rowEditar['cantidad']?>" name="cantidad" class="form-control shadow-sm animate__animated animate__zoomIn">
                    </div>
                
                    <div class="col-md-6">
                        <label for="costo" class="animate__animated animate__slideInLeft">Costo:</label>
                        <input type="text" id="costo" step="0.001" oninput="calcular()" value="<?=$rowEditar['costo']?>" name="costo" class="form-control shadow-sm animate__animated animate__zoomIn">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label for="gasto" class="animate__animated animate__slideInLeft">Gasto:</label>
                        <input type="text" id="gasto" value="<?=$rowEditar['gasto']?>" name="gasto" class="form-control shadow-sm animate__animated animate__zoomIn">
                    </div>
                </div>

                <script type="text/javascript">

                function calcular(){
                try{ 
                var a = parseFloat(document.getElementById("cantidad").value) || 0,
                    b = parseFloat(document.getElementById("costo").value) || 0;
                    document.getElementById("gasto").value = a * b;
                } catch (e) {}

                }        
                </script>
                </script>

                <div class="row text-center m-4">
                    <div class="col-12">
                        <button type="submit" class="btn btn-sm btn-dark shadow-sm animate__animated animate__zoomIn" name="guardar"><i class="fas fa-fw fa-save"></i> Guardar</button>
                        <hr>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-12 col-md-6 text-center">                                             
            <img class="img-fluid" src="<?=$baseURL?>img/proyecto.gif" height="550px"><br>                                       
        </div>
                
        <?php } ?>
    </div>
           
    </div>

</div>
</div>
<?php 
include('../../template/bottom.php');
?>