<?php
//session_start();
if (!isset($_SESSION['usuario'])) header('location: ../../index.php?mensaje=Ya hay una sesion activa, acceso no autorizado'); //sesiones activas al tiempo
else {
    $USUARIO = unserialize($_SESSION['usuario']);
    //codigo en caso de que se generen mensajes desde la adicion, eliminacion o edicion de un usuario
    $mensaje = '';
    if (isset($_REQUEST['mensaje'])) {
        $mensaje = $_REQUEST['mensaje'];
        $sms = "<div id='alerta' class='alert alert-danger text-center m-2 ' role='alert'>$mensaje</div>";
    }
}

$idUsuario = $USUARIO->getId();
$tipoUsuario = $USUARIO->getTipo_usuario();
switch ($tipoUsuario) {
    case 'A': //Admin (Modo CRUD): muestra todos los perfiles y opciones porque es admin
        // $datosProyectos = Proyecto::getListaEnJson(null, null);
        $modoTabla = 'CRUD';
        break;

    case 'D': //Director (modo CRUD filtrado): solo su información de perfil activo
        // $idUsuario = $USUARIO->getId();
        // $filtroUsuario = "id_usuario='$idUsuario'";
        // $datosProyectos = Proyecto::getListaEnJson($filtroUsuario, null);
        // R solo lectura
        $modoTabla = 'CRUD';
        break;

    default: //trabajador (modo: Solo lectura): perfiles existentes
        // $datosProyectos = $USUARIO->getProyectosUsuario($USUARIO->getId());
        $modoTabla = 'R';
        break;
}
?>

<!-- <h3 class="text-center">ADMINISTRACION</h3> -->

<fieldset class="form-group border p-3">
    <div class="container col-auto justify-content-center">
        <div class="row">
            <legend class="w-auto px-2">
                <h3>Empresas registradas</h3>
            </legend>

            <table id="tblEmpresas" class="table table-responsive table-striped table-borded dataTable-content" cellpacing="0" width="100%"></table>
            <!-- <div class="col align-self-center">
                <textarea id="campoDescripcion" type="text" class="form-control" style="min-width: 100%" rows="5" disabled="disabled"></textarea>
            </div> -->

            <table id="new-Empresa" style="display:none" class="col-auto">
                <tbody>
                    <tr>
                        <td></td>
                        <td>__id__</td>
                        <td>__nit__</td>
                        <td>__nombre__</td>
                        <td>__direccion__</td>
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
        <!-- <br> 
        <div class="row">
            <div class="col align-self-start"></div>
            <div class="col align-self-center"></div>
            <div id="botonesGuardarCambios" class="col align-self-end" disabled="disabled">
                <button type="button" id="btn-cancel" class="btn btn-secondary" data-dismiss="modal">Revertir Cambios</button>
                <button type="button" id="btn-save" class="btn btn-primary" data-dismiss="modal">Guardar Cambios</button>
            </div>
        </div> -->
    </div>

</fieldset>

<fieldset id='fsEmpleados' class="form-group border p-3">
    <div class="container col-auto justify-content-center">
        <div class="row">
            <legend class="w-auto px-2">
                <h3>Usuarios registrados</h3>
            </legend>

            <table id="tblEmpleados" class="table table-responsive table-striped table-borded dataTable-content" cellpacing="0" width="100%"></table>
            <!-- <div class="col align-self-center">
                <textarea id="campoDescripcion" type="text" class="form-control" style="min-width: 100%" rows="5" disabled="disabled"></textarea>
            </div> -->

            <table id="new-Empleado" style="display:none" class="col-auto">
                <tbody>
                    <tr>
                        <td></td>
                        <td>_id_</td>
                        <td>_identificacion_</td>
                        <td>_tipo identificacion_</td>
                        <td>_nombre Usuario_</td>
                        <td>_apellido_</td>
                        <td>_correo_</td>
                        <td>_direccion_</td>
                        <td>_direccion_</td>
                        <td>_foto_</td>
                        <td>_Telefono_</td>
                        <td>_tipoUsuario_</td>
                        <td>_Empresa_</td>
                        <td>
                            <i class='bi ' +`${claseBotonEditarRow}` aria-hidden="true"></i>
                            <i class='bi ' +`${claseBotonEliminarRow}` aria-hidden="true"></i>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- <br> 
        <div class="row">
            <div class="col align-self-start"></div>
            <div class="col align-self-center"></div>
            <div id="botonesGuardarCambios" class="col align-self-end" disabled="disabled">
                <button type="button" id="btn-cancel" class="btn btn-secondary" data-dismiss="modal">Revertir Cambios</button>
                <button type="button" id="btn-save" class="btn btn-primary" data-dismiss="modal">Guardar Cambios</button>
            </div>
        </div> -->
    </div>

</fieldset>

<!-- <script type="text/javascript" src="assets/barraBusqueda.js"></script> -->
<script type="module">
    import {
        cargarEmpresas,
        cargarTrabajadores
    } from './presentacion/vistas/js/empresas.js'

    <?php echo 'const  idUsuario = "' . $idUsuario . '";'; ?>
    <?php echo 'const  modoTabla = "' . $modoTabla . '";'; ?>

    $(document).ready(function() {
        cargarEmpresas('tblEmpresas', idUsuario, modoTabla);
        var idEmpresaSeleccionada = '';
        var selectorTabla = '#tblEmpresas'

        $(selectorTabla + ' tbody').on('click', 'tr', function() {
            var rowindex = $(this).closest("tr").index();
            var data = $(selectorTabla).DataTable().row(rowindex).data();

            if (data.id != idEmpresaSeleccionada) {
                var id_usuario = data.id;
                console.clear();
                cargarTrabajadores('tblEmpleados', id_usuario, modoTabla);
                // console.log(idEmpresaSeleccionada);
                // peticion - https://coderszine.com/live-datatables-crud-with-ajax-php-mysql/
                // var dataReq = {
                //     datos : IdProySeleccionado, 
                //     action : 'cargarTablasHijas'
                // };
                // $.ajax({
                //     url:"http://localhost/SENA-devmanager/api/ProyectoControlador.php",
                //     method:"POST",
                //     data: dataReq,
                //     dataType:"json",
                //     success:function(datos){
                //         var { dHabReq, dHabDisp, dTrabReq, dTrabDisp } = datos.data;
                //         console.log(datos);
                //         cargarHabilidades('tblHab_Requeridas', dHabReq, modoTabla);
                //         cargarHabilidades('tblHab_Disponibles', dHabDisp, modoTabla);
                //         cargarTrabajadores('tblContratados', dTrabReq, modoTabla);
                //         cargarTrabajadores('tblCandidatos', dTrabDisp, modoTabla);
                //     }
                // });

                // fetch('http://localhost/SENA-devmanager/api/ProyectoControlador.php?id=' + IdProySeleccionado, {
                //     method: 'GET',
                // }).then((resp) => {
                //     return resp.json();
                // }).then((json) => {
                //     const {
                //         dHabReq,
                //         dHabDisp,
                //         dTrabReq,
                //         dTrabDisp
                //     } = json;
                //         cargarHabilidades('tblHab_Requeridas', dHabReq, modoTabla);
                //         cargarHabilidades('tblHab_Disponibles', dHabDisp, modoTabla);
                //         cargarTrabajadores('tblContratados', dTrabReq, modoTabla);
                //         cargarTrabajadores('tblCandidatos', dTrabDisp, modoTabla);
                // });
            }
        });

        $('#addRowtblEmpresas').click(function() {
            if($('#tblEmpleados').length) {$('#tblEmpleados').DataTable().clear().draw();}
        });

    });
</script>