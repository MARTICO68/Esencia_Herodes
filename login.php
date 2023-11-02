<?php include("conn/conn.php"); 

if (isset($_POST['entrar'])){
    $usuario = $_POST['usuario'];
    $pass = sha1($_POST['pass']);

    $sqlUsuario = "SELECT * FROM tusuarios WHERE usuario = '$usuario' AND pass = '$pass' AND estado = 1";
    $queryUsuario = mysqli_query($conn, $sqlUsuario);
    if (mysqli_num_rows($queryUsuario) == 1){
        while($rowUsuario = mysqli_fetch_array($queryUsuario)){
            $idUsuario = $rowUsuario['id'];
            $codigo = $rowUsuario['codigo']; 
            setcookie('hksjne3443', $idUsuario);
            setcookie('yeidms9837', $codigo);

            header('location: index.php');
            exit();
        }
    }else{
        ?>
        <script>
            alert('El usuario y contraseña no son correctos.');
        </script>
        <?php 
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Login</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <!--<div class="col-lg-6 d-none d-lg-block bg-login-image"></div>-->
                            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                              <img src="<?php echo $baseURL?>img/logo2.png" height="450px">
                            </a>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Bienvenidos!</h1>
                                    </div>
                                    <form method="post" action="" class="user">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user"
                                                id="usuario" name="usuario" aria-describedby="emailHelp"
                                                placeholder="Usuario">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user"
                                                id="pass" name="pass" placeholder="Contraseña">
                                        </div>
                                       
                                        <button href="submit" name="entrar" class="btn btn-primary btn-user btn-block">
                                            Entrar
                                        </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>