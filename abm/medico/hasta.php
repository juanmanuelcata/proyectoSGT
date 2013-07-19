   

    <label>Hasta</label>
    <select class="span5" name="horario[<?php echo $_POST['numeroHorario']; ?>][hasta]" >
      <option selected="selected">Elija un horario</option>
      <?php
      for ($i = $_POST['numeroHasta']; $i < 20; $i++) {
        echo "<option value=\"$i:00\">$i:00</option>";
      }
      ?>
    </select>