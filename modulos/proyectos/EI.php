<?php 
include('../../conn/conn.php');
revisarPrivilegio(3);
$idProyecto = isset($_GET['id_proyecto']) ? $_GET['id_proyecto'] : ''; // Establece un valor predeterminado si no se proporciona en la URL
$idProyectoEncriptado = base64_encode($idProyecto);
if (isset($_GET['id_proyecto'])) {
 // Recupera el ID del proyecto desde la URL y desencripta usando base64_decode
 $idProyectoEncriptado = $_GET['id_proyecto'];
 $idProyecto = base64_decode($idProyectoEncriptado);

 // Ahora, $idProyecto contiene el ID del proyecto desencriptado y puedes utilizarlo en tu página.
}


$idEditar = 0;
if (isset($_GET['id_editar'])){
    $idEditar = $_GET['id_editar'];
}
if (isset($_POST['guardar'])){
    $id = $_POST['id'];
    $fecha = $_POST['fecha'];
    $numero = $_POST['numero'];
    $precio = $_POST['precio'];
    $total = $_POST['total'];
   
    $sqlClientes = "UPDATE tingresos SET 
    fecha = '$fecha',
    numero = '$numero',
    precio = '$precio',
    total = '$total'
    WHERE id = '$id'";
    $queryClientes = mysqli_query($conn, $sqlClientes);

    ?>
    <script>
        alert('El Empleado fue Editado exitosamente.');
        document.location.href = "ingresos.php?id_proyecto=<?= $idProyectoEncriptado ?>";
    </script>
    <?php
    exit();
}

$titulo = "Usuarios -> Editar Usuarios";
include('../../template/top.php');
?>

<div class="row text-right">
    <div class="col-12">
        <a href="ingresos.php?id_proyecto=<?= $idProyectoEncriptado ?>" class="btn btn-primary"><i class="fas fa-fw fa-arrow-left"></i> Regresar</a>
    </div>
</div>

<form action="" method="post">

<div class="row">
    <div class="col-12 col-md-8">

        <?php 
            $sqlEditar = "SELECT * FROM tingresos WHERE id = '$idEditar'";
            $queryEditar = mysqli_query($conn, $sqlEditar);
            while($rowEditar=mysqli_fetch_array($queryEditar)){
            ?>

            

                <input type="hidden" value="<?=$rowEditar['id']?>" name="id">
                

                <div class="row">
                    <div class="col-12 col-md-6">                                                
                        <label for="fecha">Fecha</label>
                        <input type="date" id="fecha" name="fecha" required type="text" value="<?=$rowEditar['fecha']?>" class="form-control" autocomplete="off">                   
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <label for="numero">Cantidad:</label>
                        <input type="text" id="numero" step="0.001" oninput="calcular()" value="<?=$rowEditar['numero']?>" name="numero" class="form-control">
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <label for="precio">Costo:</label>
                        <input type="text" id="precio" step="0.001" oninput="calcular()" value="<?=$rowEditar['precio']?>" name="precio" class="form-control">
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <label for="total">Gasto:</label>
                        <input type="text" id="total" value="<?=$rowEditar['total']?>" name="total" class="form-control">
                    </div>
                </div>

                <div class="row text-center m-4">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary" name="guardar"><i class="fas fa-fw fa-check"></i> Guardar</button>
                    </div>
                </div>
                
            

            <?php } ?>

        </div>

       

       <script type="text/javascript">

function calcular(){
try{ 
var a = parseFloat(document.getElementById("numero").value) || 0,
    b = parseFloat(document.getElementById("precio").value) || 0;
    document.getElementById("total").value = a * b;
} catch (e) {}

}        
</script>   
       
    </div>
</form>
<?php 
include('../../template/bottom.php');
?>