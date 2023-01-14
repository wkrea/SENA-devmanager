<?php

require_once 'logica/clasesGenericas/ConectorBD.php';
require_once 'logica/clasesGenericas/Fecha.php';
require_once 'logica/clases/Usuario.php';
require_once 'logica/clases/TipoUsuario.php';
require_once 'logica/clases/Proyecto.php';
require_once 'logica/clases/Habilidad.php';
require_once 'logica/clases/Empresa.php';
require_once 'logica/clases/Estudio.php';
require_once 'logica/clases/Perfil.php';
require_once 'logica/clases/EmpresaAdm.php';


date_default_timezone_set('America/Bogota'); //establecer zona horaria de colombia

session_start();
if (!isset($_SESSION['usuario'])) header('location: index.php?mensaje=Ya hay una sesion activa, acceso no autorizado'); //sesiones activas al tiempo
else {
    $USUARIO = unserialize($_SESSION['usuario']);
    //print_r($USUARIO);
    $tipoUsuario = 'select tipo_usuario from usuarios where identificacion = ' . $USUARIO->getIdentificacion(); //esta linea se hace para obtener el tipo de usuario nuevamente, ya que en serializacion se pierde en caso de actualizacion   
    $menu = TipoUsuario::getMenu(ConectorBD::ejecutarQuery($tipoUsuario)[0][0]);
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="assets/sitio.css" type="text/css">
    <link rel="stylesheet" href="librerias/bootstrap5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    

    <!-- http://jsbin.com/hojexud/edit?html,js,output -->
    <link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css" />
    <link rel="stylesheet" type="text/css" href="https://opensource.keycdn.com/fontawesome/4.7.0/font-awesome.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.3.1/css/buttons.dataTables.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/select/1.5.0/css/select.dataTables.min.css" />


    <script src="//code.jquery.com/jquery-1.12.4.js"></script>

    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/select/1.5.0/js/dataTables.select.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/pdfmake.min.js"></script>
    <script src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/vfs_fonts.js"></script>
    <script src="//cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js"></script>

    <script src="librerias/upload.js"></script>	
    

    <!-- 
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
        <link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css" />
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.css">

        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css"/> 
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.3.1/css/buttons.dataTables.min.css"/>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/select/1.2.2/css/select.dataTables.min.css"/> 

        <script src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script> 
        <script src="//cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/select/1.2.2/js/dataTables.select.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js" ></script>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/datetime/1.2.0/css/dataTables.dateTime.min.css">
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script> -->
    <title>DevManager</title>
</head>

<body>
    <div id="encabezado" class="m-4 text-center">
        <a href="./principal.php" target="">
            <h1 class="display-1">DevManager</h1s>
        </a>
    </div>
    <div id="menu" class="mt-5">
        <?= $menu ?>
    </div>
    <div id="contenido">
        <?= include $_REQUEST['CONTENIDO'] ?>
    </div>

    <script src="librerias/bootstrap5/js/bootstrap.min.js"></script>
</body>

</html>