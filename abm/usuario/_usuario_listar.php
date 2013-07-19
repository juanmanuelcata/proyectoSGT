<?php
$db = conectaDb();
$consulta = "SELECT * from usuario";
$result = $db->query($consulta);

?>
<form class="form-horizontal" name="form" action="./usuario/_usuario_imprimir.php" method="GET" target="_blank">

<table id="tabla1" class="table table-striped">
    <thead>
        <tr>
            <th>Elegir</th>
            <th>User</th>
<!--            <th>Nombre</th>
            <th>Apellido</th>-->
            <th>DNI</th>
            <th>Modificar</th>
            <th>Detalle</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($result as $valor)
            echo ('<tr>
                <td><input type="checkbox" name="'.$valor['idusuario'].'" value="'.$valor['idusuario'].'" id="'.$valor['idusuario'].'"></td>              
                <td>' . $valor['user'] . '</td>
                <td>' . $valor['dni'] . '</td>
                <td><a href="./usuario.php?code=m&id='.$valor['idusuario'].'"><i class="icon-cog"></i></a></td>
                <td><a href="./usuario.php?code=d&id='.$valor['idusuario'].'"><i class="icon-eye-open"></i></a></td></tr>');
        ?>
    </tbody>    
</table>
  <br><br><br> 
<a href="javascript:seleccionar_todo()">Marcar todos</a> | 
<a href="javascript:deseleccionar_todo()">Desmarcar todos</a> 
<button type="submit" class="btn btn-success offset1">Imprimir</button>
</form>

<script>
function seleccionar_todo(){ 
   for (i=0;i<document.form.elements.length;i++) 
      if(document.form.elements[i].type == "checkbox")	
         document.form.elements[i].checked=1 
} 

function deseleccionar_todo(){ 
   for (i=0;i<document.form.elements.length;i++) 
      if(document.form.elements[i].type == "checkbox")	
         document.form.elements[i].checked=0 
} 
</script>
