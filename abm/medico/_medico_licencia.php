
<?php
include_once('../../sesion/login.php');
include_once('../../fragmentos/_conectDb.php');
if ($_SESSION['usuario']['admin'] == '1') {
    
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
        <link href="./../../css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="./../../datatables/css/bootstrap.css" rel="stylesheet">
        <link href="./../../datatables/css/jquery.dataTables_themeroller.css" rel="stylesheet">
        <link href="./../../css/propio.css" rel="stylesheet" media="screen">
        <link rel="stylesheet" type="text/css" href="./../../css/menu.css" />
        <link rel="shortcut icon" href="./../../img/favicon.ico" type="image/x-icon"/> 
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> 
        <script type="text/javascript" src="./../../js/validacion.js"></script>
        <script type="text/javascript" src="./../../datatables/js/jquery.js"></script>
        <script type="text/javascript" src="./../../datatables/js/jquery.dataTables.js"></script>   
        <script type="text/javascript" src="./../../js/bootstrap-alert.js"></script>
        <script type="text/javascript" src="./../../js/bootstrap-tooltip.js"></script>
        <script type="text/javascript" src="./../../js/bootstrap-popover.js"></script>
    </head>


    <div class="row-fluid">
        <div class="span12">
            <img SRC="./../../img/imagenSuper.png" id="cabe1">
        </div>
    </div>        
    <div class="row-fluid">
        <div class="span12">
            <div class="row-fluid">
                <div class="span10 offset1">

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
                        echo '<legend>Listado de licencias del Médico "' . $seg['nombre'] . '  ' . $seg['apellido'] . '"</legend>';
//mi codigo laucha
                        $hoy = date('Y-m-d');
                        if (($hasta < $desde) || ($desde < $hoy)) {
                            echo '<div class="alert alert-error">  
                <a class="close" data-dismiss="alert">×</a>  
                <strong><h4>Error!</h4> El intervalo ingresado no es válido.</strong> 
             </div>';
                            // || ($desde >= $hoy)){
                        } else {
                            $consulta = "SELECT * FROM licencia where id_med = '$idmedico' and hasta >= '$hoy'";
                            $result = $db->query($consulta);
                            if ($result->rowCount() > 0) {
                                echo '<div class="alert alert-error">  
                <a class="close" data-dismiss="alert">×</a>  
                <strong><h4>Error!</h4> El Médico tiene una licencia pendiente o en curso.</strong> 
             </div>';
                            } else {
                                $consulta = "SELECT * FROM turno where id_med = '$idmedico' and estado = 'pendiente'";
                                $result = $db->query($consulta);
                                if ($result->rowCount() > 0) {
                                    echo '<div class="alert alert-error">  
                <a class="close" data-dismiss="alert">×</a>  
                <strong><h4>Error!</h4> El Médico tiene turnos pendientes en ese intervalo.</strong> 
             </div>';
                                } else {
                                    $consulta = "insert into licencia (desde, hasta, id_med)
                values ('$desde', '$hasta', '$idmedico')";
                                    if ($db->query($consulta)) {
                                        echo '<div class="alert alert-success">  
                    <a class="close" data-dismiss="alert">×</a>  
                    <h4><strong>Muy Bien!</strong><br>
                    Se insertó correctamente la licencia.</h4>  
                </div>';
                                    } else {
                                        echo '<div class="alert alert-error">  
                <a class="close" data-dismiss="alert">×</a>  
                <strong><h4>Error!</h4>No pudo darse el alta correctamente. Comuniquese con el administrador.</strong> 
             </div>';
                                    }
                                }
                            }
                        }
                    } else {
                        if (isset($_GET['id'])) {
                            $idmedico = $_GET['id'];
                            $consulta = "SELECT * from medico inner join licencia on ( idmedico = id_med) where '$idmedico' = id_med";
                            $result = $db->query($consulta);
                            if (!$result->rowCount()) {
                                $consulta2 = "select * from medico where idmedico = $idmedico";
                                $consul = $db->query($consulta2);
                                $pri = $consul->fetch(PDO::FETCH_ASSOC);
                                echo '<legend>Listado de licencias del Médico "' . $pri['nombre'] . '  ' . $pri['apellido'] . '"</legend>';
                                echo 'El Médico ' . $pri['nombre'] . '  ' . $pri['apellido'] . ' no posee licencias tomadas';
                            } else {
                                $pri = $result->fetch(PDO::FETCH_ASSOC);
                                echo '<legend>Listado de licencias del Médico "' . $pri['nombre'] . '  ' . $pri['apellido'] . '"</legend>';
                            }
                        } else {
                            echo "esta llamando incorrectamente a la página listado de licencias";
                            die();
                        }
                    }
                    ?>  

                    <form class="form-actions" name="form1" id="form1" action="./_medico_licencia.php" method="GET">

                        <input type="date" tabindex="1" class="input-xlarge" id="desde" name="desde" required/>
                        <button class="btn btn-mini" onclick="return false;" data-original-title="Fecha de inicio de la licencia del Médico" data-content="Increse la fecha de inicio de la licencia del Médico utilizando solo caracteres numéricos. Puede también utilizar la flecha hacia abajo para desplegar el calendario y oprimiendo sobre el día correspondiente al mes y año que esten visualizados. Puede optar por seleccionar un campo de la fecha (dia, mes o año) haciendo click sobre el mismo y con las flechas hacia arriba y abajo escribir la fecha deseada. Es obligatorio.">
                            <i class="icon-question-sign"></i>
                        </button>
                        <input type="date" tabindex="2" class="input-xlarge" id="hasta" name="hasta" required/>
                        <button class="btn btn-mini" onclick="return false;" data-original-title="Fecha de finalización de la licencia del Médico" data-content="Increse la fecha de finalización de la licencia del Médico utilizando solo caracteres numéricos. Puede también utilizar la flecha hacia abajo para desplegar el calendario y oprimiendo sobre el día correspondiente al mes y año que esten visualizados. Puede optar por seleccionar un campo de la fecha (dia, mes o año) haciendo click sobre el mismo y con las flechas hacia arriba y abajo escribir la fecha deseada. Es obligatorio.">
                            <i class="icon-question-sign"></i>
                        </button>
                        <input type="hidden" name="ok" value="1"/>
                        <input type="hidden" name="code" value="li"/>
                        <input type="hidden" name="id" value="<?php echo $idmedico ?>"/>
                        <br>
                        <button class="btn btn-success" type="submit">Agregar Licencia</button>

                    </form>

                    <legend></legend>

                    <form class="form-horizontal" name="form2" id="form2" action="./medico/_medico_imprimir.php" method="GET" target="_blank">    
                        <div class="control-group">
                            <table id="tabla1" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Elegir <button class="btn btn-mini" onclick="return false;" data-original-title="Campo Elegir" data-content="Oprima sobre cada licencia para seleccionarla, o utilice los botones de Marcar o Desmarcar todos.">
                                                <i class="icon-question-sign"></i>
                                            </button></th>
                                        <th>Desde <button class="btn btn-mini" onclick="return false;" data-original-title="Campo Desde" data-content="Oprima sobre este campo para ordenar la lista por el atributo Desde, referido al inicio de la licencia. Cada vez que se oprime cambiará entre forma ascendente y descendente.">
                                                <i class="icon-question-sign"></i>
                                            </button></th>
                                        <th>Hasta <button class="btn btn-mini" onclick="return false;" data-original-title="Campo Hasta" data-content="Oprima sobre este campo para ordenar la lista por el atributo Hasta, referido a la finalización de la licencia. Cada vez que se oprime cambiará entre forma ascendente y descendente.">
                                                <i class="icon-question-sign"></i>
                                            </button></th>
                                        <th>Borrar <button class="btn btn-mini" onclick="return false;" data-original-title="Campo Borrar" data-content="Oprima sobre el botón de cerrar ('x') correspondiente a la licencia que desee borrar.">
                                                <i class="icon-question-sign"></i>
                                            </button></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $idmedico = $_GET['id'];
                                    $consulta = "SELECT * from licencia where $idmedico = id_med";
                                    $result = $db->query($consulta);
                                    ?>
                                    <?php
                                    foreach ($result as $valor):
                                        $hoy = date('Y-m-d');
                                        ?>
                                        <tr>
                                            <td><input type="checkbox" name="<?php echo $valor['id'] ?>" value="<?php echo $valor['id'] ?>" id="<?php echo $valor['id'] ?>"></td>
                                            <td><?php echo $valor['desde'] ?></td>
                                            <td><?php echo $valor['hasta'] ?></td>
                                            <?php if ($valor['desde'] >= $hoy): ?>
                                                <td><button class="btn btn-danger" onClick="return false;" value="<?php echo $valor['id'] ?>"><i class="icon-remove"></i></button></td>
                                            <?php else: ?>
                                                <td><button disabled="disabled" class="btn btn-danger" onClick="return false;" value="<?php echo $valor['id'] ?>"><i class="icon-remove"></i></button></td>
                                            <?php endif; ?>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <br> 
                        <a href="javascript:seleccionar_todo()">Marcar todos</a> | 
                        <a href="javascript:deseleccionar_todo()">Desmarcar todos</a>
                        <button class="btn btn-mini" onclick="return false;" data-original-title="Opciones de marcado" data-content="Oprima 'Marcar todos' para seleccionar todas las licencias visualizadas u oprima 'Desmarcar todos' para desmarcar todas las licencias que estén visualizadas.">
                            <i class="icon-question-sign"></i>
                        </button>
                        <button type="submit" class="btn btn-success offset1">Imprimir</button>
                        <button class="btn btn-mini" id='ayuda' onclick="return false;" data-original-title="Imprimir" data-content="Seleccione las licencias del Médico que desee imprimir haciendo click sobre el campo 'Elegir' de cada uno o utilizando el botón de 'Marcar todos'. Una vez hecho esto oprima el botón 'Imprimir' y se abrirá una nueva ventana con un documento pdf el cual podrá imprimir utilizando las opciones del navegador que esté usando.">
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

                            $('.btn-danger').click(function() {
                                $(this).parent().parent().remove();

                                $.ajax({
                                    url: '_borrar_li.php',
                                    type: 'POST',
                                    data: {
                                        idli: $(this).val()
                                    },
                                    success: function(data) {
                                        var datos = eval('(' + data + ')');
                                        /* ahora usas datos como si fuera un objeto */
                                        switch (datos.resultado) {
                                            case 1:
                                                alert('Anulación exitosa.');
                                                break;
                                            case 2:
                                                alert('Falla en la anulación.');
                                                break;
                                        }
                                    }
                                });
                            });


                            $(document).ready(function() {
                                $('#tabla1').dataTable({
                                    "sScrollY": 200,
                                    "bScrollCollapse": true,
                                    "sScrollX": "100%",
                                    "sScrollXInner": "110%",
                                    "bJQueryUI": true,
                                    "sPaginationType": "full_numbers",
                                    "oLanguage": {
                                        "sLengthMenu": 'Mostrando de a <select>' +
                                                '<option value="10">10</option>' +
                                                '<option value="20">20</option>' +
                                                '<option value="30">30</option>' +
                                                '<option value="40">40</option>' +
                                                '<option value="50">50</option>' +
                                                '<option value="-1">Todo</option>' +
                                                '</select> filas'
                                    }
                                });
                            });


                            //            ESTA ES LA LIÑITA MAGICA
                            $(".btn").popover({trigger: "hover"});


                    </script>
                </div>                
            </div>
        </div>
    </div>
</body>
</html>

