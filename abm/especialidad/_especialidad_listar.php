<?php
if (isset($_GET['esp_nue'])) {
    $db = conectaDb();
    $esp_nue = $_GET['esp_nue'];
    $esp_selec = $_GET['esp_selec'];
    $consulta = "SELECT * from especialidad where (nombre = '$esp_nue')";
    $result = $db->query($consulta);
    if ($result->rowCount() > 0) {
        print ('Esa esecialidad ya esta registrada');
    }
    else
        $consulta = 'update especialidad set nombre = "' . $esp_nue . '" where nombre = "' . $esp_selec . '"';
    if ($db->query($consulta)) {
        echo '<h4>Se modifico correctamente la especialidad: ' . $esp_selec . ' por ' . $esp_nue . '</h4>';
    } else {
        echo '<fieldset  class="control-group error">
                            <span class="help-inline">Error al conectarte con la base de datos.</span>
             </fieldset>';
    }
}
$db = null;
?>
<legend>Listado de especialidades</legend>
<form class="form-horizontal" name="form" action="./especialidad/_especialidad_imprimir.php" method="GET" target="_blank">    
    <div class="control-group">
        <table id="tabla1"class="table table-striped">
            <thead>
                <tr>
                    <th>Elegir <button class="btn btn-mini" onclick="return false;" data-original-title="Campo Elegir" data-content="Oprima sobre cada especialidad para seleccionarla, o utilice los botones de Marcar o Desmarcar todos.">
                            <i class="icon-question-sign"></i>
                        </button></th> 
                    <th>Nombre <button class="btn btn-mini" onclick="return false;" data-original-title="Campo Nombre" data-content="Oprima sobre este campo para ordenar la lista por el atributo Nombre. Cada vez que se oprime cambiará entre forma ascendente y descendente.">
                            <i class="icon-question-sign"></i>
                        </button></th>
                    <th>Activa <button class="btn btn-mini" onclick="return false;" data-original-title="Campo Activa" data-content="Oprima sobre este campo para ordenar la lista por el atributo Activa. Cada vez que se oprime cambiará entre forma ascendente y descendente.">
                            <i class="icon-question-sign"></i>
                        </button></th>
                    <th>Modificar <button class="btn btn-mini" onclick="return false;" data-original-title="Campo Modificar" data-content="Oprima sobre el engranaje correspondiente de la especialidad que desee modificar.">
                            <i class="icon-question-sign"></i>
                        </button></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $datab = conectaDb();
                $consulta = "SELECT *
                                         FROM especialidad";
                $result = $datab->query($consulta);
                if (!$result)
                    print ("<p>Error en la consulta<p>");
                else
                    foreach ($result as $valor) {
                        echo ('<tr>
                                      <td><input type="checkbox" name="' . $valor['idespecialidad'] . '" value="' . $valor['idespecialidad'] . '" id="' . $valor['idespecialidad'] . '"></td>                                  
                                      <td>' . $valor['nombre'] . '</td>');
                        if ($valor['activa'])
                            echo ('<td>SI</td>');
                        else
                            echo ('<td>NO</td>');
                        echo ('<td><a href="/abm/especialidad.php?code=c&id=' . $valor['idespecialidad'] . '"><i class="icon-cog"></i></a></td></tr>');
                    }
                ?>

            </tbody>
        </table>
    </div>
    <br><br><br> 
    <a href="javascript:seleccionar_todo()">Marcar todos</a> | 
    <a href="javascript:deseleccionar_todo()">Desmarcar todos</a>
    <!--ayuda-->
    <button class="btn btn-mini" id='ayuda' onclick="return false;" data-original-title="Opciones de marcado" data-content="Oprima 'Marcar todos' para seleccionar todas las especialidades visualizadas u oprima 'Desmarcar todos' para desmarcar todas las especialidades que estén visualizadas.">
        <i class="icon-question-sign"></i>
    </button>

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