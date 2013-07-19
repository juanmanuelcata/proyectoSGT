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
          <h6>
            <?php
            $p = new DateTime( '31-01-2013' );
            $d = $p->format('Y-m-d');
            echo $d;
            die();
            
            
            include_once './fragmentos/_conectDb.php';
            $db = conectaDb();
            $consulta = 'SELECT * FROM medico where idmedico = 32';
            $tmp = $db->query($consulta);
            $r = $tmp->fetch(PDO::FETCH_ASSOC);
            echo 'Dia de hoy: ' . date("d-m-Y");
            echo '<br>';
            echo '<br>';
            echo '
              <p>nombre: ' . $r['nombre'] . '</p>
              <p>telefono: ' . $r['apellido'] . '</p>
              <p>dni: ' . $r['dni'] . '</p>
              <p>id: ' . $r['idmedico'] . '</p>
              ';
            ?>
            <?php
            echo '1----------------------------------<br>';
            require_once('/fragmentos/Dia.php');
            
            echo 'creamos objeto1 dia sin parametros: ';
            $objetoDia1 = new Dia();
            echo '<br>';
            echo 'dia del objeto1: ' . $objetoDia1->getDia();
            echo '<br>';
            echo 'nombre del objeto1: ' . $objetoDia1->getNombre();
            echo '<br>';
            
            echo '2----------------------------------<br>';
           echo '<br>';
            echo 'calculando proximo dia desde el objeto1 y retorna objeto 2: ';
            $objetoDia2 = $objetoDia1->calcProxDia("mie");
            echo '<br>';
            echo 'dia del objeto2: ' . $objetoDia2->getDia();
            echo '<br>';
            echo 'nombre del objeto2: ' . $objetoDia2->getNombre();
            echo '<br>';
            
            echo '3----------------------------------<br>';
            
            echo '<br>';
            echo 'creo objeto3 con nombre "lun" ';
            $h = "lun";
            $objetoDia3 = new Dia($h);
            echo '<br>';
            echo 'dia del objeto3: ' . $objetoDia3->getDia();
            echo '<br>';
            echo 'nombre del objeto3: ' . $objetoDia3->getNombre();
            echo '<br>';
            
            echo '4----------------------------------<br>';
            
            echo '<br>';
            echo 'creo objeto4 con fecha "20-07-2013" ';
            $h = "20-07-2013";
            $objetoDia4 = new Dia($h);
            echo '<br>';
            echo 'dia del objeto4: ' . $objetoDia4->getDia();
            echo '<br>';
            echo 'nombre del objeto4: ' . $objetoDia4->getNombre();
            echo '<br>';
            echo '----------------------------------<br>';
            ?>
            <select id="select_medicos">
              <option value="          }

                      ?>-1">Seleccione una especialidad</option>
                      <?php
                      $idmed = $_POST['idMedico'];
                      $consulta2 = 'select dia from horario where (id_med  = 32) and (activo = 1) group by dia';
                      $tmp = $db->query($consulta2);
                      foreach ($tmp as $valor) {
                        $aux = new Dia($valor['dia']);
                        echo '<option class="option2" value="' . $valor['dia'] . '">' . $valor['dia'] .'    '.$aux->getDia(). '</option>';
                      }
                      ?>
            </select>
          </h6>                
        </div>
      </div>
    </div>
</body>
</html>
