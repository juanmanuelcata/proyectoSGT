<?php
$db = conectaDb();
$id = $_GET['id'];

$consulta = "SELECT * FROM medico WHERE idmedico =' $id '";
$result = $db->query($consulta);
$campos = $result->fetch(PDO::FETCH_ASSOC);


// COnsulta aparte para las obras sociales

$consulta2 = "SELECT * FROM med_os INNER JOIN os ON med_os.id_med =' $id ' AND med_os.id_os = os.idos";
$result2 = $db->query($consulta2);
//$campos2 = $result2->fetch(PDO::FETCH_ASSOC);
?>



<label><strong>Nombre: </strong><?php echo ($campos['nombre']) ?></label>
<br>
<label><strong>Apellido: </strong><?php echo ($campos['apellido']) ?></label>
<br>
<label><strong>DNI: </strong><?php echo ($campos['dni']) ?></label>
<br>
<?php
foreach ($result2 as $valor) {
    echo "<label><strong>Obra Social: </strong>";
    if ($valor['activo'] == 1)
        echo '<td>' . $valor['nombre'] . '</td>';
    else
        echo '<td><p style="color: #FF0000">' . $valor['nombre'] . '</p></td>';
    echo "</label><br>";
}
?>

<label><strong>Teléfono: </strong><?php echo ($campos['telefono']) ?></label>
<br>
<label><strong>Matrícula: </strong><?php echo ($campos['matricula']) ?></label>
<br>  
<label><strong>Mail: </strong><?php echo ($campos['mail']) ?></label>
<br>
<label><strong>Ingreso: </strong><?php echo ($campos['ingreso']) ?></label>
<br>
   
    <a href="./medico.php?code=m&id=<?php echo ($campos['idmedico']) ?>" class="btn btn-success">Modificar</a>
