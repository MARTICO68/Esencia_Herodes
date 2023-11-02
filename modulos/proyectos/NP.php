<?php 
//Donde veamos estos includes, es referente a partes del proyecto que se mostraran por todo el sistema
   include("../../conn/conn.php");
   include("../../template/top.php");
   revisarPrivilegio(4);
   $idProyecto = isset($_GET['id_proyecto']) ? $_GET['id_proyecto'] : ''; // Establece un valor predeterminado si no se proporciona en la URL
   $idProyectoEncriptado = base64_encode($idProyecto);
   if (isset($_GET['id_proyecto'])) {
    // Recupera el ID del proyecto desde la URL y desencripta usando base64_decode
    $idProyectoEncriptado = $_GET['id_proyecto'];
    $idProyecto = base64_decode($idProyectoEncriptado);
}
//Aqui realizamos el metodo para guardar los datos en la BD
   if (isset($_POST['guardar'])){
    $idPro= $_POST['idProyecto'];
    $idEmpleado = $_POST['idEmpleado'];    
    $fecha = $_POST['fecha'];
    $numero = $_POST['numero'];  
    $precio = $_POST['precio'];
    $total = $_POST['total'];
   
        $sqlClientes = "INSERT INTO thoras (idProyecto, idEmpleado, fecha, numero, precio, total, estado) VALUES 
        ('$idProyecto', '$idEmpleado', '$fecha', '$numero', '$precio', '$total', 1)"; 
        $queryClientes = mysqli_query($conn, $sqlClientes);

        ?>
        <script>
        Swal.fire({
            title: 'Planilla guardada correctamente',
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
        <h5>Nueva planilla</h5>
        <hr>
    <div class="row text-right">
        <div class="col-12">
            <a href="planilla.php?id_proyecto=<?= $idProyectoEncriptado ?>" class="btn btn-sm btn-dark"><i class="fas fa-fw fa-arrow-left"></i> Regresar </a>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-md-6">
        
            <form class="user" action="" method="post">
                <input type="hidden" name="idProyecto" value="<?= $idProyecto ?>">

                <div class="row">
                   <div class="col-12 col-md-6">
                    <label for="idEmpleado" class="animate__animated animate__slideInLeft">Empleado: </label>
                    <select class="form-control shadow-sm animate__animated animate__zoomIn" name="idEmpleado" id="idEmpleado" autocomplete="off">
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
                    <div class="col-12 col-md-6">                                                
                        <label for="fecha" class="animate__animated animate__slideInLeft">Fecha</label>
                        <input type="date" id="fecha" name="fecha" required type="text" value="<?= $fecha?>" class="form-control shadow-sm animate__animated animate__zoomIn" autocomplete="off">                   
                    </div>
                </div>
                <body> 
                 
                <div class="row">
                    <div class="col-md-6">
                        <label for="numero" class="animate__animated animate__slideInLeft"># de cajuelas</label>
                        <input type="number" id="numero" step="0.001" oninput="calcular()" name="numero" required type="number" class="form-control shadow-sm animate__animated animate__zoomIn" autocomplete="off">
                    </div>
                
                    <div class="col-md-6">
                        <label for="precio" class="animate__animated animate__slideInLeft">Precio por cajuela</label>
                        <input type="number" id="precio" step="0.001" oninput="calcular()" name="precio" required type="number" class="form-control shadow-sm animate__animated animate__zoomIn" autocomplete="off">
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-6">
                        <label for="total" class="animate__animated animate__slideInLeft">Total</label>                    
                        <input type="number" id="total"  step="0.001" name="total" required type="number" class="form-control shadow-sm animate__animated animate__zoomIn" autocomplete="off">
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
                <div class="row text-center mt-4">
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
    </div>
    </div>
    </div>
    <?php 
    include("../../template/bottom.php");
    ?>