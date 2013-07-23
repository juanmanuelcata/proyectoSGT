    <script type="text/javascript">
        $(document).ready(function() {
            $('#tabla1').dataTable({
                "sScrollY": 200,
                "bScrollCollapse": true,
                "sScrollX": "100%",
                "sScrollXInner": "110%",
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "oLanguage": {
                    "sLengthMenu": 'Display <select>' +
                            '<option value="10">10</option>' +
                            '<option value="20">20</option>' +
                            '<option value="30">30</option>' +
                            '<option value="40">40</option>' +
                            '<option value="50">50</option>' +
                            '<option value="-1">Todo</option>' +
                            '</select> records'
                }
            });
        });
    </script>
<?php
include_once('../../sesion/login.php');
include_once('../../fragmentos/_conectDb.php');
if ($_SESSION['usuario']['admin'] == '1') {
  
}
else
  header('Location: /index.php?er=2');
?>
<!DOCTYPE html>
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
        <script type="text/javascript">
        $(document).ready(function() {
            $('#tabla1').dataTable({
                "sScrollY": 200,
                "bScrollCollapse": true,
                "sScrollX": "100%",
                "sScrollXInner": "110%",
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "oLanguage": {
                    "sLengthMenu": 'Display <select>' +
                            '<option value="10">10</option>' +
                            '<option value="20">20</option>' +
                            '<option value="30">30</option>' +
                            '<option value="40">40</option>' +
                            '<option value="50">50</option>' +
                            '<option value="-1">Todo</option>' +
                            '</select> records'
                }
            });
        });
    </script>
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
if (isset($_GET['ok'])) {
  $idmedico = $_GET['id'];
  $d = $_GET['desde'];
  $h = $_GET['hasta'];
  $aux = new DateTime($d);
  $desde = $aux->format('Y-m-d');
  $aux2 = new DateTime($h);
  $hasta = $aux2->format('Y-m-d');
  $consulta = "select * from licencia where '$idmedico' = id_med";
  $verif = $db->query($consulta);
  $ok = true;
  foreach ($verif as $fila) {
    if (($desde >= $fila['desde'] && $desde <= $fila['hasta']) || ($hasta >= $fila['desde'] && $hasta <= $fila['hasta'])) {
      $ok = false;
    }
  }
  if ($ok) {
    $consulta = "insert into licencia (desde, hasta, id_med)
                values ('$desde', '$hasta', '$idmedico')";
    $db->query($consulta);
  }
  else{
        echo '<div class="alert alert-error">  
                <a class="close" data-dismiss="alert">×</a>  
                <strong><h4>Error!</h4> El intervalo ingresado no es válido.</strong> 
             </div>';
  }
} else {
  if (isset($_GET['id'])) {
    $idmedico = $_GET['id'];
    $consulta = "SELECT * from medico inner join licencia on ( $idmedico = id_med)";
    $result = $db->query($consulta);

    if (!$result->rowCount()) {
      $consulta2 = "select * from medico where idmedico = 31";
      $consul = $db->query($consulta2);
      $pri = $consul->fetch(PDO::FETCH_ASSOC);
      echo 'El médico ' . $pri['nombre'] . '  ' . $pri['apellido'] . ' no posee licencias tomadas';
    } else {
      $pri = $result->fetch(PDO::FETCH_ASSOC);
      echo 'Listado de licencias del médico ' . $pri['nombre'] . ' ' . $pri['apellido'] . '.';
    }
  } else {
    echo "esta llamando incorrectamente a la pagina listado de licencias";
    die();
  }
}
?>  

<form class="form-actions" name="form1" id="form1" action="./_medico_licencia.php" method="GET">

  <input type="date" tabindex="1" class="input-xlarge" id="desde" name="desde" required/>
  <input type="date" tabindex="2" class="input-xlarge" id="hasta" name="hasta" required/>
  <input type="hidden" name="ok" value="1"/>
  <input type="hidden" name="code" value="li"/>
  <input type="hidden" name="id" value="<?php echo $idmedico ?>"/>
  <button class="btn btn-success" type="submit">Agregar Licencia</button>

</form>

<legend><?php ?></legend>

<form class="form-horizontal" name="form2" id="form2" action="./medico/_medico_imprimir.php" method="GET" target="_blank">    
  <div class="control-group">
    <table id="tabla1" class="table table-striped">
      <thead>
        <tr>
          <th>Elegir</th>
          <th>Desde</th>
          <th>Hasta</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $idmedico = $_GET['id'];
        $consulta = "SELECT * from licencia where $idmedico = id_med";
        $result = $db->query($consulta);
        foreach ($result as $valor)
          echo ('<tr>
                <td><input type="checkbox" name="' . $valor['id'] . '" value="' . $valor['id'] . '" id="' . $valor['id'] . '"></td>
                <td>' . $valor['desde'] . '</td>
                <td>' . $valor['hasta'] . '</td>
                </tr>');
        ?>
      </tbody>
    </table>
  </div>
  <br> 
  <a href="javascript:seleccionar_todo()">Marcar todos</a> | 
  <a href="javascript:deseleccionar_todo()">Desmarcar todos</a> 
  <button type="submit" class="btn btn-success offset1">Imprimir</button>

</form>
<script>
  function seleccionar_todo() {
    for (i = 0; i < document.form.elements.length; i++)
      if (document.form.elements[i].type == "checkbox")
        document.form.elements[i].checked = 1
  }

  function deseleccionar_todo() {
    for (i = 0; i < document.form.elements.length; i++)
      if (document.form.elements[i].type == "checkbox")
        document.form.elements[i].checked = 0
  }
</script>
          </div>                
        </div>
      </div>
    </div>
  </body>
</html>

