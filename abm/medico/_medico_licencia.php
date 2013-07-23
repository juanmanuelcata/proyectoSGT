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
  $consulta2 = "select * from medico where '$idmedico' = idmedico";
  $verif1 = $db->query($consulta2);
  $seg = $verif1->fetch(PDO::FETCH_ASSOC);
  echo '<legend>Listado de licencias del médico "' . $seg['nombre'] . '  ' . $seg['apellido'] . '"</legend>';
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
    $consulta = "SELECT * from medico inner join licencia on ( '$idmedico' = id_med)";
    $result = $db->query($consulta);

    if (!$result->rowCount()) {
      $consulta2 = "select * from medico where idmedico = $idmedico";
      $consul = $db->query($consulta2);
      $pri = $consul->fetch(PDO::FETCH_ASSOC);
        echo '<legend>Listado de licencias del médico "' . $pri['nombre'] . '  ' . $pri['apellido'] . '"</legend>';
      echo 'El médico ' . $pri['nombre'] . '  ' . $pri['apellido'] . ' no posee licencias tomadas';
    } else {
      $pri = $result->fetch(PDO::FETCH_ASSOC);
        echo '<legend>Listado de licencias del médico "' . $pri['nombre'] . '  ' . $pri['apellido'] . '"</legend>';
      echo 'Listado de licencias del médico ' . $pri['nombre'] . ' ' . $pri['apellido'] . '.';
    }
  } else {
    echo "esta llamando incorrectamente a la pagina listado de licencias";
    die();
  }
}
?>  

<form class="form-actions" name="form1" id="form1" action="./medico.php" method="GET">

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