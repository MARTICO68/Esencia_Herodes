<?php 
//Donde veamos estos includes, es referente a partes del proyecto que se mostraran por todo el sistema
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
//Aqui realizamos el metodo para actualizar los datos en la BD
$idEditar = 0;
if (isset($_GET['id_editar'])){
    $idEditar = $_GET['id_editar'];
}
if (isset($_POST['guardar'])) {
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

    // Utiliza SweetAlert para mostrar un mensaje
    ?>
    <script> 
        Swal.fire({
            title: 'Plantilla Editada exitosamente',
            icon: 'success',
            showCancelButton: false,
            confirmButtonText: 'OK',
        }).then((result) => {
            if (result.isConfirmed) {
                document.location.href = "planilla.php?id_proyecto=<?= $idProyectoEncriptado ?>";
            }
        });
    </script>
    <?php
    exit();
}



?>
<div class="card m-4">
    <div class="card-body">
    <h5>Editar planilla</h5>
    <hr>

    <div class="row text-right">
    <div class="col-12">
        <a href="planilla.php?id_proyecto=<?= $idProyectoEncriptado ?>" class="btn btn-sm btn-dark"><i class="fas fa-fw fa-arrow-left"></i> Regresar</a>
    </div>
</div>

<form action="" method="post">

<div class="row">
    <div class="col-12 col-md-6">

        <?php 
            $sqlEditar = "SELECT * FROM thoras WHERE id = '$idEditar'";
            $queryEditar = mysqli_query($conn, $sqlEditar);
            while($rowEditar=mysqli_fetch_array($queryEditar)){
            ?>

            <form class="user" action="" method="post">
                <input type="hidden" value="<?=$rowEditar['id']?>" name="id">
                <div class="row">
                   <div class="col-12 col-md-6">
                    <label for="idEmpleado" class="animate__animated animate__slideInLeft">Empleado: </label>
                    <select class="form-control shadow-sm animate__animated animate__zoomIn" required type="number" name="idEmpleado" id="idEmpleado" autocomplete="off">
                        <?php 
                        $sqlidEmpleado = "SELECT * FROM templeados WHERE estado = 1";
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
                <body>
                <div class="row">
                    <div class="col-md-6">
                        <label for="numero" class="animate__animated animate__slideInLeft"># de cajuelas:</label>
                        <input type="text" id="numero" step="0.001" required type="number" oninput="calcular()" value="<?=$rowEditar['numero']?>" name="numero" class="form-control shadow-sm animate__animated animate__zoomIn">
                    </div>
                
                    <div class="col-md-6">
                        <label for="precio" class="animate__animated animate__slideInLeft">Precio por cajuela:</label>
                        <input type="text" id="precio" step="0.001" required type="number" oninput="calcular()" value="<?=$rowEditar['precio']?>" name="precio" class="form-control shadow-sm animate__animated animate__zoomIn">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label for="total" class="animate__animated animate__slideInLeft">Total:</label>
                        <input type="text" id="total" required type="number" value="<?=$rowEditar['total']?>" name="total" class="form-control shadow-sm animate__animated animate__zoomIn">
                    </div>
                </div>
                </body>
                <script type="text/javascript">

                function calcular(){
                try{ 
                var a = parseFloat(document.getElementById("numero").value) || 0,
                    b = parseFloat(document.getElementById("precio").value) || 0;
                    document.getElementById("total").value = a * b;
                } catch (e) {}

                }        
                </script> 
                </script> 
                <div class="row text-center m-4">
                    <div class="col-12">
                        <button type="submit" class="btn btn-dark btn-sm animate__animated animate__zoomIn" name="guardar"><i class="fas fa-fw fa-save"></i> Guardar</button>
                        <hr>
                    </div>
                </div>
            </form> 
            </div> 
            <div class="col-12 col-md-6 text-center">                                             
                <img class="img-fluid" src="<?=$baseURL?>img/material.gif" height="550px"><br>                                       
            </div>            
            <?php } ?>  
</div>
</div>

<?php 
include('../../template/bottom.php');
?>