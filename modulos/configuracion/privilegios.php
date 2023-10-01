<?php 
include ("../../conn/conn.php");
revisarPrivilegio(4);
$titulo = "Privilegios";
include ("../../template/top.php");
?>


<div class="card m-4">
  <div class="card-body">
  <h4>Privilegios</h4>
  <hr>
    <div class="row">
        <div class="col-12 col-md-3">
            <input type="hidden" id="id">
            <div class="row">
                <div class="col-12">
                    <label for="nombre">Nombre: </label>
                    <input type="text" class="form-control" id="nombre" name="nombre" autocomplete="off">
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <label for="icono">Icono: </label>
                    <input type="text" class="form-control" id="icono" name="icono" autocomplete="off">
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <label for="url">URL: </label>
                    <input type="text" class="form-control" id="url" name="url" autocomplete="off">
                </div>
            </div>

            <div class="row text-center" id="botoneraNuevo"> 
                <div class="col-12">
                    <button class="btn btn-sm btn-secondary mt-4" onclick="nuevoPrivilegio()">Guardar</button>
                </div>
            </div>

            <div class="row text-center" id="botoneraEditar" style="display: none;">
                <div class="col-12">
                    <button class="btn btn-sm btn-secondary mt-4" onclick="editarPrivilegio()">Modificar</button>
                    <button class="btn btn-sm btn-secondary mt-4" onclick="cancel()">Cancelar</button>
                </div>
            </div>

        </div>

        
        <div class="col-12 col-md-9">
            <div class="row">
                <div class="col-12">
                    <input type="text" name="buscar" id="buscar" class="form-control" onkeyup="buscar(event)" placeholder="Digite el privilegio a buscar">
                </div>
            </div>

            <div id="privilegios"></div>

        </div>

        <div class="col-12 col-md-9" id="privilegios"></div>
    </div>


    <script>

    function nuevoPrivilegio(){
        var nombre = $('#nombre').val();
        var url = $('#url').val();
        var icono = $('#icono').val();

        $.post('funcionesAJAXPrivilegios.php', {action: 'setPrivilege', nombre: nombre, icono: icono, url: url})
        .done(function (data){
            cargarPrivilegios();
            $('#nombre').val('');
            $('#url').val('');
            $('#icono').val('');
        });
    }

    function eliminarPrivilegio(id){
        if (confirm('¿Está seguro que desea eliminar?')){
            $.post('funcionesAJAXPrivilegios.php', {action: 'deletePrivilege', id: id})
            .done(function (data){
                cargarPrivilegios();
            }); 
        }
    }

    function loadPrivilegio(id, nombre, icono, url){
        $('#nombre').val(nombre);
        $('#url').val(url);
        $('#icono').val(icono);
        $('#id').val(id);

        $('#botoneraNuevo').css('display', 'none');
        $('#botoneraEditar').css('display', 'block');
    }

    function cancel(){
        $('#nombre').val('');
        $('#url').val('');
        $('#icono').val('');
        $('#id').val('');

        $('#botoneraNuevo').css('display', 'block');
        $('#botoneraEditar').css('display', 'none');
    }

    function editarPrivilegio(){
        var nombre = $('#nombre').val();
        var url = $('#url').val();
        var icono = $('#icono').val();
        var id = $('#id').val();

        $.post('funcionesAJAXPrivilegios.php', {action: 'updatePrivilege', id: id, nombre: nombre, icono: icono, url: url})
        .done(function (data){
            cargarPrivilegios();
            cancel();
        });
    }

    function buscar(e){
        if (e.keyCode == 13){
            cargarPrivilegios();
        }
    }

    function cargarPrivilegios(){
        var buscar = $('#buscar').val();
        $.post('funcionesAJAXPrivilegios.php', {action: 'getPrivileges', buscar: buscar})
        .done(function (data){
            $('#privilegios').html(data);
        });
    }
    cargarPrivilegios();
    </script>
</div>
</div>
<?php 
include ("../../template/bottom.php");
?>