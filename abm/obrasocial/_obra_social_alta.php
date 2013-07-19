<?php
if (isset($_GET['os_nue'])) {
  $db = conectaDb();
  $os_nue = $_GET['os_nue'];
  $consulta = "SELECT * from os where (nombre = '$os_nue')";
  $result = $db->query($consulta);

  if ($result->rowCount() > 0) {
    echo ' <div class="alert alert-error">  
                    <a class="close" data-dismiss="alert">×</a>  
                    <h4><strong>Error!</strong><br>
                    La obra social: ' . $os_nue . ' ya se encuentra registrada.</h4>  
                </div>';
  } else {
    $consulta = "INSERT INTO os (nombre) 
                    VALUES ('$os_nue')";
    if ($db->query($consulta)) {
      $fechita = date('Y-m-d H:i:s');
      $detalle = 'Alta de la obra social  "' . $os_nue . '"';
      $user = $_SESSION['usuario']['user'];
      $id = $db->lastInsertId("seq_name");
      $log = "INSERT INTO log ( fecha, usuario, detalle, tabla, idafectado)              
              VALUES ('$fechita', '$user', '$detalle', 'os', '$id' )";
      $db->query($log);
      echo '<div class="alert alert-success">  
                    <a class="close" data-dismiss="alert">×</a>  
                    <h4><strong>Muy Bien!</strong><br>
                    Se incerto correctamente la obra social: ' . $os_nue . '.</h4>  
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
<form class="form-horizontal" name="formi" action="/abm/obraSocial.php" method="GET">
  <fieldset>
    <legend>Agregar una nueva obra social.</legend>
    <div class="control-group">
      <div class="controls">
        <label>Nombre de la obra social</label>
        <input type="text" class="input-xlarge" id="input01" name="os_nue" placeholder="Obra social" onkeypress="return soloLetras(event);">
        <br><br>
        <input type="hidden" name="code" value="a"/>
        <button type="submit" onclick="return verifObra()" class="btn btn-success">Guardar</button>
        <button type="reset" class="btn btn-success">Borrar</button>
      </div>
    </div>
  </fieldset>
</form>