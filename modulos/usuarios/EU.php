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


include('../../template/top.php');
?>
<div class="card m-4">
    <div class="card-body">
    <h5>Editar usuario</h5>
    <hr>
    <div class="row text-right">
    <div class="col-12">
        <a href="usuarios.php" class="btn btn-sm btn-dark"><i class="fas fa-fw fa-arrow-left"></i> Regresar</a>
    </div>
</div>

<form class="user" action="" method="post">

<div class="row">
    <div class="col-12 col-md-8">

        <?php 
            $sqlEditar = "SELECT * FROM tusuarios WHERE id = '$idEditar'";
            $queryEditar = mysqli_query($conn, $sqlEditar);
            while($rowEditar=mysqli_fetch_array($queryEditar)){
            ?>
                <input type="hidden" value="<?=$rowEditar['id']?>" name="id">

                <div class="row">
                    <div class="col-md-6">
                        <label for="nombre" class="animate__animated animate__slideInLeft" class="fas fa-fw fa-user animate__animated animate__slideInLeft">Nombre:</label>
                        <input type="text" id="nombre" value="<?=$rowEditar['nombre']?>" name="nombre" class="form-control shadow-sm animate__animated animate__zoomIn">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label for="usuario" class="animate__animated animate__slideInLeft" class="fas fa-fw fa-user animate__animated animate__slideInLeft">Usuario: </label>
                        <input type="text" id="usuario" value="<?=$rowEditar['usuario']?>" name="usuario" class="form-control shadow-sm animate__animated animate__zoomIn">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label for="pass" class="animate__animated animate__slideInLeft" class="fas fa-fw fa-user animate__animated animate__slideInLeft">Contraseña: </label>
                        <input type="password" id="pass" name="pass" class="form-control shadow-sm animate__animated animate__zoomIn">
                    </div>
            
                    <div class="col-md-6">
                        <label for="repitepass" class="animate__animated animate__slideInLeft" class="fas fa-fw fa-user animate__animated animate__slideInLeft">Repita la contraseña: </label>
                        <input type="password" id="repitepass" name="repitepass" class="form-control shadow-sm animate__animated animate__zoomIn">
                    </div>
                </div>

                <div class="row text-center m-4">
                    <div class="col-12">
                        <button type="submit" class="btn btn-dark btn-sm btn-save animate__animated animate__zoomIn" name="guardar"><i class="fas fa-fw fa-save"></i> Guardar</button>
                        <hr>
                    </div>
                </div>
                            
            <?php } ?>

        </div>

        <div class="col-12 col-md-4">
        <div class="row text-center">
            <div class="col-12">
                <h5>Privilegios del sistema</h5>
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
    </div>
</div>

<?php 
include('../../template/bottom.php');
?>