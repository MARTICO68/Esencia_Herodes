<?php 
include('../../conn/conn.php');
revisarPrivilegio(3);
$idEditar = 0;
if (isset($_GET['id_editar'])){
    $idEditar = $_GET['id_editar'];
}
if (isset($_POST['guardar'])){
    $id = $_POST['id'];
    $idEmpleado = $_POST['idEmpleado'];
    $fecha = $_POST['fecha'];
    $numero = $_POST['numero'];
    $precio = $_POST['precio'];
    $total = $_POST['total'];
   
    $sqlClientes = "UPDATE thoras SET 
    idEmpleado = '$idEmpleado',
    fecha = '$fecha',
    numero = '$numero',
    precio = '$precio',
    total = '$total'
    WHERE id = '$id'";
    $queryClientes = mysqli_query($conn, $sqlClientes);

    ?>
    <script>
        alert('El Empleado fue Editado exitosamente.');
        document.location.href = 'proyectos.php';
    </script>
    <?php
    exit();
}

$titulo = "Usuarios -> Editar Usuarios";
include('../../template/top.php');
?>

<div class="row text-right">
    <div class="col-12">
        <a href="usuarios.php" class="btn btn-primary"><i class="fas fa-fw fa-arrow-left"></i> Regresar</a>
    </div>
</div>

<form action="" method="post">

<div class="row">
    <div class="col-12 col-md-8">

        <?php 
            $sqlEditar = "SELECT * FROM thoras WHERE id = '$idEditar'";
            $queryEditar = mysqli_query($conn, $sqlEditar);
            while($rowEditar=mysqli_fetch_array($queryEditar)){
            ?>

            

                <input type="hidden" value="<?=$rowEditar['id']?>" name="id">

                <div class="row">
                    <div class="col-12">
                        <label for="idEmpleado">Nombre:</label>
                        <input type="text" id="idEmpleado" value="<?=$rowEditar['idEmpleado']?>" name="idEmpleado" class="form-control">
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-md-6">                                                
                        <label for="fecha">Fecha</label>
                        <input type="date" id="fecha" name="fecha" required type="text" value="<?=$rowEditar['fecha']?>" class="form-control" autocomplete="off">                   
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <label for="numero">Numero:</label>
                        <input type="text" id="numero" step="0.001" oninput="calcular()" value="<?=$rowEditar['numero']?>" name="numero" class="form-control">
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <label for="precio">Precio:</label>
                        <input type="text" id="precio" step="0.001" oninput="calcular()" value="<?=$rowEditar['precio']?>" name="precio" class="form-control">
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <label for="total">Total:</label>
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