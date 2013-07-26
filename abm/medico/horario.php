<div id="horario_div_<?php echo $_POST['numeroHorario']; ?>" class="nuevoHorario">
    <legend><button onClick="borrarHorario(<?php echo $_POST['numeroHorario']; ?>);
            return false;
            return false;"><i class="icon-remove"></i></button>Horario numero <?php echo $_POST['numeroHorario']; ?></legend>
    <fieldset>
        <?php $n = $_POST['numeroHorario'] ?>
        <label>Día</label>
        <select class="span5" name="horario[<?php echo $_POST['numeroHorario']; ?>][dia]" id="dia<?php echo $n; ?>" >
            <option selected="selected">Elija un día</option>
            <option value="lun">Lunes</option>
            <option value="mar">Martes</option>
            <option value="mie">Miércoles</option>
            <option value="jue">Jueves</option>
            <option value="vie">Viernes</option>

        </select>

        <script>
        //ESTA ES LA LIÑITA MAGICA
        $(".btn").popover({trigger: "hover"});
        </script>

        <button class="btn" onclick="return false;" data-original-title="Seleccion del día de atención del médico" data-content="Oprima sobre el botón el campo a la izquierda (o sobre la flecha hacia abajo) para desplegar la lista de días hábiles. Haga click sobre el día correspondiente.">
            <i class="icon-question-sign"></i>
        </button>

        <label>Desde</label>
        <select class="span5" name="horario[<?php echo $_POST['numeroHorario']; ?>][desde]" id="horarios<?php echo $n; ?>">
            <option selected="selected">Elija un horario</option>
            <?php
            for ($i = 8; $i < 20; $i++) {
                echo "<option value=\"$i:00\">$i:00</option>";
            }
            ?>
        </select>

        <button class="btn" onclick="return false;" data-original-title="Seleccion de la hora de atención del médico" data-content="Oprima sobre el botón el campo a la izquierda (o sobre la flecha hacia abajo) para desplegar la lista de horas hábiles. Haga click sobre la hora correspondiente al inicio de la consulta.">
            <i class="icon-question-sign"></i>
        </button>


        <label>Hasta</label>
        <select class="span5" name="horario[<?php echo $_POST['numeroHorario']; ?>][hasta]" id="horariosHasta<?php echo $n; ?>" onchange="verificarHorario(numeroHorario - 1)">
            <option selected="selected">Elija un horario</option>
            <?php
            for ($i = 8; $i < 20; $i++) {
                echo "<option value=\"$i:00\">$i:00</option>";
            }
            ?>
        </select>

        <button class="btn" onclick="return false;" data-original-title="Seleccion de la hora de atención del médico" data-content="Oprima sobre el botón el campo a la izquierda (o sobre la flecha hacia abajo) para desplegar la lista de horas hábiles. Haga click sobre la hora correspondiente a la finalización de la consulta.">
            <i class="icon-question-sign"></i>
        </button>

    </fieldset>
    <br>
</div>
