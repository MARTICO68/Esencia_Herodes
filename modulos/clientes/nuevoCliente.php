<?php 
include("../../conn/conn.php");
revisarPrivilegio(1);
if (isset($_POST['guardar'])){
    $identificacion = $_POST['identificacion'];
    $tipo = $_POST['tipo'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    $direccion = $_POST['direccion'];
    $sucursal = $_POST['sucursal'];

    $sqlClientes = "INSERT INTO tclientes 
    (identificacion, tipo, nombre, apellidos, telefono, email, direccion, idSucursal, estado) VALUES 
    ('$identificacion', '$tipo', '$nombre', '$apellidos', '$telefono', '$email', '$direccion', '$sucursal', 1)";
    $queryClientes = mysqli_query($conn, $sqlClientes);

    ?>
    <script>
        alert('El cliente fue guardado exitosamente.');
        document.location.href = 'clientes.php';
    </script>
    <?php
    exit();
}



$titulo = "Clientes -> Nuevo Clientes";
include("../../template/top.php");
?>

<div class= "row text-right">
    <div class="col-12">
        <a href="clientes.php" class="btn btn-primary"><i class="fas fa-fw fa-arrow-left "></i>Regresar</a>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <form action="" method="post">

          <div class="row">
              <div class="col-12">
                <label for="identificacion">Identificación: </label>
               <input type="text" id="identificacion" name="identificacion" class="form-control">
              </div>
          </div>

          <div class="row">
              <div class="col-12 col-md-4">
                  <label for="tipo">Tipo: </label>
                  <select name="tipo" id="tipo" class="form-control">
                      <option value="1">Física</option>
                      <option value="2">Juridica</option>
                      <option value="3">DIMEX</option>
                      <option value="4">NITE</option>
                      <option value="5">Pasaporte</option>
                   </select>
                </div>
           </div>

          <div class="row">
              <div class="col-12">
                  <label for="nombre">Nombre: </label>
                 <input type="text" id="nombre" name="nombre" class="form-control">
               </div>
          </div>

          <div class="row">
              <div class="col-12">
                  <label for="apellidos">Apellidos: </label>
                 <input type="text" id="apellidos" name="apellidos" class="form-control">
             </div>
          </div>

          <div class="row">
              <div class="col-12">
                  <label for="telefono">Telefono: </label>
                 <input type="text" id="telefono" name="telefono" class="form-control">
              </div>
          </div>

          <div class="row">
              <div class="col-12">
                  <label for="email">Email: </label>
                 <input type="text" id="email" name="email" class="form-control">
              </div>
          </div>

          <div class="row">
              <div class="col-12">
                  <label for="direccion">Direccion: </label>
                 <textarea name="direccion" id="direccion" rows="3" class="form-control"></textarea>
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
                            <option value="<?=$rowSucursal['id']?>"><?=$rowSucursal['nombre']?></option>
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
    </div>

<?php 
include("../../template/bottom.php");
?>