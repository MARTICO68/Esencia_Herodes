<?php 

$server = "localhost";
$user = "root";
$pass = "";
$database = "prograavanzada";

$conn = mysqli_connect($server, $user, $pass);
mysqli_select_db($conn, $database);

$baseURL = "http://localhost:/Esencia_Herodes/";


if (!isset($_COOKIE['hksjne3443'])){
    //no hay un sesion iniciada
    if (basename($_SERVER['REQUEST_URI']) != 'login.php'){
        header('location: '.$baseURL.'login.php');
    }
}else{
    $idUsuario = $_COOKIE['hksjne3443'];
    $codigoUsuario = $_COOKIE['yeidms9837'];

    $sqlUsuario = "SELECT * FROM tusuarios WHERE id = '$idUsuario' AND codigo = '$codigoUsuario'";
    $queryUsuario = mysqli_query($conn, $sqlUsuario);

    if (mysqli_num_rows($queryUsuario) == 0){
        header('location: '.$baseURL.'logout.php');
    }
}


function revisarPrivilegio($id){
    $idUsuario = $GLOBALS['idUsuario'];
    $conn = $GLOBALS['conn'];
    $baseURL = $GLOBALS['baseURL'];

    $sqlPU = "SELECT * FROM tprivilegiosusuario WHERE idUsuario = '$idUsuario' AND idPrivilegio = '".$id."'";
    $queryPU = mysqli_query($conn, $sqlPU);
    if (mysqli_num_rows($queryPU) == 0){
        header('location: '.$baseURL.'noaccess.php');
        exit();
    }
}

$proyecto = "MARWEB.com";

?>