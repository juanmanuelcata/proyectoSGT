<?php
// OK es una variable de flag que se activa cuando se guarda el formulario
$db = conectaDb();
if (isset($_POST['ok'])) {
  $user = $_POST['user'];
  $id = $_GET['id'];
  $dni = $_POST['dni'];
  $nombre = $_POST['nombre'];
  $apellido = $_POST['apellido'];
  $mail = $_POST['mail'];
  $admin = $_POST['activa'];
  $clave = $_POST['clave_nue'];
  $clave_nue = $_POST['clave_nue2'];
  //revisar que no se repita nombre de usuario, mail o dni
  $consulta = 'SELECT * from usuario where ((user = "' . $user . '") or (dni = "' . $dni . '") or (mail = "' . $mail . '")) and (idusuario != "' . $id . '")';
  $result = $db->query($consulta);
  if ($result->rowCount() == 0) {
    $consulta = 'update usuario set user = "' . $user . '", dni = "' . $dni . '", nombre= "' . $nombre . '", apellido= "' . $apellido . '", mail= "' . $mail . '", clave= "' . $clave_nue . '" where idusuario = "' . $id . '"';
    if ($db->query($consulta)) {
      $fechita = date('Y-m-d H:i:s');
      $detalle = 'Modificacion del usuario  "' . $user . '"';
      $userlog = $_SESSION['usuario']['user'];
      $id = $db->lastInsertId("seq_name");
      $log = "INSERT INTO log ( fecha, usuario, detalle, tabla, idafectado)              
              VALUES ('$fechita', '$userlog', '$detalle', 'usuario', '$id' )";
      $db->query($log);
      echo '<div class="alert alert-success">  
                    <a class="close" data-dismiss="alert">×</a>  
                    <h4><strong>Muy Bien!</strong><br>
                    Se modifico correctamente el usuario: ' . $user . '.</h4>  
                </div>';
    } else {
      echo '<div class="alert alert-error">  
                    <a class="close" data-dismiss="alert">×</a>  
                    <h4><strong>Error!</strong><br>
                    No pudo comunicarse con la base de datos.<br>
                    Comuniquese con su administrador.</h4>  
                </div>';
      echo $consulta;
    }
  } else {
    echo '<div class="alert alert-error">  
                    <a class="close" data-dismiss="alert">×</a>  
                    <h4><strong>Error!</strong><br>
                    El nombre de usuaio, dni o email ya se encuentra registrado.</h4>  
                </div>';
  }
}

$id = $_GET['id'];
$consulta = 'SELECT * from usuario where (idusuario = "' . $id . '")';
$result = $db->query($consulta);
$a = $result->fetch(PDO::FETCH_ASSOC);
?>



<form class="form-horizontal" name="formi" action="./usuario.php?code=m&id=<?php echo $id ?>" method="POST">
  <fieldset>
    <legend>Modificación de Usuario</legend>
    <div class="control-group">
            <div class="controls">
    <label>Nuevo usuario</label>
    <input value="<?php echo $a['user'] ?>" type="text" class="input-xlarge" id="user" name="user" maxlength="20">
    <label>Nuevo nombre</label>
    <input value="<?php echo $a['nombre'] ?>" type="text" class="input-xlarge" id="nombre" name="nombre" onkeypress="return soloLetras(event);">
    <label>Nuevo apellido</label>
    <input value="<?php echo $a['apellido'] ?>" type="text" class="input-xlarge" id="apellido" name="apellido" onkeypress="return soloLetras(event);">
    <label>Nuevo DNI</label>
    <input value="<?php echo $a['dni'] ?>" type="text" class="input-xlarge" id="dni" name="dni" maxlength="8" onkeypress="return justNumbers(event);">
    <label>Nuevo correo electrónico</label>
    <input value="<?php echo $a['mail'] ?>" type="text" class="input-xlarge" id="mail" name="mail">
    <label>Nueva contraseña</label>
    <input value="<?php echo $a['clave'] ?>" type="password" class="input-xlarge" id="pass" name="clave_nue">
    <label>Repita nueva contraseña</label>
    <input value="<?php echo $a['clave'] ?>" type="password" class="input-xlarge" id="pass2" name="clave_nue2">
    <?php
    if ($a['admin'] == 1)
      echo '<label class="radio">
                <br>
                <input type="radio" name="activa" id="option1" value="1" checked>
                <p>Admin</p>
                <input type="radio" name="activa" id="option2" value="0">
                <p>Usuario</p>
            </label>  
        </div>';
    else
      echo '<label class="radio">
                <br>
                <input type="radio" name="activa" id="option1" value="1" >
                <p>Admin</p>
                <input type="radio" name="activa" id="option2" value="0" checked>
                <p>Usuario</p>
            </label>  
        </div>';
    ?>
      <input type="hidden" name="ok" value="1"/>
      <input type="hidden" name="id" value="<?php echo "$id" ?>"/>
      <button type="submit" onclick="return veriformuUsr()" class="btn btn-success">Guardar cambios</button>
      <button type="reset" class="btn btn-success">Reiniciar</button>
      
     </div>
        </div>
  </fieldset>
</form>
