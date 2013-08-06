<?php
include_once('.../../../../sesion/login.php');
include_once '.../../../../fragmentos/_conectDb.php';

$db = conectaDb();
$id = $_GET['id'];

if (isset($_GET['mod'])) {
    $deletion = 'delete from med_os where id_med = ' . $id . ' and id_os = ' . $_GET['mod'] . '';
    $db->query($deletion);
}

if (isset($_POST['os_select'])) {
    foreach ($_POST['os_select'] as $os) {
        $consulta = 'SELECT idos FROM os WHERE "' . $os['nombre'] . '" = nombre ';
        $contenidos = $db->query($consulta);
        $arridos = $contenidos->fetch(PDO::FETCH_ASSOC);
        $idos = $arridos['idos'];

        $superposicion = 'select idmed_os from med_os where id_med = ' . $id . ' and id_os = ' . $idos . '';
        $super = $db->query($superposicion);
        if (($super->rowCount()) == 0) {
            $newOs = "INSERT INTO med_os (id_os, id_med)
                                VALUES ('$idos', '$id')";

            $db->query($newOs);
        } else {
            echo ' <div class="alert alert-error">  
                    <a class="close" data-dismiss="alert">×</a>  
                    <h4><strong>Error!</strong><br>
                    La obra social: ' . $os['nombre'] . ' ya se encuentra registrada.</h4>  
                </div>';
        }
    }
}


$consulta = "SELECT * from os inner join med_os where med_os.id_os = os.idos and med_os.id_med = '$id'";
$result = $db->query($consulta);
?>

<div class="control-group">
    <form class="form-horizontal" name="formi" method="POST" action="./medico.php?code=osmod&id=<?php echo $id ?>">
        <table id="tabla1"class="table table-striped">
            <thead>
                <tr>
                    <th>Nombre <button class="btn btn-mini" onclick="return false;" data-original-title="Campo Nombre" data-content="Oprima sobre este campo para ordenar la lista por el atributo Nombre de la Obra Social. Cada vez que se oprime cambiará entre forma ascendente y descendente.">
                            <i class="icon-question-sign"></i>
                        </button></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $valor): ?>
                    <tr>
                        <td><?php echo $valor['nombre'] ?></td>
                        <td><a class="btn btn-danger" href="./medico.php?code=osmod&id=<?php echo $id ?>&mod=<?php echo $valor['idos'] ?>">Eliminar</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <br><br><br>

        <fieldset>

            <div id="obrasSociales">

            </div>

            <button class="btn btn-success" onClick="agregarObraSocial();
                            return false;">Agregar Obra Social </button>
            <button class="btn btn-mini" onclick="return false;" data-original-title="Obra/s social/es del Médico" data-content="Oprima sobre el botón 'Agregar Obra Social' para desplegar el formulario. Si desea agregar otra obra social oprímalo nuevamente. Para eliminar una obra social oprima sobre el icono cerrar ('x').">
                <i class="icon-question-sign"></i>
            </button>

        </fieldset>
        <br><br><input type="submit" class="btn btn-success" id="guardar" value="Guardar cambios">
        <a href="../abm/medico.php?code=m&id=<?php echo $id ?>" class="btn btn-success">Volver</a>
        <button class="btn btn-mini" onclick="return false;" data-original-title="Volver" data-content="Oprima sobre volver para regresar al 'modificar' del Médico. Debe volver para continuar con la modificación del Médico. Recuerde guardar los cambios que haya realizado oprimiendo el botón 'Guardar cambios'.">
            <i class="icon-question-sign"></i>
        </button>
    </form>

</div>

<script>
                        var numeroOs = 0;
                        var cantOs = 0;

                        function agregarObraSocial()
                        {
                            $.ajax({
                                url: 'medico/addOs.php',
                                type: 'POST',
                                data: {
                                    numeroOs: ++numeroOs
                                },
                                success: function(data) {
                                    $('#obrasSociales').append(data);
                                    cantOs = $('#obrasSociales').find('div').length;
                                }
                            });
                        }

                        function borrarOs(numeroDiv)
                        {
                            $('#os_div_' + numeroDiv).remove();
                            cantOs = $('#obrasSociales').find('div').length;
                            if (cantOs == 0)
                                numeroOs = 0;
                        }
</script>
