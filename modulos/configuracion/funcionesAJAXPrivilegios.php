<?php 
include ("../../conn/conn.php");
$action = $_POST['action'];

if ($action == 'setPrivilege'){
    $nombre = $_POST['nombre'];
    $url = $_POST['url'];
    $icono = $_POST['icono'];

    $sql = "INSERT INTO tprivilegios VALUES (null, '$nombre', '$icono', '$url', 1)";
    $query = mysqli_query($conn, $sql);
}

if ($action == 'updatePrivilege'){
    $nombre = $_POST['nombre'];
    $url = $_POST['url'];
    $icono = $_POST['icono'];
    $id = $_POST['id'];

    $sql = "UPDATE tprivilegios SET 
    nombre = '$nombre', 
    icono = '$icono', 
    url = '$url' 
    WHERE id = '$id'";
    $query = mysqli_query($conn, $sql);
}

if ($action == 'deletePrivilege'){
    $id = $_POST['id'];

    $sql = "UPDATE tprivilegios SET estado = 2 WHERE id = '$id'";
    $query = mysqli_query($conn, $sql);
}

if ($action == 'getPrivileges'){
    $buscar = $_POST['buscar'];
    if ($buscar == ''){
        $sqlPrivilegios = "SELECT * FROM tprivilegios WHERE estado = 1";
    }else{
        $sqlPrivilegios = "SELECT * FROM tprivilegios WHERE estado = 1 AND nombre LIKE '%$buscar%'";
    }
    
    $queryPrivilegios = mysqli_query($conn, $sqlPrivilegios);

    if (mysqli_num_rows($queryPrivilegios) == 0){
        ?>
        <div class="row text-center">
            <div class="col-12">
                <img src="<?=$baseURL?>img/empty.gif" height="250"><br>
                No se encuentran privilegios que mostrar.
            </div>
        </div>
        <?php 
    }else{
        ?>
        <div class="table-responsive">
            <table class="table table-sm table-striped table-bordered">
                <thead class="text-dark">
                    <th>Acciones</th>
                    <th></th>
                    <th>Id</th>    
                    <th>Nombre</th>
                    <th>URL</th>
                </thead>
                <tbody>
                    <?php 
                    while($rowPrivilegios = mysqli_fetch_array($queryPrivilegios)){
                        ?>
                        <tr>
                        <td>
                            <button class="btn btn-sm btn-outline-info" style="min-width: 45px" onclick="loadPrivilegio(<?=$rowPrivilegios['id']?>, '<?=$rowPrivilegios['nombre']?>', '<?=$rowPrivilegios['icono']?>', '<?=$rowPrivilegios['url']?>')"><i class="fa fa-solid fa-edit"></i></button>
                            <button class="btn btn-sm btn-danger" style="min-width: 45px" onclick="eliminarPrivilegio(<?=$rowPrivilegios['id']?>)"><i class="fas fa-fw fa-trash"></i></button>
                            </td>
                            <td><i class="fas fa-fw fa-<?=$rowPrivilegios['icono']?>"></i></td>
                            <td><?=$rowPrivilegios['id']?></td>
                            <td><?=$rowPrivilegios['nombre']?></td>
                            <td><?=$rowPrivilegios['url']?></td>
                        </tr>
                        <?php 
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <?php 
    }
}
?>