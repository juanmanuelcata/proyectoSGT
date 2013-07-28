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
<dt>Falta asignar: </dt>
<dd>editar el formato a botones para simplificar la vista
	<dd>superpocicion de licencias</dd>

<dt>Lautaro:</dt>
	<dd>Definir el alcance de los permisos de secretaria…</dd>
  <dd>agregar "quienes somos" y "agradecimientos" a la pagina</dd>
  <dd>Turno_alta, si no hay medico ponerlo en el select (o alert), lo mismo en días y horarios.</dd>

<dt>Pato:</dt>
		<dd>Listado de turnos: todo</dd>
                <dd>Reportes: todos</dd>
		<dd>Logs: Campo Elegir - Imprimir y marcar todos</dd>
		
<dt>Juancho:</dt>
	<dd>imprimir los reportes(todos)</dd>
	<dd>imprimir logs</dd>
  <dd>poner un imprimir individual en detalle de paciente o medico con todos los datos </dd>
  <dt>Nestor:	</dt>
  <dd>Manual(mas te vale que este genial)</dd>
</dl>        
   <br>


Por el momento esto es lo que se me ocurre que falta, cualquier cosa agreguen a la lista de “falta asignar”
        </div>
      </div>
    </div>
</body>
</html>
