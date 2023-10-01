<?php 
include('../../conn/conn.php');

$idEditar = 0;
if (isset($_GET['id_editar'])){
    $idEditar = $_GET['id_editar'];
}

if (isset($_POST['guardar'])){
    $id = $_POST['id'];
    $identificacion = $_POST['identificacion'];
    $tipo = $_POST['tipo'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    $direccion = $_POST['direccion'];
    $sucursal = $_POST['sucursal'];

    $sqlClientes = "UPDATE tclientes SET 
    identificacion = '$identificacion',
    tipo = '$tipo',
    nombre = '$nombre',
    apellidos = '$apellidos',
    telefono = '$telefono',
    email = '$email',
    direccion = '$direccion',
    idSucursal = '$sucursal' 
    WHERE id = '$id'";
    $queryClientes = mysqli_query($conn, $sqlClientes);

    ?>
    <script>
        alert('El cliente fue guardado exitosamente.');
        document.location.href = 'clientes.php';
    </script>
    <?php
    exit();
}

$titulo = "Clientes -> Editar cliente";
include('../../template/top.php');
?>

<div class="row text-right">
    <div class="col-12">
        <a href="clientes.php" class="btn btn-primary"><i class="fas fa-fw fa-arrow-left"></i> Regresar</a>
    </div>
</div>

<div class="row">
    <div class="col-12">

    <?php 
        $sqlEditar = "SELECT * FROM tclientes WHERE id = '$idEditar'";
        $queryEditar = mysqli_query($conn, $sqlEditar);
        while($rowEditar=mysqli_fetch_array($queryEditar)){
        ?>

        <form action="" method="post">

            <input type="hidden" value="<?=$rowEditar['id']?>" name="id">

            <div class="row">
                <div class="col-12">
                    <label for="identificacion">Identificación: </label>
                    <input type="text" id="identificacion" value="<?=$rowEditar['identificacion']?>" name="identificacion" class="form-control">
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-md-4">
                    <label for="tipo">Tipo: </label>
                    <select name="tipo" id="tipo" class="form-control">
                        <option value="1" <?php if ($rowEditar['tipo'] == 1){echo 'selected="selected"';} ?> >Física</option>
                        <option value="2" <?php if ($rowEditar['tipo'] == 2){echo 'selected="selected"';} ?> >Jurídica</option>
                        <option value="3" <?php if ($rowEditar['tipo'] == 3){echo 'selected="selected"';} ?> >DIMEX</option>
                        <option value="4" <?php if ($rowEditar['tipo'] == 4){echo 'selected="selected"';} ?> >NITE</option>
                        <option value="5" <?php if ($rowEditar['tipo'] == 5){echo 'selected="selected"';} ?> >Pasaporte</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" value="<?=$rowEditar['nombre']?>" name="nombre" class="form-control">
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <label for="apellidos">Apellidos:</label>
                    <input type="text" id="apellidos" value="<?=$rowEditar['apellidos']?>" name="apellidos" class="form-control">
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <label for="telefono">Teléfono: </label>
                    <input type="text" id="telefono" value="<?=$rowEditar['telefono']?>" name="telefono" class="form-control">
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <label for="email">Email: </label>
                    <input type="text" id="email" value="<?=$rowEditar['email']?>" name="email" class="form-control">
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <label for="direccion">Dirección: </label>
                    <textarea name="direccion" id="direccion" rows="3" class="form-control"><?=$rowEditar['direccion']?></textarea>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-md-4">
                    <label for="sucursal">Sucursal: </label>
                    <select class="form-control" name="sucursal" id="sucursal">
                        <?php 
                        $sqlSucursal = "SELECT * FROM tsucursales WHERE estado = 1";
                        $querySucursal = mysqli_query($conn, $sqlSucursal);
                        while($rowSucursal = mysqli_fetch_array($querySucursal)){
                            ?>
                            <option value="<?=$rowSucursal['id']?>" <?php if ($rowEditar['idSucursal'] == $rowSucursal['id']){echo 'selected="selected"';} ?>><?=$rowSucursal['nombre']?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="row text-center m-4">
                <div class="col-12">
                    <button type="submit" class="btn btn-primary" name="guardar"><i class="fas fa-fw fa-check"></i> Guardar</button>
                </div>
            </div>
            
        </form>

        <?php } ?>

    </div>
</div>

<?php 
include('../../template/bottom.php');
?>