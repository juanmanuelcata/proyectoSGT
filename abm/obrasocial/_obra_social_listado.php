<?php
$db = conectaDb();
$consulta = "SELECT * from os";
$result = $db->query($consulta);
?>
<legend>Listado de Obras Sociales</legend>
<form class="form-horizontal" name="form" action="./obrasocial/_os_imprimir.php" method="GET" target="_blank">    
    <div class="control-group">
        <table id="tabla1"class="table table-striped">
            <thead>
                <tr>
                    <th>Elegir <button class="btn btn-mini" onclick="return false;" data-original-title="Campo Elegir" data-content="Oprima sobre cada Obra Social para seleccionarla, o utilice los botones de Marcar/Desmarcar todos.">
                            <i class="icon-question-sign"></i>
                        </button></th>
                    <th>Nombre <button class="btn btn-mini" onclick="return false;" data-original-title="Campo Nombre" data-content="Oprima sobre este campo para ordenar la lista por el atributo Nombre de la Obra Social. Cada vez que se oprime cambiará entre forma ascendente y descendente.">
                            <i class="icon-question-sign"></i>
                        </button></th>
                    <th>Activa <button class="btn btn-mini" onclick="return false;" data-original-title="Campo Activa" data-content="Oprima sobre este campo para ordenar la lista por el atributo Activa de la Obra Social. Cada vez que se oprime cambiará entre forma ascendente y descendente.">
                            <i class="icon-question-sign"></i>
                        </button></th>
                    <th>Modificar <button class="btn btn-mini" onclick="return false;" data-original-title="Campo Modificar" data-content="Oprima sobre el ícono del engranaje correspondiente a la Obra Social que desee modificar.">
                            <i class="icon-question-sign"></i>
                        </button></th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!$result)
                    print ("<p>error en la consulta<p>");
                else
                    foreach ($result as $valor) {
                        echo ('<tr>
                                <td><input type="checkbox" name="' . $valor['idos'] . '" value="' . $valor['idos'] . '" id="' . $valor['idos'] . '"></td>                                  
                                <td>' . $valor['nombre'] . '</td>');
                        if ($valor['activo'])
                            echo ('<td>SI</td>');
                        else
                            echo ('<td>NO</td>');
                        echo ('<td><a href="/abm/obraSocial.php?code=c&id=' . $valor['idos'] . '"><i class="icon-cog"></i></a></td></tr>');
                    }
                ?>

            </tbody>
        </table>
    </div>
    <br><br><br> 
    <a href="javascript:seleccionar_todo()">Marcar todos</a> | 
    <a href="javascript:deseleccionar_todo()">Desmarcar todos</a>
    <button class="btn btn-mini" id='ayuda' onclick="return false;" data-original-title="Opciones de marcado" data-content="Oprima 'Marcar todos' para seleccionar todas las Obras Sociales visualizadas u oprima 'Desmarcar todos' para desmarcar todas las especialidades que estén visualizadas.">
        <i class="icon-question-sign"></i>
    </button>
    <button type="submit" class="btn btn-success offset1">Imprimir</button>
    <button class="btn btn-mini" onclick="return false;" data-original-title="Imprimir" data-content="Seleccione las Obras Sociales que desee imprimir haciendo click sobre el campo 'Elegir' de cada uno o utilizando el botón de 'Marcar todos'. Una vez hecho esto oprima el botón 'Imprimir' y se abrirá una nueva ventana con un documento pdf el cual podrá imprimir utilizando las opciones del navegador que esté usando.">
        <i class="icon-question-sign"></i>
    </button>

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