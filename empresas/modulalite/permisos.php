<?php
//Funciones disponibles para la entidad clientes
$entorno="
facturacion/Facturacion|
	acceso:Acceso al modulo,
	guardar:Guardar registros,
	eliminar:Eliminar registros,
	consultar:Consultar registros,
	modificarprecio:Modificar el precio de los conceptos,
	modificar:Modificar registros,
	descargar:Permitir la descarga de los comprobantes,
	papelera:Acceso a la papelera de registros
@cursos/Cursos|
	acceso:Acceso al modulo,
	guardar:Guardar nuevos registros,
	eliminar:Eliminar registros,
	consultar:Consultar registros,
	modificar:Modificar registros	
@email/Email|
	acceso:Acceso al modulo de correo electronico,
	guardar:Permitir el envio de correo electronico
@plantillasmensajes/Plantillas de mensajes|
	acceso:Acceso al modulo,
	guardar:Crear nuevas plantillas para mensajes de correo,
	eliminar:Eliminar plantillas,
	consultar:Consultar plantillas guardadas,
	modificar:Modificar plantillas existentes
@bitacoragerencial/Bitacoragerencial|
	acceso:Acceso al modulo,
	guardar:Guardar nuevos registros,
	eliminar:Eliminar registros,
	consultar:Consultar registros,
	modificar:Modificar registros,
	papelera:Acceso a la papelera de registros
@cortesdecaja/Cortesdecaja|
	acceso:Acceso al modulo,
	guardar:Guardar nuevos registros,
	eliminar:Eliminar registros,
	consultar:Consultar registros,
	modificar:Modificar registros,
	papelera:Acceso a la papelera de registros
@devoluciones/Devoluciones|
	acceso:Acceso al modulo,
	guardar:Guardar nuevos registros,
	eliminar:Eliminar registros,
	consultar:Consultar registros,
	modificar:Modificar registros
@liquidaciones/Liquidaciones|
	acceso:Acceso al modulo,
	guardar:Guardar nuevos registros,
	eliminar:Eliminar registros,
	consultar:Consultar registros,
	modificar:Modificar registros
@asignacionvehicular/Asignacionvehicular|
	acceso:Acceso al modulo,
	guardar:Guardar nuevos registros,
	eliminar:Eliminar registros,
	consultar:Consultar registros,
	modificar:Modificar registros
@rutas/Rutas|
	acceso:Acceso al modulo,
	guardar:Guardar nuevos registros,
	eliminar:Eliminar registros,
	consultar:Consultar registros,
	modificar:Modificar registros,
	papelera:Acceso a la papelera de registros
@cuentasporpagar/Cuentasporpagar|
	acceso:Acceso al modulo,
	guardar:Guardar nuevos registros,
	eliminar:Eliminar registros,
	consultar:Consultar registros,
	modificar:Modificar registros,
	papelera:Acceso a la papelera de registros
@retiros/Retiros|
	acceso:Acceso al modulo,
	guardar:Guardar nuevos registros,
	eliminar:Eliminar registros,
	consultar:Consultar registros,
	modificar:Modificar registros,
	papelera:Acceso a la papelera de registros
@gastos/Gastos|
	acceso:Acceso al modulo,
	guardar:Guardar nuevos registros,
	eliminar:Eliminar registros,
	consultar:Consultar registros,
	modificar:Modificar registros,
	papelera:Acceso a la papelera de registros
@bitacoravehicular/Bitacoravehicular|
	acceso:Acceso al modulo,
	guardar:Guardar nuevos registros,
	eliminar:Eliminar registros,
	consultar:Consultar registros,
	modificar:Modificar registros,
	papelera:Acceso a la papelera de registros
@vehiculos/Vehiculos|
	acceso:Acceso al modulo,
	guardar:Guardar nuevos registros,
	eliminar:Eliminar registros,
	consultar:Consultar registros,
	modificar:Modificar registros,
	papelera:Acceso a la papelera de registros
@inventario/Inventario|
	acceso:Acceso al modulo,
	guardar:Guardar registros,
	eliminar:Eliminar registros,
	papelera:Tener acceso a la papelera de datos eliminados,
	consultar:Consultar registros,
	consultarkardex:Consultar historiral de kardex,
	resetear:Resetear Inventario (Establece existencias en cero),
	reparar:Permitir reparaciones de existencias,
	consultarrastreador:Permitir consultar el rastreador de productos,
	cambiarubicacion:Modificar stock y ubicaciones,
	modificar:Modificar inventario
@cuentasporcobrar/Cuentasporcobrar|
	acceso:Acceso al modulo,
	guardar:Guardar nuevos registros,
	eliminar:Eliminar registros,
	consultar:Consultar registros,
	modificar:Modificar registros,
	papelera:Acceso a la papelera de registros
@pagos/Pagos|
	acceso:Acceso al modulo,
	guardar:Guardar nuevos registros,
	eliminar:Eliminar registros,
	consultar:Consultar registros,
	modificar:Modificar registros,
	registrarPago:Registrar pagos,
	cambiarEstatus:Cambiar estatus de pago,
	papelera:Acceso a la papelera de registros
@movimientos/Movimientos de almacen|
	acceso:Acceso al modulo,
	guardar:Guardar registros,
	nuevaentrada:Registrar entradas de mercancia,
	nuevasalida:Registrar salidas de mercancia,
	eliminar:Eliminar registros,
	consultar:Consultar registros,
	modificar:Modificar registros,
	papelera:Acceso a la papelera de registros
@requisiciones/Requisiciones|
	acceso:Acceso al modulo,
	guardar:Guardar nuevos registros,
	eliminar:Eliminar registros,
	consultar:Consultar registros,
	modificar:Modificar registros
@ordenescompras/Ordenes de compra|
	acceso:Acceso al modulo,
	guardar:Guardar nuevos registros,
	eliminar:Eliminar registros,
	consultar:Consultar registros,
	modificar:Modificar registros
@compras/Ordenes de compra|
	acceso:Acceso al modulo,
	guardar:Guardar nuevos registros,
	eliminar:Eliminar registros,
	consultar:Consultar registros,
	modificar:Modificar registros
@cotizacionesproductos/Cotizacionesproductos|
	acceso:Acceso al modulo,
	guardar:Guardar nuevos registros,
	eliminar:Eliminar registros,
	consultar:Consultar registros,
	modificar:Modificar registros,
	papelera:Acceso a la papelera de registros
@giroscomerciales/Giroscomerciales|
	acceso:Acceso al modulo,
	guardar:Guardar nuevos registros,
	eliminar:Eliminar registros,
	consultar:Consultar registros,
	modificar:Modificar registros,
	papelera:Acceso a la papelera de registros
@detallecotizacionesproductos/Detallecotizacionesproductos|
	acceso:Acceso al modulo,
	guardar:Guardar nuevos registros,
	eliminar:Eliminar registros,
	consultar:Consultar registros,
	modificar:Modificar registros
@cotizacionesotros/Cotizacionesotros|
	acceso:Acceso al modulo,
	guardar:Guardar nuevos registros,
	eliminar:Eliminar registros,
	consultar:Consultar registros,
	modificar:Modificar registros,
	papelera:Acceso a la papelera de registros
@detallecotizacionesotros/Detallecotizacionesotros|
	acceso:Acceso al modulo,
	guardar:Guardar nuevos registros,
	eliminar:Eliminar registros,
	consultar:Consultar registros,
	modificar:Modificar registros,
	papelera:Acceso a la papelera de registros
@folios/Folios|
	acceso:Acceso al modulo,
	guardar:Guardar nuevos registros,
	eliminar:Eliminar registros,
	consultar:Consultar registros,
	modificar:Modificar registros,
	papelera:Acceso a la papelera de registros
@productos/Productos|
	acceso:Acceso al modulo,
	guardar:Guardar nuevos registros,
	eliminar:Eliminar registros,
	consultar:Consultar registros,
	modificar:Modificar registros,
	papelera:Acceso a la papelera de registros
@domicilios/Domicilios|
	acceso:Acceso al modulo,
	guardar:Guardar nuevos registros,
	eliminar:Eliminar registros,
	consultar:Consultar registros,
	modificar:Modificar registros,
	papelera:Acceso a la papelera de registros
@familias/Familias|
	acceso:Acceso al modulo,
	guardar:Guardar nuevos registros,
	eliminar:Eliminar registros,
	consultar:Consultar registros,
	modificar:Modificar registros,
	papelera:Acceso a la papelera de registros
@perfiles/Perfiles|
	acceso:Acceso al modulo,
	guardar:Guardar registros,
	eliminar:Eliminar registros,
	consultar:Consultar registros,
	cancelar:Cancelar apartados,
	modificar:Modificar registros
@usuarios/Usuarios|
	acceso:Acceso al modulo de usuarios,
	guardar:Permitir crear nuevos usuarios,
	eliminar:Permitir eliminar usuarios,
	consultar:Consultar lista de usuarios,
	modificar:Permitir modificar los datos de los usuarios,
	bloquear:Permitir bloquear usuarios,
	email:Permitir enviar correos electrónicos
@zonas/Zonas|
	acceso:Acceso al modulo,
	guardar:Guardar nuevos registros,
	eliminar:Eliminar registros,
	consultar:Consultar registros,
	modificar:Modificar registros,
	papelera:Acceso a la papelera de registros
@mediospublicitarios/Mediospublicitarios|
	acceso:Acceso al modulo,
	guardar:Guardar nuevos registros,
	eliminar:Eliminar registros,
	consultar:Consultar registros,
	modificar:Modificar registros,
	papelera:Acceso a la papelera de registros
@estados/Estados|
	acceso:Acceso al modulo,
	guardar:Guardar nuevos registros,
	eliminar:Eliminar registros,
	consultar:Consultar registros,
	modificar:Modificar registros
@ciudades/Ciudades|
	acceso:Acceso al modulo,
	guardar:Guardar nuevos registros,
	eliminar:Eliminar registros,
	consultar:Consultar registros,
	modificar:Modificar registros
@sucursales/Sucursales|
	acceso:Acceso al modulo,
	guardar:Guardar nuevos registros,
	eliminar:Eliminar registros,
	consultar:Consultar registros,
	modificar:Modificar registros,
	papelera:Acceso a la papelera de registros,
	cambiar:Permitir al usuario cambiar de sucursal
@cuentascorreo/Cuentascorreo|
	acceso:Acceso al modulo,
	guardar:Guardar nuevos registros,
	eliminar:Eliminar registros,
	consultar:Consultar registros,
	modificar:Modificar registros,
	papelera:Acceso a la papelera de registros
@empleados/Empleados|
	acceso:Acceso al modulo,
	guardar:Guardar nuevos registros,
	eliminar:Eliminar registros,
	consultar:Consultar registros,
	modificar:Modificar registros,
	papelera:Acceso a la papelera de registros
@archivos/Archivos|
	acceso:Acceso al modulo,
	guardar:Guardar nuevos registros,
	eliminar:Eliminar registros,
	consultar:Consultar registros,
	modificar:Modificar registros
@proveedores/Proveedores|
	acceso:Acceso al modulo,
	guardar:Guardar nuevos registros,
	eliminar:Eliminar registros,
	consultar:Consultar registros,
	modificar:Modificar registros,
	papelera:Acceso a la papelera de registros
@cuentasbancarias/Cuentasbancarias|
	acceso:Acceso al modulo,
	guardar:Guardar nuevos registros,
	eliminar:Eliminar registros,
	consultar:Consultar registros,
	modificar:Modificar registros,
	papelera:Acceso a la papelera de registros
@cuentasprincipales/Cuentasprincipales|
	acceso:Acceso al modulo,
	guardar:Guardar nuevos registros,
	eliminar:Eliminar registros,
	consultar:Consultar registros,
	modificar:Modificar registros,
	papelera:Acceso a la papelera de registros
@cuentassecundarias/Cuentassecundarias|
	acceso:Acceso al modulo,
	guardar:Guardar nuevos registros,
	eliminar:Eliminar registros,
	consultar:Consultar registros,
	modificar:Modificar registros,
	papelera:Acceso a la papelera de registros
@empresa/Empresa|
	acceso:Acceso al modulo,
	guardar:Guardar nuevos registros,
	eliminar:Eliminar registros,
	consultar:Consultar registros,
	modificar:Modificar registros,
	papelera:Acceso a la papelera de registros
@clientes/Clientes|
	acceso:Acceso al modulo,
	guardar:Guardar nuevos registros,
	eliminar:Eliminar registros,
	consultar:Consultar registros,
	modificar:Modificar registros,
	papelera:Acceso a la papelera de registros
@prospectos/Prospectos|
	acceso:Acceso al modulo,
	guardar:Guardar nuevos registros,
	eliminar:Eliminar registros,
	consultar:Consultar registros,
	modificar:Modificar registros,
	papelera:Acceso a la papelera de registros
@cotizador/Cotizador|
	acceso:Acceso al modulo
@datosfiscales/Datosfiscales|
	acceso:Acceso al modulo,
	guardar:Guardar nuevos registros,
	eliminar:Eliminar registros,
	consultar:Consultar registros,
	modificar:Modificar registros,
	papelera:Acceso a la papelera de registros
@unidades/Unidades de medida|
	acceso:Acceso al modulo,
	guardar:Guardar nuevos registros,
	eliminar:Eliminar registros,
	consultar:Consultar registros,
	modificar:Modificar registros,
	papelera:Acceso a la papelera de registros
@categorias/Categorias|
	acceso:Acceso al modulo,
	guardar:Guardar nuevos registros,
	eliminar:Eliminar registros,
	consultar:Consultar registros,
	modificar:Modificar registros,
	papelera:Acceso a la papelera de registros
@listasprecios/Listasprecios|
	acceso:Acceso al modulo,
	guardar:Guardar nuevos registros,
	eliminar:Eliminar registros,
	consultar:Consultar registros,
	modificar:Modificar registros,
	papelera:Acceso a la papelera de registros
@contactos/Contactos|
	acceso:Acceso al modulo,
	guardar:Guardar nuevos registros,
	eliminar:Eliminar registros,
	consultar:Consultar registros,
	modificar:Modificar registros
@modelosimpuestos/Modelo de impuestos|
	acceso:Acceso al modulo,
	guardar:Registrar nuevos proveedores,
	eliminar:Eliminar registros,
	consultar:Consultar registros,
	modificar:Modificar registros,
	papelera:Acceso a la papelera de registros
@stocks/Stocks|
	acceso:Acceso al modulo,
	guardar:Guardar nuevos registros,
	eliminar:Eliminar registros,
	consultar:Consultar registros,
	modificar:Modificar registros
@marcas/Marcas|
	acceso:Acceso al modulo,
	guardar:Guardar nuevos registros,
	eliminar:Eliminar registros,
	consultar:Consultar registros,
	modificar:Modificar registros,
	papelera:Acceso a la papelera de registros
@caracteristicas/Caracteristicas|
	acceso:Acceso al modulo,
	guardar:Guardar nuevos registros,
	eliminar:Eliminar registros,
	consultar:Consultar registros,
	modificar:Modificar registros
@traspasos/Traspasos|
	acceso:Acceso al modulo,
	guardar:Guardar nuevos registros,
	eliminar:Eliminar registros,
	consultar:Consultar registros,
	modificar:Modificar registros
@auditorias/Auditorias|
	acceso:Acceso al modulo,
	guardar:Guardar nuevos registros,
	eliminar:Eliminar registros,
	consultar:Consultar registros,
	modificar:Modificar registros
";


$entorno= str_replace("\r","",$entorno);
$entorno= str_replace("\t","",$entorno);
$entorno= str_replace("\n","",$entorno);
?>