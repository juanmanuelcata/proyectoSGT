<?php
if (isset($_POST['user_nue']) && ($_POST['user_pass'])) {
    $db = conectaDb();
    $user_nue = $_POST['user_nue'];
    $user_pass = $_POST['user_pass'];
    $user_nombre = $_POST['user_nombre'];
    $user_ape = $_POST['user_ape'];
    $user_dni = $_POST['user_dni'] ;
    $user_mail = $_POST['user_mail'];
    $admin = $_POST['activa'];
    $consulta = 'SELECT * from usuario where (user = "'.$user_nue.'") or (dni = "'.$user_dni.'") or (mail = "'.$user_mail.'")';
    $result = $db->query($consulta);
    if ($result->rowCount() > 0) {
        echo ' <div class="alert alert-error">  
                    <a class="close" data-dismiss="alert">×</a>  
                    <h4><strong>Error!</strong><br>
                    El usuaio: ' . $user_nue . ' ya se encuentra registrado.</h4>  
                </div>';
    } else {
        $consulta = "INSERT INTO usuario (user, clave, nombre, apellido, dni, mail, admin)
                    VALUES ('$user_nue', '$user_pass', '$user_nombre', '$user_ape', '$user_dni', '$user_mail', '$admin')";
        if ($db->query($consulta)) {
      $fechita = date('Y-m-d H:i:s');
      $detalle = 'Alta del usuario "' . $user_nue . '"';
      $user = $_SESSION['usuario']['user'];
      $id = $db->lastInsertId("seq_name");
      $log = "INSERT INTO log ( fecha, usuario, detalle, tabla, idafectado)              
              VALUES ('$fechita', '$user', '$detalle', 'usuario', '$id' )";
      $db->query($log);
            echo '<div class="alert alert-success">  
                    <a class="close" data-dismiss="alert">×</a>  
                    <h4><strong>Muy Bien!</strong><br>
                    Se incerto correctamente el usuario: ' . $user_nue . '.</h4>  
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
<form class="form-horizontal" name="formi" action="/abm/usuario.php?code=a" method="POST">
    <fieldset>
        <legend>Agregar un nuevo usuario.</legend>
        <div class="control-group">
            <div class="controls">
                <label>Usuario</label>
                <input type="text" class="input-xlarge" id="user" name="user_nue" placeholder="Usuario" maxlength="20">
                <button class="btn btn-mini" onclick="return false;" data-original-title="Nombre de usuario" data-content="Ingrese el nombre de usuario. La cantidad máxima de caracteres es 20.">
                    <i class="icon-question-sign"></i>
                </button>
                <label>Contraseña (minimo 4 caracteres)</label>
                <input type="password" class="input-xlarge" id="pass" name="user_pass"  placeholder="Contraseña"  maxlength="20">
                <button class="btn btn-mini" onclick="return false;" data-original-title="Contraseña del usuario" data-content="Ingrese la contraseña del usuario. La cantidad máxima de caracteres es 20.">
                    <i class="icon-question-sign"></i>
                </button>
                <label>Repita la contraseña</label>
                <input type="password" class="input-xlarge" id="pass2" name="user_pass_verif" placeholder="Repita la contraseña" maxlength="20">
                <button class="btn btn-mini" onclick="return false;" data-original-title="Repita la contraseña del usuario" data-content="Repita nuevamente la contraseña del usuario, deben coincidir ambas. La cantidad máxima de caracteres es 20.">
                    <i class="icon-question-sign"></i>
                </button>
                <label>Nombre</label>
                <input type="text" class="input-xlarge" id="nombre" name="user_nombre" placeholder="Nombre" maxlength="20" onkeypress="return soloLetras(event);">
                <button class="btn btn-mini" onclick="return false;" data-original-title="Nombre de pila del usuario" data-content="Ingrese el nombre de pila del usuario. La cantidad máxima de caracteres es 20. No se permiten números ni símbolos.">
                    <i class="icon-question-sign"></i>
                </button>
                <label>Apellido</label>
                <input type="text" class="input-xlarge" id="apellido" name="user_ape" placeholder="Apellido" maxlength="20" onkeypress="return soloLetras(event);">
                <button class="btn btn-mini" onclick="return false;" data-original-title="Apellido del usuario" data-content="Ingrese el apellido del usuario. La cantidad máxima de caracteres es 20. No se permiten números ni símbolos.">
                    <i class="icon-question-sign"></i>
                </button>
                <label>DNI</label>
                <input type="text" class="input-xlarge" id="dni" name="user_dni" placeholder="12345678" maxlength="8" onkeypress="return justNumbers(event);">
                <button class="btn btn-mini" onclick="return false;" data-original-title="DNI del usuario" data-content="Ingrese el DNI del usuario. Solo se permiten caracteres numéricos. La cantidad máxima de dígitos es 8.">
                    <i class="icon-question-sign"></i>
                </button>
                <label>Correo electrónico</label>
                <input type="text" class="input-xlarge" id="mail" name="user_mail" placeholder="nombre@servidor.com">
                <button class="btn btn-mini" onclick="return false;" data-original-title="E-mail del usuario" data-content="Ingrese el e-mail del usuario que desee agregar a la base de datos. Por ejemplo: 'cuenta@gmail.com'.">
                    <i class="icon-question-sign"></i>
                </button>
                <label class="radio">
                <br>
                <input type="radio" name="activa" id="option1" value="1" >
                <p>Admin</p> 
                <input type="radio" name="activa" id="option2" value="0" checked>
                <p>Usuario</p>
                </label>
                <button class="btn btn-mini" onclick="return false;" data-original-title="Tipo de usuario" data-content="Oprima sobre el tipo de usuario para seleccionar que tipo de permisos tendrá.">
                    <i class="icon-question-sign"></i>
                </button>
<br><br> 
                <button type="submit" onclick="return veriformuUsr()" class="btn btn-success">Guardar</button>
                <button type="reset" class="btn btn-success">Borrar</button>
            </div>
        </div>
    </fieldset>
</form><br>

