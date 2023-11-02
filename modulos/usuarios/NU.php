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

include('../../template/top.php');
?>
<div class="card m-4">
    <div class="card-body">
    <h5>Nuevo usuario</h5>
    <hr>
    <div class="row text-right">
    <div class="col-12">
        <a href="usuarios.php" class="btn btn-sm btn-dark"><i class="fas fa-fw fa-arrow-left"></i> Regresar</a>
    </div>
</div>

<div class="row">
    <div class="col-12 col-md-6">
        <form class="user" action="" method="post">

            <div class="row">
                <div class="col-md-6">
                    <label for="nombre" class="animate__animated animate__slideInLeft" class="fas fa-fw fa-user animate__animated animate__slideInLeft">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" class="form-control shadow-sm animate__animated animate__zoomIn">
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <label for="usuario" class="animate__animated animate__slideInLeft" class="fas fa-fw fa-user animate__animated animate__slideInLeft">Usuario: </label>
                    <input type="text" id="usuario" name="usuario" class="form-control shadow-sm animate__animated animate__zoomIn">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <label for="pass" class="animate__animated animate__slideInLeft" class="fas fa-fw fa-user animate__animated animate__slideInLeft">Contraseña:</label>
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
        </form>
    </div>
    <div class="col-12 col-md-6 text-center">                                                        
        <img class="img-fluid" src="<?=$baseURL?>img/user.gif" height="550px"><br>                                           
    </div>
</div>
    </div>
</div>

<?php 
include('../../template/bottom.php');
?>