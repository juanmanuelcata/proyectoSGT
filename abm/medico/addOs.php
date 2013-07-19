<?php include_once ("./../../fragmentos/_conectDb.php"); ?>

<div id="os_div_<?php echo $_POST['numeroOs']; ?>">
    <legend><button onClick="borrarOs(<?php echo $_POST['numeroOs']; ?>);
          return false;"><i class="icon-remove"></i></button>Obra social numero <?php echo $_POST['numeroOs']; ?></legend>
    <fieldset>
        <?php
        $db = conectaDb();
        $consulta = "SELECT * FROM os where activo = 1";
        $result = $db->query($consulta);
        if (!$result)
            print ("<p>error en la consulta<p>");
        else
            
            ?>
        <select tabindex="12" class="select-xlarge" name="os_select[<?php echo $_POST['numeroOs']; ?>][nombre]" >
            <?php
            foreach ($result as $valor)
                if ($valor['nombre'] == 'Ninguna')
                    echo '<option Selected="Selected">' . $valor['nombre'] . '</option>';
                else
                    echo '<option>' . $valor['nombre'] . '</option>';
            ?>
        </select>
        <div id="otraOs">
        </div> 

    </fieldset>
    <br>
</div>
