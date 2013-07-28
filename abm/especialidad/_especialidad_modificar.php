<?php
$db = conectaDb();
$id_vie = $_GET['id'];
$consulta = 'SELECT * from especialidad where (idespecialidad = "' . $id_vie . '")';
$result = $db->query($consulta);
$a = $result->fetch(PDO::FETCH_ASSOC);
$esp_vie = $a['nombre'];
if (isset($_GET['ok'])) {
    $esp_nue = $_GET['esp_nue'];
    $activa = $_GET['activa'];
    $consulta2 = 'SELECT * from especialidad where (nombre = "' . $esp_nue . '")';
    $result2 = $db->query($consulta2);
    $a2 = $result2->fetch(PDO::FETCH_ASSOC);
    $id_nue = $a2['idespecialidad'];
    if ($id_nue == null || $id_nue == $id_vie) {
        $consulta = 'update especialidad set nombre = "' . $esp_nue . '", activa="' . $activa . '" where idespecialidad = "' . $id_vie . '"';
        if ($db->query($consulta)) {
            $fechita = date('Y-m-d H:i:s');
            $detalle = 'Modificacíon de la especialidad "' . $esp_nue . '"';
            $user = $_SESSION['usuario']['user'];
            $id = $db->lastInsertId("seq_name");
            $log = "INSERT INTO log ( fecha, usuario, detalle, tabla, idafectado)              
              VALUES ('$fechita', '$user', '$detalle', 'especialidad', '$id' )";
            $db->query($log);
            echo '<div class="alert alert-success">  
                    <a class="close" data-dismiss="alert">×</a>  
                    <strong><h4>Se modifico correctamente la especialidad: ' . $esp_nue . '.</h4></strong>  
                 </div>';
        } else {
            echo '<div class="alert alert-success">  
                    <a class="close" data-dismiss="alert">×</a>  
                    <strong><h4>Ocurrio un error al conectarse con la base de datos.</h4>Por favor comuniquese con su administrador.</strong>  
                 </div>';
        }
    } else {
        echo ' <div class="alert alert-error">  
                    <a class="close" data-dismiss="alert">×</a>  
                    <h4><strong>Error!</strong><br>
                    La especialidad: ' . $esp_nue . ' ya se encuentra registrada.</h4>  
                </div>';
    }
}
$consulta = 'SELECT * from especialidad where (idespecialidad = "' . $id_vie . '")';
$result = $db->query($consulta);
$a = $result->fetch(PDO::FETCH_ASSOC);
$esp_vie = $a['nombre'];
?>

<form class="form-horizontal" name="formi" action="./especialidad.php" method="GET">
    <fieldset>
        <legend>Modificar especialidad</legend>
        <div class="control-group">
            <?php echo '<h4>Usted esta editando la especialidad: ' . $esp_vie . '</h4>' ?>
            <br><br>
            <?php
            echo '<input value="' . $esp_vie . '" type="text" class="input-xlarge" id="nombre" name="esp_nue" onkeypress="return soloLetras(event);">';
            echo '<button class="btn btn-mini" onclick="return false;" data-original-title="Modificación del nombre de la especialidad" data-content="Ingrese el nuevo nombre de la especialidad para modificarlo. No se permiten números.">
                                        <i class="icon-question-sign"></i>
             </button>';
            if ($a['activa'] == 1)
                echo '<label class="radio">
                <br>
                <input type="radio" name="activa" id="option1" value="1" checked>
                <p>Activa</p>
                <input type="radio" name="activa" id="option2" value="0">
                <p>Inactiva</p>
            </label>  
        </div>';
            else
                echo '<label class="radio">
                <br>
                <input type="radio" name="activa" id="option1" value="1" >
                <p>Activa</p>
                <input type="radio" name="activa" id="option2" value="0" checked>
                <p>Inactiva</p>
            </label>  
        </div>';
            ?>
            <button class="btn btn-mini" onclick="return false;" data-original-title="Estado de la especialidad" data-content="Oprima sobre alguno de los campos para modificar el estado de la especialidad.">
                <i class="icon-question-sign"></i>
            </button>      
            <div class="form-actions">
                <input type="hidden" name="code" value="c"/>
                <p id="conf"></p>
                <input type="hidden" name="id" value="<?php echo "$id_vie" ?>"/>
                <button type="submit" onclick="veriMod()" class="btn btn-success">Guardar cambios</button>
                <button type="reset" class="btn btn-success">Borrar</button>
            </div>
    </fieldset>

