<?
################################################################################
############################> PUNTO de ACCESO <#################################
################################################################################
#-------------------------------------------------------------------------------
#----<  ESQUEMA de VALIDACION  >------------------------------------------------
#-------------------------------------------------------------------------------
# Tipo de validacion. Atencion, si se desactiva hay que establecer un usuario anonimo
define("apex_pa_validacion",1);//Se solicita que los usuarios se logueen?
# Usuario anonimo. Si no se desee permitir accesos anonimos, dejar vacio ("")
define("apex_pa_usuario_anonimo","");//Escribir el nombre de un usuario existente en la base
# Intentos fallidos de gravedad > 1 antes de bloquear IP
define("apex_pa_validacion_intentos",10);
# Margen de TIEMPO en el que se bloquea la IP si se supera la cantidad de intentos
define("apex_pa_validacion_ventana_intentos",30);
# Titulo de la ventana de LOGIN
define("apex_pa_validacion_titulo","Autentificacion de Usuarios");
# Simplificacion del logueo para la etapa de desarrollo
# Es util especificamente en las pruebas de grupos de acceso y perfiles de usuarios
# CUIDADO: desactivar si o si en deployment!!!!!!
define("apex_pa_validacion_debug",1);
#-------------------------------------------------------------------------------
#----<  Comunicacion SERVER-BROWSER  >-----------------------------------------------
#-------------------------------------------------------------------------------
# SSL: agregar 'https://' a los links
define("apex_pa_SSL",0);
# Tiempo maximo de no interaccion.
define("apex_pa_sesion_ventana",40);
# Tiempo maximo de duracion de la sesion.
define("apex_pa_sesion_maximo",0);
# Manejo de parametros de querystring encriptados
define("apex_pa_encriptar_qs",1);
#-------------------------------------------------------------------------------
#----<  Configuracion APEX  >-------------------------------------------------
#-------------------------------------------------------------------------------
# apex_pa_toba_alias
# Alias con el que se conoce al proyecto toba en el web server
define("apex_pa_toba_alias", "toba");
# apex_pa_ID: ID de este punto de acceso
#(Una misma sesion no deberia manejarse desde dos puntos de acceso)
define("apex_pa_ID",$_SERVER["SCRIPT_FILENAME"]);
# apex_pa_instancia: Instancia a la que el punto de acceso debe conectarse
define("apex_pa_instancia","desarrollo"); //OLMEDO1
# apex_proyecto: Proyecto PRIMARIO
define("apex_pa_proyecto","multi");  //Proyecto: 'multi' = LOGON multiproyecto
# apex_nombre: Nombre del sistema
define("apex_pa_registrar_solicitud","db");// VALORES POSIBLES: nunca, siempre, db
#---- Guarda la cronometracion de la generacion del item
define("apex_pa_registrar_cronometro","db");//VALORES POSIBLES: nunca, siempre, db
#---- FORZAR Pagina INICIAL. Atencion al SEPARADOR, la constante que lo define se procesa despues
define("apex_pa_item_inicial","toba||/basicos/marco");//Pagina inicial. 
define("apex_pa_item_inicial_contenido","toba||/inicio");//Pagina INICIAL en el contenido del FRAMESET
#---- NIVEL de ACCESO minimo permitido
define("apex_pa_nivel_acceso_item","0");//Nivel de ITEMs que se pueden solicitar
define("apex_pa_nivel_acceso_usuario","0");//Nivel de USUARIOS
# administrador
define("apex_pa_administrador","jbordon@siu.edu.ar");
# Acceso directo de OBJETOS a sus EDITORES
define("apex_pa_acceso_directo_editor",1);//Los OBJETOS muestran LINKs a sus EDITORES
#-------------------------------------------------------------------------------
#----<  LOGGER  >----------------------------------------------------------
#-------------------------------------------------------------------------------
# Indica el nivel de ERRORES que se va a registrar
# 0 - EMERG
# 1 - ALERT
# 2 - CRIT
# 3 - ERROR
# 4 - WARNING
# 5 - NOTICE
# 6 - INFO
# 7 - DEBUG
# Nivel de log a ARCHVO
define("apex_pa_log_archivo",1);
define("apex_pa_log_archivo_nivel",2);
# Nivel de log a la DB
define("apex_pa_log_db",1);
define("apex_pa_log_db_nivel",2);
# Nivel de log a la pantalla
define("apex_pa_log_pantalla",1);
define("apex_pa_log_pantalla_nivel",7);
#-------------------------------------------------------------------------------
#----<  ASPECTO  >----------------------------------------------------------
#-------------------------------------------------------------------------------
define("apex_pa_estilo","toba");
# Archivo que contiene la subclase del menu a utilizar
#define("apex_pa_menu_archivo", "");

################################################################################
if (isset($_SERVER['TOBA_DIR'])) {
	$dir = $_SERVER['TOBA_DIR']."/php"; 
	$separador = (substr(PHP_OS, 0, 3) == 'WIN') ? ";.;" : ":.:";
	ini_set("include_path", ini_get("include_path"). $separador . $dir);
}
require_once("nucleo/toba.php");
toba::get_nucleo()->acceso_web();	
################################################################################
?>
