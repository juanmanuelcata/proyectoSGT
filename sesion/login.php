<?php
session_start();
if ((isset($_SESSION['usuario']['logueado'])) && ($_SESSION['usuario']['logueado'])=='si'){
    $ahora = date("j-n-Y H:i:s");
    $tiempo_transcurrido = (strtotime($ahora)-strtotime($_SESSION['usuario']['tiempo'])); 
    if($tiempo_transcurrido >= 120000){//1200 milisegundos = 1200/60 = 20 Minutos...
        session_destroy();
        header("Location: ./../index.php?er=3");
    }
    else{
         $_SESSION['usuario']['tiempo']= date("j-n-Y H:i:s");
    }
    
}
else
{
  header('Location: index.php?er=2');
}?>