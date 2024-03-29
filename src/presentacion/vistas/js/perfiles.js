import { cargarTablaGenerica } from "../../../librerias/tablaGenerica.js";

var dataUrl = 'http://localhost/SENA-devmanager/src/api/PerfilControlador.php';

function cargarPerfiles(nombreTabla, idUsuario, modoTabla='R') {
   
    var colsPerfiles = [
          { data: null,render: function () {return "<input type='checkbox'/>";},visible: true,},
          { title: "Id", data: "id", name: 'id', visible: false },
          { title: "Identificacion", data: "identificacion", name: 'identificacion', visible: true },
          { title: "Tipo Ident.",data: "tipo_identificacion", name:'tipo_identificacion', className : 'ddl' },
          { title: "Nombres", data: "nombres",name: "nombres", visible: true },
          { title: "Apellidos", data: "apellidos",name: "apellidos", visible: true },
          { title: "Correo", data: "correo", name: "correo", visible: true },
          { title: "Clave", data: "clave_hash", name: "clave_hash", visible: false },
          { title: "Dirección", data: "direccion",name: "direccion", visible: true },
          { title: "Foto", data: "nombre_foto", name: "nombre_foto", className: 'up_img', visible: true },
          { title: "Telefono", data: "telefono", name: "telefono", visible: true },
          { title: "Tipo de Usuario", data: "tipo_usuario", name: "tipo_usuario", className : 'ddl', visible: true },
          { title: "Empresa", data: "id_empresa", name: "id_empresa", className : 'ddl',  visible: true }
    ];

    // configuración de carga inicial
    // $('#campoDescripcion').hide();
    $('#botonesGuardarCambios').hide();
    $('#botonesGuardarCambios').attr("disabled", "disabled");

    var payloadPerfil = {
        datos : idUsuario,
        action : 'cargar_'+nombreTabla,
        html_tabla : nombreTabla
    }

    //console.log("Perf", arreglo);
    cargarTablaGenerica(nombreTabla, colsPerfiles, modoTabla, dataUrl, payloadPerfil); //para que no se puedan borrar, solo admin desde Administracion

    $('#btn-cancel-'+nombreTabla).click(function() {
        $('#fsEstudios').prop("disabled", false);
        $('#fsHabilidades').prop("disabled", false);
    });
}

function cargarEstudios(nombreTabla, IdPerfilSeleccionado, tipoUsuario, modoTabla='R'){
    var colsEstudios = [
        { data:null, render:function(){return "<input type='checkbox'/>";}, visible: true },
        { title: "Id", data: "id", name: 'id', visible: false },
        { title: 'Nombre Estudio', data: 'id_estudio', name: 'id_estudio', type: 'select', className : 'ddl', visible: true},
        { title: 'Nombre Certificado', data: 'nombre_certificado', name: 'nombre_certificado', visible: true },
        { title: 'Nombre Archivo', data: 'nombre_archivo', name:'nombre_archivo', className: 'up_doc', visible: true },
        { title: 'Fecha Certificado', data: 'fecha_certificado', name: 'fecha_certificado', className: 'datepicker', visible: true },
        { title: 'Id usuario', data: 'id_usuario', name: 'id_usuario', visible: false},
    ];

    var payloadEstudios = {
        id_usuario : IdPerfilSeleccionado,
        datos : IdPerfilSeleccionado ,
        action : 'cargar_'+nombreTabla,
        html_tabla : nombreTabla
    }
    if($('#'+nombreTabla).lenght) $('#'+nombreTabla).DataTable().clear().draw();

    switch (tipoUsuario) {
        case "A":
        case "D":
            modoTabla = 'R';
            break;
        default:
            modoTabla = 'CRUD';
            break;
    }                 

    cargarTablaGenerica(nombreTabla, colsEstudios, modoTabla, dataUrl, payloadEstudios);
}

function cargarHabilidades(nombreTabla, IdPerfilSeleccionado, tipo_usuario,  modoTabla='R'){
    var colsHabilidades = [
        { data:null, render:function(){return "<input type='checkbox'/>";}, visible: true },
        { title: 'Nombre Habilidad', data: 'id_habilidad', name: 'id_habilidad', className : 'ddl' ,visible: true},
        { title: 'Nombre Habilidad', data: 'nombre', name: 'nombre' , visible: false },
        { title: 'Descripcion', data: 'descripcion', name: 'descripcion', visible: true },
        { title: 'Experiencia', data: 'experiencia', name: 'experiencia', visible: true },
        { title: 'Id usuario', data: 'id_usuario', name: 'id_usuario',visible: false},
    ];

    var payloadHabilidades = {
        id_usuario : IdPerfilSeleccionado,
        datos : IdPerfilSeleccionado,
        action : 'cargar_'+nombreTabla,
        html_tabla : nombreTabla
    }

    if($('#'+nombreTabla).lenght) $('#'+nombreTabla).DataTable().clear().draw();
    
    switch (tipo_usuario) {
        case "A":
        case "D":
            modoTabla = 'R';
            break;
        default:
            modoTabla = 'CRUD';
            break;
    } 
    cargarTablaGenerica(nombreTabla, colsHabilidades, modoTabla, dataUrl, payloadHabilidades);
}

export { cargarPerfiles, cargarEstudios, cargarHabilidades }