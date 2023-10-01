<?php 
include('../../conn/conn.php');
revisarPrivilegio(3);
if (isset($_POST['guardar'])){
    $nombre = $_POST['nombre'];
    $usuario = $_POST['usuario'];
    $pass = $_POST['pass'];
    $repitepass = $_POST['repitepass'];

    $codigoAleatorio = rand(10000000, 99999999);

    if ($pass == $repitepass){
        $crear = 0;
        $sqlExiste = "SELECT * FROM tusuarios WHERE usuario = '$usuario'";
        $queryExiste = mysqli_query($conn, $sqlExiste);

        if (mysqli_num_rows($queryExiste) == 0){
            $crear = 1;
        }else{
            while($rowExiste = mysqli_fetch_assoc($queryExiste)){
                if ($rowExiste['estado'] != 1){
                    $sqlActivar = "UPDATE tusuarios SET estado = 1 WHERE usuario = '$usuario'";
                    $queryActivar = mysqli_query($conn, $sqlActivar);
                }else{
                    ?>
                    <script>
                        alert('El usuario que desea crear ya existe.');
                        document.location.href = 'usuarios.php';
                    </script>
                    <?php
                }
            }
        }

        if ($crear == 1){
            $pass = sha1($pass);
            $sqlUsuario = "INSERT INTO tusuarios 
            (nombre, usuario, pass, codigo, estado) VALUES 
            ('$nombre', '$usuario', '$pass', '$codigoAleatorio', 1)";
            $queryUsuario = mysqli_query($conn, $sqlUsuario) or die(mysqli_error($conn));
        }
    }

    ?>
    <script>
        alert('El usuario fue guardada exitosamente.');
        document.location.href = 'usuarios.php';
    </script>
    <?php
    exit();
}

$titulo = "Usuarios -> Nuevo Usuario";
include('../../template/top.php');
?>

<div class="row text-right">
    <div class="col-12">
        <a href="usuarios.php" class="btn btn-primary"><i class="fas fa-fw fa-arrow-left"></i> Regresar</a>
    </div>
</div>

<div class="row">
    <div class="col-12">

        <form action="" method="post">

            <div class="row">
                <div class="col-12">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" class="form-control">
                </div>
            </div>
            
            <div class="row">
                <div class="col-12">
                    <label for="usuario">Usuario: </label>
                    <input type="text" id="usuario" name="usuario" class="form-control">
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <label for="pass">Contraseña:</label>
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

        </form>

    </div>
    
</div>

<?php 
include('../../template/bottom.php');
?>