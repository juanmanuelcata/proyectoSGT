<?php
session_start();
if ((isset($_SESSION['usuario']['logueado'])) && ($_SESSION['usuario']['logueado'] == 'si')) {
    header('Location: principal.php');
}
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <title>SGT2</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="Sudo Soft" content="">
        <link href="./css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="./css/propio.css" rel="stylesheet" media="screen">
        <link href="./css/bootstrap.css" rel="stylesheet">
        <link href="./css/index.css" rel="stylesheet">        
        <link rel="shortcut icon" href="./img/favicon.ico" type="image/x-icon"/> 
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> 

    </head>
    <body>
        <div class="row-fluid">
            <div class="span12" id="cabecera2">
                <img SRC="./img/imagenSuper.png" id="cabe1">
            </div>
        </div>  
        <div class="container">
            <div class="content">
                <div class="row">
                    <div class="login-form">
                        <h2>Bienvenido a SGT</h2>
                        Falta asignar: 
editar el formato a botones para simplificar la vista
	superpocicion de licencias

Lautaro:
	Definir el alcance de los permisos de secretaria…
agregar "quienes somos" y "agradecimientos" a la pagina
Turno_alta, si no hay medico ponerlo en el select (o alert), lo mismo en días y horarios.

Pato:
	Ayudas:
		listado de turnos(todo)
		faltan ayudas en paciente_alta, paciente_listado(todo)
		listado_especialidad (boton imprimir)
		alta_OS
		listado_OS(todo)
		todos los reportes
		alta_medico(boton agregar horario)
		listar_medico(boton imprimir)
		alta_Usuario(todo)
		listar_usuario(todo)
		logs(todo)
		
Juancho:
	imprimir los reportes(todos)
	imprimir logs
poner un imprimir individual en detalle de paciente o medico con todos los datos 
Nestor:	
Manual(mas te vale que este genial)



Por el momento esto es lo que se me ocurre que falta, cualquier cosa agreguen a la lista de “falta asignar”

                    </div>
                </div>
            </div>
        </div>
        <script src="http://code.jquery.com/jquery.js"></script>
        <script src="./js/bootstrap.min.js"></script>
    </body>
</html>