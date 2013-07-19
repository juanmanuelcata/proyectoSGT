<?php
$db = conectaDb();
$consulta = "SELECT * from os";
$result = $db->query($consulta);
?>
<legend>Listado de obras sociales</legend>
<form class="form-horizontal" name="form" action="./obrasocial/_os_imprimir.php" method="GET" target="_blank">    
<div class="control-group">
  <table id="tabla1"class="table table-striped">
                    <thead>
                        <tr>
                            <th>Elegir</th>
                            <th>Nombre</th>
                            <th>Activa</th>
                            <th>Modificar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!$result)
                            print ("<p>error en la consulta<p>");
                        else
                            foreach ($result as $valor) {
                                echo ('<tr>
                                <td><input type="checkbox" name="'.$valor['idos'].'" value="'.$valor['idos'].'" id="'.$valor['idos'].'"></td>                                  
                                <td>' . $valor['nombre'] . '</td>');
                                if ($valor['activo'])
                                    echo ('<td>SI</td>');
                                else
                                    echo ('<td>NO</td>');
                                echo ('<td><a href="/abm/obraSocial.php?code=c&id='.$valor['idos'].'"><i class="icon-cog"></i></a></td></tr>');
                                
                            }
                        ?>

                    </tbody>
                </table>
    </div>
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