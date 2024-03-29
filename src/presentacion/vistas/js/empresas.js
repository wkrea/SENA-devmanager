import { cargarTablaGenerica } from "../../../librerias/tablaGenerica.js";

var dataUrl = 'http://localhost/SENA-devmanager/src/api/EmpresaControlador.php';//hay que configurar algun tipo de variable para que la url sirva si el proyecto cambia de nombre o de server

function cargarEmpresas(nombreTabla, idUsuario, modoTabla = 'R') {

    var colsEmpresas = [
        {   data:null, render:function(){return "<input type='checkbox'/>";}, visible: true },
        {   title: 'id', data: 'id', name: 'id',  visible: false },
        {   title: 'Nit', data: 'nit',name: 'nit' ,visible: true},
        {   title: 'Nombre', data: 'nombre',name: 'nombre' ,visible: true },
        {   title: 'Direccion', data: 'direccion',name: 'direccion',visible: true},
        {   title: 'Correo', data: 'correo',name:'correo', visible: true},
        {   title: 'Telefono', data: 'telefono',name: 'telefono', visible: true},
        {   title: 'Nombre Representante', data: 'nombre_representante',name:'nombre_representante', visible: true},
        {   title: 'Correo Representante', data: 'correo_representante',name: 'correo_representante',visible: true}
    ];

    // configuración de carga inicial
    // $('#campoDescripcion').hide();
    $('#botonesGuardarCambios').hide();
    $('#botonesGuardarCambios').attr("disabled", "disabled");

    var payloadEmpresas = {
        datos : idUsuario,
        action : 'cargar_'+nombreTabla,
        html_tabla : nombreTabla
    }

    console.log(modoTabla);
    cargarTablaGenerica(nombreTabla, colsEmpresas, modoTabla, dataUrl, payloadEmpresas);

    $('#btn-cancel-'+nombreTabla).click(function() {
        $('#fsUsuarios').prop("disabled", false);
    });
}

function cargarTrabajadores(nombreTabla, id_usuario, modoTabla ='R') {

    var ddl_t_identificacion = [
        { value : 'X', key : '' },
        { value : 'P', key : 'Pendiente' },
        { value : 'E', key : 'Ejecución' },
        { value : 'T', key : 'Terminado' }
        ];

    var colsTrabajadores = [
      {data: null,render: function () {return "<input type='checkbox'/>";},visible: true,},
      { title: "Id", data: "id", name: 'id', visible: false },
      { title: "Identificacion", data: "identificacion", name: 'identificacion', visible: true },
      { title: "Tipo Ident.",data: "tipo_identificacion", name:'tipo_identificacion', type: 'select', className: "ddl" },
      { title: "Nombres", data: "nombres",name: "nombres", visible: true },
      { title: "Apellidos", data: "apellidos",name: "apellidos", visible: true },
      { title: "Correo", data: "correo", name: "correo", visible: true },
      { title: "Clave", data: "clave_hash", name: "clave_hash", visible: false },
      { title: "Dirección", data: "direccion",name: "direccion", visible: true },
      { title: "Foto", data: "nombre_foto", name: "nombre_foto", visible: true },
      { title: "Telefono", data: "telefono", name: "telefono", visible: true },
      { title: "Tipo de Usuario", data: "tipo_usuario", name: "tipo_usuario", type: 'select', className: 'ddl',  visible: true },
      { title: "Empresa", data: "id_empresa", name: "id_empresa", type: 'select', className: 'ddl' , visible: true }
    ];

    var payloadTrabajadores = {
        datos : id_usuario ,
        action : 'cargar_'+nombreTabla,
        html_tabla : nombreTabla
    }

    if($('#'+nombreTabla).lenght) $('#'+nombreTabla).DataTable().clear().draw();
    cargarTablaGenerica(nombreTabla, colsTrabajadores, modoTabla, dataUrl, payloadTrabajadores, ddl_t_identificacion);
}

export { cargarEmpresas, cargarTrabajadores }

// https://datatables.net/forums/discussion/1723/editable-with-datepicker-inside-datatables
// select everything when editing field in focus
// https://stackoverflow.com/questions/14643617/create-table-using-javascript
// https://linuxhint.com/create-table-from-array-objects-javascript/
