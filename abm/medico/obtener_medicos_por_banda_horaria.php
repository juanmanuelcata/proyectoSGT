<?php
include_once('../../sesion/login.php');
include_once './../../fragmentos/_conectDb.php';
$db = conectaDb();

$consulta = "select * from medico";
$result2 = $db->query($consulta);


$hora1 = $_POST['hora1'];
$hora2 = $_POST['hora2'];
?>
<div id="banana2">
    <table id="tabla3" class="table table-striped">
        <thead>
            <tr>
                <th>Elegir <button class="btn btn-mini" onclick="return false;" data-original-title="Campo Elegir para impresión" data-content="Oprima sobre cada Reporte para seleccionarlo, o utilice los botones de Marcar o Desmarcar todos.">
                        <i class="icon-question-sign"></i>
                    </button></th>
                <th>Médico <button class="btn btn-mini" onclick="return false;" data-original-title="Campo Médico" data-content="Oprima sobre este campo para ordenar la lista por el Nombre y Apellido del Médico. Cada vez que se oprime cambiará entre forma ascendente y descendente.">
                        <i class="icon-question-sign"></i>
                    </button></th>
                <th>Día <button class="btn btn-mini" onclick="return false;" data-original-title="Campo Día" data-content="Oprima sobre este campo para ordenar la lista por el atributo Día de la consulta. Cada vez que se oprime cambiará entre forma ascendente y descendente.">
                        <i class="icon-question-sign"></i>
                    </button></th>
                <th>Desde <button class="btn btn-mini" onclick="return false;" data-original-title="Campo Desde" data-content="Oprima sobre este campo para ordenar la lista por la hora de inicio de la consulta. Cada vez que se oprime cambiará entre forma ascendente y descendente.">
                        <i class="icon-question-sign"></i>
                    </button></th>
                <th>Hasta <button class="btn btn-mini" onclick="return false;" data-original-title="Campo Hasta" data-content="Oprima sobre este campo para ordenar la lista por la hora de finalización de la consulta. Cada vez que se oprime cambiará entre forma ascendente y descendente.">
                        <i class="icon-question-sign"></i>
                    </button></th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ((($hora1 != NULL) && ($hora1 != 'Elija un horario')) && (($hora2 != NULL) && ($hora2 != 'Elija un horario'))) {
                $conhorarios = "select nombre, apellido, dia, min(desde) desde, max(hasta) hasta, id_med from horario inner join medico on (horario.id_med = medico.idmedico)
                        where desde >= '$hora1' and hasta <= '$hora2' group by id_med, dia";
                $result2 = $db->query($conhorarios);
                $cantMed = $result2->rowCount();
            } else {
                $conhorarios = "select nombre, apellido, dia, min(desde) desde, max(hasta) hasta, id_med from horario inner join medico on (horario.id_med = medico.idmedico) group by id_med, dia";
                $result2 = $db->query($conhorarios);
            }
            ?>
            <?php foreach ($result2 as $valor2): ?> 
                <?php $medico = $valor2['nombre'] . ' ' . $valor2['apellido']; ?>
                <tr>
                    <td><input type="checkbox" name="<?php echo $valor['id'] ?>" value="<?php echo $valor['id'] ?>" id="<?php echo $valor['id'] ?>"></td>
                    <td><?php echo $medico ?></td>
                    <td><?php echo $valor2['dia'] ?></td>    
                    <td><?php echo $valor2['desde'] ?></td>
                    <td><?php echo $valor2['hasta'] ?></td>    
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <br><br><br>
    <?php if (isset($cantMed)): ?>
        <p><strong>Total: </strong></label><?php echo $cantMed ?> médicos</p>
    <?php endif; ?>
</div>
<script type="text/javascript">
                    $(document).ready(function() {
                        $('#tabla3').dataTable({
                            "sScrollY": 200,
                            "bScrollCollapse": true,
                            "sScrollX": "100%",
                            "sScrollXInner": "110%",
                            "bJQueryUI": true,
                            "sPaginationType": "full_numbers",
                            "oLanguage": {
                                "sLengthMenu": 'Display <select>' +
                                        '<option value="10">10</option>' +
                                        '<option value="20">20</option>' +
                                        '<option value="30">30</option>' +
                                        '<option value="40">40</option>' +
                                        '<option value="50">50</option>' +
                                        '<option value="-1">Todo</option>' +
                                        '</select> records'
                            }
                        });
                    });
</script>