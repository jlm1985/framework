<?php

/**
 * La fuente de datos encapsula un mecanismo de entrada/salida de datos, típicamente una base relacional
 * Esta clase contiene ventanas antes y despues de la conexión de la fuente y permite acceder al objeto db 
 * que es el que tiene el API de consultas/comandos
 * 
 * @package Fuentes
 */
class toba_fuente_datos
{
	protected $definicion;
	protected $db;
	
	function __construct($definicion)
	{
		$this->definicion = $definicion;
	}
	
	/**
	 * Accede al objeto db que tiene el API para consultas/comandos sobre la fuente
	 * @return toba_db
	 */
	function get_db($reusar = true)
	{
		if ($reusar) {
			if (!isset($this->db)) {
				$this->pre_conectar();
				$this->db = toba_dba::get_db_de_fuente(toba::instancia()->get_id(),
															$this->definicion['proyecto'],
															$this->definicion['fuente_datos'],
															$reusar);
				$this->crear_usuario_para_auditoria($this->db);
				$this->post_conectar();
				if (isset($this->definicion['schema'])) {
					$this->db->set_schema($this->definicion['schema']);
				}
				$this->configurar_parseo_errores($this->db);
			}
			return $this->db;
		} else {
			//-- Se pide una conexión aislada, que no la reutilize ninguna otra parte de la aplicación
			// Esta el codigo anterior repetido porque si se unifica, el post_conectar asume la presencia de $this->db y no habria forma de pedir una conexion aislada
			$db = toba_dba::get_db_de_fuente(toba::instancia()->get_id(),
															$this->definicion['proyecto'],
															$this->definicion['fuente_datos'],
															$reusar);
			$this->crear_usuario_para_auditoria($db);
			if (isset($this->definicion['schema'])) {
				$db->set_schema($this->definicion['schema']);
			}
			$this->configurar_parseo_errores($db);
			return $db;												
		}
	}
	
	/**
	 * Dado el nombre de una tabla de la fuente, retorna el id de su datos_tabla asociado
	 * @param string $tabla
	 * @return int
	 */
	function get_id_datos_tabla($tabla)
	{
		if (! isset($this->definicion['mapeo_tablas_dt'])) {
			//-- Lazyload de la relacion entre tabla y dt por un tema de eficiencia
			$this->definicion['mapeo_tablas_dt'] = toba_proyecto_db::get_mapeo_tabla_dt($this->definicion['proyecto'], $this->definicion['fuente_datos']);
		}
		if (isset($this->definicion['mapeo_tablas_dt'][$tabla])) {
			return $this->definicion['mapeo_tablas_dt'][$tabla];
		} else {
			throw new toba_error("No se encuentra el datos_tabla asociado a la tabla $tabla en la fuente {$this->definicion['fuente_datos']}");
		}
	}
	
	/**
	*	Ventana para personalizar las acciones previas a la conexión
	* @ventana
	*/
	function pre_conectar() {}
	
	/**
	* Ventana para personalizar las acciones posteriores a la conexión
	* @ventana
	*/
	function post_conectar() {}

	function crear_usuario_para_auditoria($db)
	{
		if ($this->definicion['tiene_auditoria'] == '1') {
			$usuario = toba::usuario()->get_id();			
			if (! isset($usuario)) {
				$usuario = 'publico';
			}
			
			$id_solicitud = $db->quote(toba::instancia()->get_id_solicitud());
			$usuario = $db->quote($usuario);
			$sql = 'CREATE TEMP TABLE tt_usuario ( usuario VARCHAR(30), id_solicitud INTEGER);';
			$sql .= "INSERT INTO tt_usuario (usuario, id_solicitud) VALUES ($usuario, $id_solicitud)";
			$db->ejecutar($sql);
		}
	}

	function configurar_parseo_errores($db)
	{
		if ($this->definicion['parsea_errores'] == '1'){
			$parseador = 'toba_parser_error_db'. $this->definicion['motor'];
			$db->set_parser_errores(new $parseador);
		}
	}
}
?>