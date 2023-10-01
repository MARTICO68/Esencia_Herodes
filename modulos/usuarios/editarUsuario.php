<?php 
include('../../conn/conn.php');
revisarPrivilegio(3);
$idEditar = 0;
if (isset($_GET['id_editar'])){
    $idEditar = $_GET['id_editar'];
}

if (isset($_POST['guardar'])){
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $usuario = $_POST['usuario'];
    $pass = $_POST['pass'];
    $repitepass = $_POST['repitepass'];

    if ($pass == ''){
        $sqlCliente = "UPDATE tusuarios SET 
        nombre = '$nombre',
        usuario = '$usuario'
        WHERE id = '$id'";
        $queryCliente = mysqli_query($conn, $sqlCliente);
    }else{
        if($pass == $repitepass){
            $pass = sha1($pass);
            $sqlCliente = "UPDATE tusuarios SET 
            nombre = '$nombre',
            usuario = '$usuario',
            pass = '$pass' 
            WHERE id = '$id'";
           $queryCliente = mysqli_query($conn, $sqlCliente);
        }
    }

    $sqlPrivilegios = "DELETE FROM tprivilegiosusuario WHERE idUsuario = '$id'";
    $queryPrivilegios = mysqli_query($conn, $sqlPrivilegios);

    foreach($_POST['privilegios'] as $privilegio){
        $sqlPrivilegios = "INSERT tprivilegiosusuario VALUES('$id', '$privilegio')";
        $queryPrivilegios = mysqli_query($conn, $sqlPrivilegios);
    }


    ?>
    <script>
        alert('El usuario fue modificado exitosamente.');
        document.location.href = 'usuarios.php';
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
            $sqlEditar = "SELECT * FROM tusuarios WHERE id = '$idEditar'";
            $queryEditar = mysqli_query($conn, $sqlEditar);
            while($rowEditar=mysqli_fetch_array($queryEditar)){
            ?>

            

                <input type="hidden" value="<?=$rowEditar['id']?>" name="id">

                <div class="row">
                    <div class="col-12">
                        <label for="nombre">Nombre:</label>
                        <input type="text" id="nombre" value="<?=$rowEditar['nombre']?>" name="nombre" class="form-control">
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <label for="usuario">Usuario: </label>
                        <input type="text" id="usuario" value="<?=$rowEditar['usuario']?>" name="usuario" class="form-control">
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <label for="pass">Contraseña: </label>
                        <input type="password" id="pass" name="pass" class="form-control">
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <label for="repitepass">Repita la contraseña: </label>
                        <input type="password" id="repitepass" name="repitepass" class="form-control">
                    </div>
                </div>

                <div class="row text-center m-4">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary" name="guardar"><i class="fas fa-fw fa-check"></i> Guardar</button>
                    </div>
                </div>
                
            

            <?php } ?>

        </div>

        <div class="col-12 col-md-4">
        <div class="row text-center">
            <div class="col-12">
                <h4>Privilegios del sistema</h4>
            </div>
        </div>
            <hr>
            <table>
            <?php 
            $sqlPrivilegios = "SELECT * FROM tprivilegios WHERE estado = 1";
            $queryPrivilegios = mysqli_query($conn, $sqlPrivilegios);
            while($rowPrivilegios = mysqli_fetch_array($queryPrivilegios)){
                ?>
                <tr>
                    <td><input type="checkbox" name="privilegios[]" 
                    <?php 
                    
                    if (mysqli_num_rows($queryPU) == 1){
                        echo 'checked="checked"';
                    }
                    ?> value="<?=$rowPrivilegios['id']?>"></td>
                    <td><?=$rowPrivilegios['nombre']?></td>
                </tr>
                <?php
            }
            ?>
            </table>
       </div>

        
       
    </div>
</form>
<?php 
include('../../template/bottom.php');
?>