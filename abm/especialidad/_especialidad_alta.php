<?php
if (isset($_GET['esp_nue'])) {
    $db = conectaDb();
    $esp_nue = $_GET['esp_nue'];
    $activa = $_GET['activa'];
    $consulta = "SELECT * from especialidad where (nombre = '$esp_nue')";
    $result = $db->query($consulta);
    if ($result->rowCount() > 0) {
        echo ' <div class="alert alert-error">  
                    <a class="close" data-dismiss="alert">×</a>  
                    <h4><strong>Error!</strong><br>
                    La especialidad: ' . $esp_nue . ' ya se encuentra registrada.</h4>  
                </div>';
    } else {
        $consulta = "INSERT INTO especialidad (nombre, activa) 
                    VALUES ('$esp_nue', '$activa')";
        if ($db->query($consulta)) {
          $fechita = date('Y-m-d H:i:s');
          $detalle = 'Alta de la especialidad "'.$esp_nue.'"';
          $user = $_SESSION['usuario']['user'];
          $id = $db->lastInsertId("seq_name");
          $log = "INSERT INTO log ( fecha, usuario, detalle, tabla, idafectado)              
              VALUES ('$fechita', '$user', '$detalle', 'especialidad', '$id' )";
          $db->query($log);
            echo '<div class="alert alert-success">  
                    <a class="close" data-dismiss="alert">×</a>  
                    <h4><strong>Muy Bien!</strong><br>
                    Se incerto correctamente la especialidad: ' . $esp_nue . '.</h4>  
                </div>';
        } else {
            echo '<div class="alert alert-error">  
                    <a class="close" data-dismiss="alert">×</a>  
                    <h4><strong>Error!</strong><br>
                    No pudo comunicarse con la base de datos.<br>
                    Comuniquese con su administrador.</h4>  
                </div>';
        }
    }
}
?>

<form class="form-horizontal" name="formi" action="./especialidad.php" method="GET">
    <fieldset>
        <legend>Agregar una nueva especialidad.</legend>
        <div class="control-group">
            <div class="controls">
                <input class="span3" type="text" id="input01" name="esp_nue" onkeypress="return soloLetras(event);" placeholder="Especialidad">
                <button class="btn btn-mini"  id="ayuda" onclick="return false;" data-original-title="Nombre de la especialidad" data-content="Ingrese el nombre de la especialidad que desee agregar a la base de datos. No se permiten números.">
                <i class="icon-question-sign"></i>
                </button>
            </div>                                                 
        </div>
        <div class="form-actions">
            <input type="hidden" name="activa" value="1"/>
            <input type="hidden" name="code" value="a"/>
            <button type="submit" onclick="return veriFormuEspecialidad();" class="btn btn-success">Guardar</button>
            <button type="reset"  class="btn btn-success">Borrar</button>
        </div>
    </fieldset>
</form>
