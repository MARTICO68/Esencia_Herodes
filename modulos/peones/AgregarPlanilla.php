
<?php 
include('../../conn/conn.php');

$idEditar = 0;
if (isset($_GET['id_editar'])){
    $idEditar = $_GET['id_editar'];
}

if (isset($_POST['guardar'])){
    $identificacion = $_POST['identificacion'];
    $fecha = $_POST['fecha'];
    $hora_entrada = $_POST['hora_entrada'];
    $hora_salida = $_POST['hora_salida'];
    $horas_trabajadas = $_POST['horas_trabajadas'];
    $precio_por_hora = $_POST['precio_por_hora'];
    $monto_total = $_POST['monto_total'];

    $sqlClientes = "INSERT INTO tplanillas 
    (identificacion, fecha, hora_entrada, hora_salida, horas_trabajadas, precio_por_hora, monto_total, estado) VALUES 
    ('$identificacion', '$fecha', '$hora_entrada', '$hora_salida', '$horas_trabajadas', '$precio_por_hora', '$monto_total', 1)";
    $queryClientes = mysqli_query($conn, $sqlClientes);

    ?>
    <script>
        alert('La planilla fue guardada exitosamente.');
        document.location.href = 'peones.php';
    </script>
    <?php
    exit();
}

if (isset($_GET['id_eliminar'])){
    $idEliminar = $_GET['id_eliminar'];

    $sqlEliminar = "UPDATE tplanillas SET estado = 2 WHERE id = '$idEliminar'";
    $queryEliminar = mysqli_query($conn, $sqlEliminar);

    header('location: peones.php');
    exit();
}

$titulo = "Agregar planilla peones";
include('../../template/top.php');
?>

<div class="row text-right">
    <div class="col-12">
        <a href="peones.php" class="btn btn-primary animate__animated animate__zoomIn"><i class="fas fa-fw fa-arrow-left"></i> Regresar</a>
    </div>
</div>

<div class="row">
    <div class="col-12">

    <?php 
        $sqlEditar = "SELECT * FROM tpeones WHERE identificacion = '$idEditar'";
        $queryEditar = mysqli_query($conn, $sqlEditar);
        while($rowEditar=mysqli_fetch_array($queryEditar)){
        ?>

        <form action="" method="post">

            <input type="hidden" value="<?=$rowEditar['id']?>" name="id">

            <div class="row">
                <div class="col-12">
                    <label for="identificacion" class="animate__animated animate__slideInLeft" ><i class="fas fa-fw fa-id-card animate__animated animate__slideInLeft"></i> Identificación:</label>
                    <input type="text" id="identificacion" value="<?=$rowEditar['identificacion']?>" name="identificacion" class="form-control shadow-sm animate__animated animate__zoomIn" readonly>

                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <label for="nombre" class="animate__animated animate__slideInLeft"><i class="fas fa-fw fa-user animate__animated animate__slideInLeft"></i> Nombre:</label>
                    <input type="text" id="nombre" value="<?=$rowEditar['nombre']?>" name="nombre" class="form-control shadow-sm animate__animated animate__zoomIn" readonly>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <label for="apellidos" class="animate__animated animate__slideInLeft"><i class="far fa-fw fa-user-circle animate__animated animate__slideInLeft"></i> Apellidos:</label>
                    <input type="text" id="apellidos" value="<?=$rowEditar['apellidos']?>" name="apellidos" class="form-control shadow-sm animate__animated animate__zoomIn" readonly>
                </div>
            </div>


            <div class="row">
                <div class="col-12">
                    <label for="telefono" class="animate__animated animate__slideInLeft"><i class="fas fa-fw fa-phone animate__animated animate__slideInLeft"></i> Teléfono: </label>
                    <input type="text" id="telefono" value="<?=$rowEditar['telefono']?>" name="telefono" class="form-control shadow-sm animate__animated animate__zoomIn" readonly>
                </div>
            </div>


            <div class="row">
                <div class="col-12">
                    <label for="fecha" class="animate__animated animate__slideInLeft"><i class="fas fa-fw fa-calendar-alt animate__animated animate__slideInLeft"></i>Fecha: </label>
                    <input type="date" id="fecha" name="fecha" required class="form-control shadow-sm animate__animated animate__zoomIn">
                </div>
            </div>


            <div class="row">
                <div class="col-6">
                    <label for="hora_entrada" class="animate__animated animate__slideInLeft"><i class="far fa-fw fa-clock"></i> Hora de entrada: </label>
                    <input type="time" id="hora_entrada" name="hora_entrada" required class="form-control shadow-sm animate__animated animate__slideInLeft">
                </div>
                <div class="col-6">
                    <label for="hora_salida" class="animate__animated animate__slideInRight"><i class="far fa-fw fa-clock"></i> Hora de salida: </label>
                    <input type="time" id="hora_salida" name="hora_salida" required class="form-control shadow-sm animate__animated animate__slideInRight">
                </div>
            </div>

            
            <div class="row">
                <div class="col-12">
                    <label for="precio_por_hora" class="animate__animated animate__slideInLeft"><i class="fas fa-fw fa-dollar-sign"></i> Salario por hora: </label>
                    <input type="number" id="precio_por_hora" name="precio_por_hora" required  class="form-control shadow-sm animate__animated animate__zoomIn" step="0.01" min="0">
                </div>
            </div>


            <div class="row animate__animated animate__zoomIn">
                <div class="col-12">
                    <label for="horas_trabajadas" class="animate__animated animate__slideInLeft"><i class="fas fa-fw fa-clock animate__animated animate__slideInLeft"></i>Horas trabajadas:</label>
                    <input type="text" id="horas_trabajadas" name="horas_trabajadas" class="form-control shadow-sm" readonly>
                </div>
            </div>

            <div class="row animate__animated animate__zoomIn">
                <div class="col-12">
                    <label for="monto_total"><i class="fas fa-fw fa-dollar-sign"></i> Monto total:</label>
                    <input type="text" id="monto_total" name="monto_total" class="form-control shadow-sm" readonly>
                </div>
            </div>


            <div class="row text-center m-4">
                <div class="col-12">
                    <button type="submit" class="btn btn-primary animate__animated animate__zoomIn" name="guardar" ><i class="fas fa-fw fa-check animate__animated animate__zoomIn"></i> Guardar</button>
                </div>
            </div>
            
        </form>
        
        
        <?php } ?>

    </div>
</div>


<?php
$sqlClientes = "SELECT * FROM tplanillas WHERE identificacion = $idEditar AND estado = 1";
$queryClientes = mysqli_query($conn, $sqlClientes);

// comprobar si se ha enviado el formulario de filtro de fechas
if(isset($_POST['submit_filtro'])){
    $fechaInicio = $_POST['fecha_inicio'];
    $fechaFin = $_POST['fecha_fin'];
    
    // construir la consulta SQL con el filtro de fechas
    $sqlPlanillas = "SELECT * FROM tplanillas WHERE estado = 1 AND identificacion = '$idEditar' AND fecha >= '$fechaInicio' AND fecha <= '$fechaFin' ORDER BY fecha DESC";
}else{
    $fechaInicio = "";
    $fechaFin = "";
    
    // construir la consulta SQL sin filtro de fechas
    $sqlPlanillas = "SELECT * FROM tplanillas WHERE estado = 1 AND identificacion = '$idEditar' ORDER BY fecha DESC";
}

$queryPlanillas = mysqli_query($conn, $sqlPlanillas);

if (mysqli_num_rows($queryPlanillas) == 0){
?>
<div class="row text-center">
    <div class="col-12">
        NO HAY Planillas
    </div>
</div>
<?php
}else{
    // variable para acumular el monto total
    $total = 0;
}
?>
<div class="row">
    <div class="col-12">
        <form method="post">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="fecha_inicio" class="animate__animated animate__slideInLeft"><i class="fas fa-fw fa-calendar-alt animate__animated animate__slideInLeft"></i>Fecha inicio:</label>
                    <input type="date" class="form-control shadow-sm animate__animated animate__zoomIn" id="fecha_inicio" name="fecha_inicio" value="<?=$fechaInicio?>" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="fecha_fin" class="animate__animated animate__slideInLeft"><i class="fas fa-fw fa-calendar-alt animate__animated animate__slideInLeft"></i>Fecha fin:</label>
                    <input type="date" class="form-control shadow-sm animate__animated animate__zoomIn" id="fecha_fin" name="fecha_fin" value="<?=$fechaFin?>" required>
                </div>
                <div class="form-group col-md-4 align-self-end">
                    <button type="submit" class="btn btn-primary animate__animated animate__zoomIn" name="submit_filtro">Filtrar</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-striped animate__animated animate__zoomIn">
        <thead>
            <tr>
                <th>Identificación</th>
                <th>Fecha</th>
                <th>Hora de entrada</th>
                <th>Hora de salida</th>
                <th>Horas trabajadas</th>
                <th>Precio por hora</th>
                <th>Monto total</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                $total = 0;
                while($rowPlanillas=mysqli_fetch_array($queryPlanillas)){
                    $montoTotal = $rowPlanillas['monto_total'];
                    $total += $montoTotal; // acumular el monto total
                   
                    ?>
                    <tr>
                        <td><?=$rowPlanillas['identificacion']?></td>
                        <td><?=$rowPlanillas['fecha']?></td>
                        <td><?=$rowPlanillas['hora_entrada']?></td>
                        <td><?=$rowPlanillas['hora_salida']?></td>
                        <td><?=$rowPlanillas['horas_trabajadas']?></td>
                        <td>$<?=number_format($rowPlanillas['precio_por_hora'], 2)?></td>
                        <td>$<?=number_format($montoTotal, 2)?></td>

                        <td>
                              <a href="AgregarPlanilla.php?id_eliminar=<?=$rowPlanillas['id']?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Está seguro de que desea eliminar esta planilla?')"><i class="fas fa-fw fa-trash-alt"></i></a>
                        </td>
                    </tr>
                    <?php
                }
                
                // imprimir la fila con el total acumulado
                ?>
                
                <tr>
                    <td colspan="6" align="right"><strong>DEBO:</strong></td>
                    <td><b>$<?=number_format($total, 2)?></b></td>
                    <td></td>
                </tr>
                <?php
            ?>
        </tbody>
    </table>
</div>




<?php

?>




<script>
  // Obtener los campos
  var horaEntradaInput = document.getElementById("hora_entrada");
  var horaSalidaInput = document.getElementById("hora_salida");
  var salarioHoraInput = document.getElementById("precio_por_hora");
  var montoTotalInput = document.getElementById("monto_total");
  var horasTrabajadasInput = document.getElementById("horas_trabajadas");

  // Agregar un listener de cambio a los campos
  horaEntradaInput.addEventListener("input", calcularMontoTotal);
  horaSalidaInput.addEventListener("input", calcularMontoTotal);
  salarioHoraInput.addEventListener("input", calcularMontoTotal);

  function calcularMontoTotal() {
    // Obtener los valores de los campos
    var horaEntrada = horaEntradaInput.valueAsNumber;
    var horaSalida = horaSalidaInput.valueAsNumber;
    var salarioHora = salarioHoraInput.valueAsNumber;

    // Calcular la diferencia de tiempo en milisegundos
    var tiempoTrabajado = horaSalida - horaEntrada;

    // Convertir la diferencia de tiempo a horas
    var horasTrabajadas = tiempoTrabajado / (1000 * 60 * 60);

    // Calcular el monto total
    var montoTotal = horasTrabajadas * salarioHora;

    // Mostrar el monto total en el campo correspondiente
    montoTotalInput.value = montoTotal.toFixed(2);

    // Calcular las horas trabajadas
    var horasTrabajadas = tiempoTrabajado / (1000 * 60 * 60);

    // Mostrar las horas trabajadas en el campo correspondiente
    horasTrabajadasInput.value = horasTrabajadas.toFixed(2);
  }
</script>

<?php 
include('../../template/bottom.php');
?>