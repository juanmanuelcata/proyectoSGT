<?php

session_start();
include_once './../fragmentos/_conectDb.php';
$db = conectaDb();
$consulta = 'SELECT Count(*)
                    FROM usuario 
                    WHERE ("' . $_POST['usr'] . '" = user) and ("' . $_POST['pass'] . '" = clave)';
$result = $db->query($consulta);
if ($result->fetchColumn() == 1) {
    $c='select * from usuario WHERE ("' . $_POST['usr'] . '" = user) and ("' . $_POST['pass'] . '" = clave)';
    $res=$db->query($c);
    $arr = $res->fetch(PDO::FETCH_ASSOC);
    $_SESSION['usuario']['id'] = $arr['idusuario'];
    $_SESSION['usuario']['user'] = $arr['user'];
    $_SESSION['usuario']['admin'] = $arr['admin'];
    $_SESSION['usuario']['logueado'] = 'si';
    $_SESSION['usuario']['tiempo'] = date("j-n-Y H:i:s");
    header('Location: ./../principal.php');
} else {
    header('Location: ../index.php?er=1');
}
?>