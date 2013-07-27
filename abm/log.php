<?php
include_once('../sesion/login.php');
  if ($_SESSION['usuario']['admin'] == '1'){      
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
    <link href="./../css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="./../datatables/css/bootstrap.css" rel="stylesheet">
    <link href="./../datatables/css/jquery.dataTables_themeroller.css" rel="stylesheet">
    <link href="./../css/propio.css" rel="stylesheet" media="screen">
    <link rel="stylesheet" type="text/css" href="./../css/menu.css" />
    <link rel="shortcut icon" href="./../img/favicon.ico" type="image/x-icon"/> 
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> 
    <script type="text/javascript" src="./../js/modernizr.custom.29473.js"></script>        
    <script type="text/javascript" src="./../js/validacion.js"></script>
    <script type="text/javascript" src="./../datatables/js/jquery.js"></script>
    <script type="text/javascript" src="./../datatables/js/jquery.dataTables.js"></script>   
    <script type="text/javascript" src="./../js/bootstrap-alert.js"></script>   
    <script type="text/javascript">
$(document).ready(function() {
    $('.table').dataTable( {
        "sScrollY": 200,
        "sScrollX": "100%",
        "sScrollXInner": "110%",
        "bJQueryUI": true,
        "sPaginationType": "full_numbers",
         "oLanguage": {
			           "sLengthMenu": 'Display <select>'+
			             '<option value="10">10</option>'+
			             '<option value="20">20</option>'+
			             '<option value="30">30</option>'+
			             '<option value="40">40</option>'+
			             '<option value="50">50</option>'+
			             '<option value="-1">Todo</option>'+
			             '</select> records'
			         }
    } );
} );
    </script>
  </head>
  <body>

    <div class="row-fluid">
      <div class="span12">
        <img SRC="./../img/imagenSuper.png" id="cabe1">
      </div>
    </div>        
    <div class="row-fluid">
      <div class="span12">
        <div class="row-fluid">
          <div class="span2">
            <?php include_once '../fragmentos/_menu.php'; ?>
          </div>
          <div class="span9">

            <?php
            include_once './../fragmentos/_conectDb.php';
            $db = conectaDb();
            $consulta = "SELECT idlog, date_format(fecha, '%d/%m/%Y %H:%m:%s') fecha, usuario, detalle, tabla, idafectado from log";
            $result = $db->query($consulta);
            ?>

            <table id="tabla1" class="table table-striped">
              <thead>
                <tr>
                  <th>ID Log</th>
                  <th>Fecha</th>
                  <th>Resposable</th>
                  <th>Detalle</th>
                  <th>Tabla</th>
                  <th>Id Afectato</th>
                </tr>
              </thead>
              <tbody>
                <?php
                foreach ($result as $valor)
                  echo ('<tr><td>' . $valor['idlog'] . '</td>
                <td>' . $valor['fecha'] . '</td>
                <td>' . $valor['usuario'] . '</td>
                <td>' . $valor['detalle'] . '</td>
                <td>' . $valor['tabla'] . '</td>
                <td>' . $valor['idafectado'] . '</td></tr>');
                ?>
              </tbody>    
            </table>

          </div>                
        </div>
      </div>
    </div>
  </body>
</html>

