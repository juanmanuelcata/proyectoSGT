<!DOCTYPE html>
<?php
//detalle paciente
include_once('../../sesion/login.php');
include_once('../../fragmentos/_conectDb.php');
if ($_SESSION['usuario']['admin'] == '1') {
  
}
else
  header('Location: /index.php?er=2');
?>
<html>
  <head>
    <title>SGT2</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="Sudo Soft" content="">
    <link href="./../../css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="./../../datatables/css/bootstrap.css" rel="stylesheet">
    <link href="./../../datatables/css/jquery.dataTables_themeroller.css" rel="stylesheet">
    <link href="./../../css/propio.css" rel="stylesheet" media="screen">
    <link rel="stylesheet" type="text/css" href="./../../css/menu.css" />
    <link rel="shortcut icon" href="./../../img/favicon.ico" type="image/x-icon"/> 
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> 

    <script type="text/javascript" src="./../../js/validacion.js"></script>
    <script type="text/javascript" src="./../../datatables/js/jquery.js"></script>
    <script type="text/javascript" src="./../../datatables/js/jquery.dataTables.js"></script>   
    <script type="text/javascript" src="./../../js/bootstrap-alert.js"></script>
  </head>
  <body>
    <div class="row-fluid">
      <div class="span12">
        <img SRC="./../../img/imagenSuper.png" id="cabe1">
      </div>
    </div>        
    <div class="row-fluid">
      <div class="span12">
        <div class="row-fluid">
          <div class="span10 offset1">
            <?php
            $db = conectaDb();
            $id = $_GET['id'];

            $consulta = "SELECT idpaciente, paciente.nombre pnombre, apellido, dni, ingreso, nacimiento, localidad, calle, altura, mail, telefono, piso, depto, os.nombre osnombre, activo FROM paciente INNER JOIN pac_os INNER JOIN os ON paciente.idpaciente =' $id ' AND pac_os.id_paciente = ' $id ' and pac_os.id_os = os.idos";
            $result = $db->query($consulta);
            $campos = $result->fetch(PDO::FETCH_ASSOC);
            ?>
            <label><strong>Nombre: </strong><?php echo ($campos['pnombre']) ?></label>
            <br>
            <label><strong>Apellido: </strong><?php echo ($campos['apellido']) ?></label>
            <br>
            <label><strong>DNI: </strong><?php echo ($campos['dni']) ?></label>
            <br>
            <label><strong>Obra Social: </strong><?php
            if ($campos['activo'] == 1)
              echo '<td>' . $campos['osnombre'] . '</td>';
            else
              echo '<td><p style="color: #FF0000">' . $campos['osnombre'] . '</p></td>';
            ?></label>
            <br>
            <label><strong>Fecha de nacimiento: </strong><?php echo ($campos['nacimiento']) ?></label>
            <br>
            <label><strong>Localidad: </strong><?php echo ($campos['localidad']) ?></label>
            <br>
            <label><strong>Calle: </strong><?php echo ($campos['calle']) ?></label>
            <br>
            <label><strong>Altura: </strong><?php echo ($campos['altura']) ?></label>
            <br>
            <label><strong>Piso: </strong><?php echo ($campos['piso']) ?></label>
            <br>
            <label><strong>Departamento: </strong><?php echo ($campos['depto']) ?></label>
            <br>
            <label><strong>Mail: </strong><?php echo ($campos['mail']) ?></label>
            <br>
            <label><strong>Telefono: </strong><?php echo ($campos['telefono']) ?></label>
            <br>
            <label><strong>Ingreso: </strong><?php echo ($campos['ingreso']) ?></label>
            <br>
            <a href="./paciente_edit.php?id=<?php echo $campos['idpaciente'] ?>&os=<?php echo $valor['osnombre']?>" class="btn btn-success">Modificar</a>
          </div>                
        </div>
      </div>
    </div>
  </body>
</html>
















