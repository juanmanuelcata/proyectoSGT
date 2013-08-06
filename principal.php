<?php
include_once('sesion/login.php');
?>
<!DOCTYPE html>
<html>
  <title>SGT2</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="Sudo Soft" content="">
  <link href="./../css/bootstrap.min.css" rel="stylesheet" media="screen">
  <link href="./../css/bootstrap.css" rel="stylesheet">
  <link href="./../css/propio.css" rel="stylesheet" media="screen">
  <link rel="stylesheet" type="text/css" href="./../css/menu.css" />
  <link rel="shortcut icon" href="./../img/favicon.ico" type="image/x-icon"/> 
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />       
  <script type="text/javascript" src="./../js/validacion.js"></script>
  <script src="./datatables/js/jquery.js"></script>
  <script src="./../js/bootstrap.min.js"></script>
  <script src="./js/jquery.ui.datepicker.js"></script>
  <script src="http://code.jquery.com/jquery.js"></script>
  <script src="http://www.sgt.com:8004/js/bootstrap.min.js"></script>
</head>
<body>
  <div class="row-fluid">
    <div class="span12" id="cabecera2">
      <img SRC="./../img/imagenSuper.png" id="cabe1">
    </div>
  </div>        
  <div class="row-fluid">
    <div class="span12">
      <div class="row-fluid">
        <div class="span2">
          <?php include_once './fragmentos/_menu.php'; ?>
        </div>
        <div class="span9">
          
   <h4 class="text-center">Pagina en construccion</h4>
<dl>
              <?php 
              require_once('./fragmentos/Dia.php');
              
              
              $dia = new Dia('lun');
              echo $dia->getDia();
              echo $dia->getNombre();
              echo '<br>';
              
              $hoy2 = new Dia('mar');
              echo $hoy2->getDia();
              echo $hoy2->getNombre();
                echo '<br>';
              $hoy3 = new Dia('mie');
              echo $hoy3->getDia();
              echo $hoy3->getNombre();
                echo '<br>';
              $dia4 = new Dia('jue');
              echo $dia4->getDia();
              echo $dia4->getNombre();
              echo '<br>';
              
              $hoy5 = new Dia('vie');
              echo $hoy5->getDia();
              echo $hoy5->getNombre();
                echo '<br>';
              $hoy6 = new Dia('sab');
              echo $hoy6->getDia();
              echo $hoy6->getNombre();
                echo '<br>';
              $hoy7 = new Dia('dom');
              echo $hoy7->getDia();
              echo $hoy7->getNombre();
                echo '<br>';
              
              ?>
              <input type="date"/>
        </div>
      </div>
    </div>
</body>
</html>
