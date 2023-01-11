<?php
// session_start();
if (!isset($_SESSION['usuario'])) header('location: ../../index.php?mensaje=Ya hay una sesion activa, acceso no autorizado'); //sesiones activas al tiempo
else {
    $USUARIO = unserialize($_SESSION['usuario']);
}

//codigo en caso de que se generen mensajes desde la adicion, eliminacion o edicion de un usuario
$mensaje = '';
if (isset($_REQUEST['mensaje'])) {
    $mensaje = $_REQUEST['mensaje'];
    $sms = "<div id='alerta' class='alert alert-danger text-center m-2 ' role='alert'>$mensaje</div>";
}

$idUsuario = $USUARIO->getId();
$tipoUsuario = $USUARIO->getTipo_usuario();
switch ($tipoUsuario) {
    case 'A': //Admin (Modo CRUD): muestra todos los perfiles y opciones porque es admin
        // $datosProyectos = Proyecto::getListaEnJson(null, null);
        $modoTabla = 'CRUD';
        echo "Usuario A";
        break;

    case 'D': //Director (modo CRUD filtrado): solo su información de perfil activo
        // $idUsuario = $USUARIO->getId();
        // $filtroUsuario = "id_usuario='$idUsuario'";
        // $datosProyectos = Proyecto::getListaEnJson($filtroUsuario, null);
        // echo "Usuario D";
        // R solo lectura
        $modoTabla = 'CRU';
        break;

    default: //trabajador (modo: Solo lectura): perfiles existentes
        // $datosProyectos = $USUARIO->getProyectosUsuario($USUARIO->getId());
        $modoTabla = 'R';
        // echo "Usuario T";
        break;
}
?>

<h3 class="text-center">PERFIL DE USUARIOS</h3>

<fieldset class="form-group border p-3">
    <div class="container col-auto justify-content-center">
        <div class="row">
            <legend class="w-auto px-2">Perfiles</legend>
            <table id="tblPerfiles" class="table table-responsive table-striped table-borded dataTable-content" cellpacing="0" width="100%"></table>
            <table id="new-Perfile" style="display:none" class="col-auto">
                <tbody>
                    <tr>
                        <td>__nit__</td>
                        <td>__direccion__</td>
                        <td>__direccion__</td>
                        <td>__direccion__</td>
                        <td>__direccion__</td>s
                        <td>__correo__</td>
                        <td>__telefono__</td>
                        <td>__nombre representante__</td>
                        <td>__correo representante__</td>
                        <td>
                            <i class='bi ' +`${claseBotonEditarRow}` aria-hidden="true"></i>
                            <i class='bi ' +`${claseBotonEliminarRow}` aria-hidden="true"></i>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</fieldset>

<fieldset id="fsEstudios" class="form-group border p-3">
    <div class="container col-auto justify-content-center">
        <div class="row">
            <legend class="w-auto px-2">Estudios</legend>
            <table id="tblEstudios" class="table table-responsive table-striped table-borded dataTable-content" cellpacing="0" width="100%"></table>
            <table id="new-Estudio" style="display:none" class="col-auto">
                <tbody>
                    <tr>
                        <td>__nit__</td>
                        <td>__correo__</td>
                        <td>__telefono__</td>
                        <td>__nombre representante__</td>
                        <td>__correo representante__</td>
                        <td>
                            <i class='bi ' +`${claseBotonEditarRow}` aria-hidden="true"></i>
                            <i class='bi ' +`${claseBotonEliminarRow}` aria-hidden="true"></i>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</fieldset>

<fieldset id="fsHabilidades" class="form-group border p-3">
    <div class="container col-auto justify-content-center">
        <div class="row">
            <legend class="w-auto px-2">Habilidades</legend>
            <table id="tblHabilidades" class="table table-responsive table-striped table-borded dataTable-content" cellpacing="0" width="100%"></table>
            <table id="new-Habilidad" style="display:none" class="col-auto">
                <tbody>
                    <tr>
                        <td>__telefono__</t d>
                        <td>__nombre representante__</td>
                        <td>__correo representante__</td>
                        <td>
                            <i class='bi ' +`${claseBotonEditarRow}` aria-hidden="true"></i>
                            <i class='bi ' +`${claseBotonEliminarRow}` aria-hidden="true"></i>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</fieldset>

<script type="module">
    import {
        cargarPerfiles,
        cargarEstudios,
        cargarHabilidades,
    } from './presentacion/vistas/js/perfiles.js';

    <?php echo 'const idUsuario = "' . $idUsuario . '";'; ?>
    <?php echo 'const modoTabla = "' . $modoTabla . '";'; ?>

    $(document).ready(function() {
        cargarPerfiles('tblPerfiles', idUsuario, modoTabla);
        var idPerfilSeleccionado = '';
        var selectorTabla = '#tblPerfiles';

        $(selectorTabla + ' tbody').on('click', 'tr', function() {
            var rowindex = $(this).closest("tr").index();
            //console.log(selectorTabla, rowindex);
            var data = $(selectorTabla).DataTable().row(rowindex).data();

            if (data.id != idPerfilSeleccionado) {
                idPerfilSeleccionado = data.id;
                console.clear();
                cargarEstudios('tblEstudios', idPerfilSeleccionado, modoTabla);
                cargarHabilidades('tblHabilidades', idPerfilSeleccionado, modoTabla);
                // // peticion 
                // fetch('http://localhost/SENA-devmanager/api/PerfilControlador.php?id=' + $idPerfilSeleccionado, {
                //     method: 'GET',
                // }).then((resp) => {
                //     return resp.json();
                // }).then((json) => {
                //     const {
                //         dEstudios,
                //         dHabilidades
                //     } = json;

                //     console.log(dEstudios);

                //     let modoTabla = '';
                //     switch (tUsuario) {
                //         case 'A':
                //             modoTabla = 'CRUD';
                //             break;
                //         case 'D':
                //             modoTabla = 'CRU';
                //             break;
                //         case 'T':
                //             modoTabla = 'R';
                //             break;
                //         default:
                //             break;
                //     }
                //     cargarEstudios('tblEstudios', dEstudios, modoTabla);
                //     cargarHabilidades('tblHabilidades', dHabilidades, modoTabla);
                // });
            }

            // }
        });

        $('#addRowtblPerfiles').click(function() {
            $('#tblEstudios').DataTable().clear().draw();
            $('#tblHabilidades').DataTable().clear().draw();
        });

    });
</script>