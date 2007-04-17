<?php
require_once(toba_dir()."/php/3ros/Graph/Graph.php");	//Necesario para el calculo de orden topologico de las tablas

class ci_relaciones extends toba_ci
{
	protected $tabla;
	protected $s__seleccion_relacion;
	protected $s__seleccion_relacion_anterior;
	private $id_intermedio_relaciones;
	private $rel_activa_padre;
	private $rel_activa_padre_claves;
	private $rel_activa_hijo;
	private $rel_activa_hijo_claves;

	function get_tabla()
	{
		if (! isset($this->tabla)) {
			$this->tabla = $this->controlador->get_tabla_relaciones();
		}
		return $this->tabla;
	}

	function mostrar_detalle_relacion()
	{
		if( isset($this->s__seleccion_relacion) ){
			return true;	
		}
		return false;
	}

	function conf()
	{
		if( $this->mostrar_detalle_relacion() ){
			$this->get_datos_relacion_activa();
			$this->pantalla()->eliminar_dep('relaciones_esquema');
			//$this->pantalla()->agregar_evento('cancelar');
			$this->dependencia('relaciones_lista')->set_fila_protegida($this->s__seleccion_relacion);			
			$this->dependencia('relaciones_lista')->seleccionar($this->s__seleccion_relacion);
		} else {
			$this->pantalla()->eliminar_dep('relaciones_columnas');
		}	
	}

	function limpiar_seleccion()
	{
		unset($this->s__seleccion_relacion);
		unset($this->s__seleccion_relacion_anterior);
	}

	function evt__cancelar()
	{
		$this->limpiar_seleccion();	
	}

	//--------------------------------------------------------------------------------------
	//---- Lista de RELACIONES
	//--------------------------------------------------------------------------------------

	function get_lista_tablas()
	{
		return $this->controlador->get_lista_tablas();
	}

	function conversion_form_a_fila($datos)
	//Adapta el contenido del form a una fila
	{
		//-- PADRE --
		$padre = explode(",",$datos['padre']);
		$datos['padre_id'] = $padre[0];
		$datos['padre_proyecto'] = toba_editor::get_proyecto_cargado();
		$datos['padre_objeto'] = $padre[1];
		unset($datos['padre']);
		//-- HIJO --
		$hijo = explode(",",$datos['hija']);
		$datos['hijo_id'] = $hijo[0];
		$datos['hijo_proyecto'] = toba_editor::get_proyecto_cargado();
		$datos['hijo_objeto'] = $hijo[1];
		unset($datos['hija']);
		return $datos;
	}
	
	function conversion_fila_a_form($fila)
	//Adapta el contenido de una fila al form
	{
		$fila['padre'] = $fila['padre_id'] . "," . $fila['padre_objeto'];
		$fila['hija'] = $fila['hijo_id'] . "," . $fila['hijo_objeto'];
		unset($fila['padre_id']);
		unset($fila['padre_objeto']);
		unset($fila['hijo_id']);
		unset($fila['hijo_objeto']);
		return $fila;
	}
	
	function evt__relaciones_lista__modificacion($registros)
	{
		$tabla = $this->get_tabla();
		foreach(array_keys($registros) as $id)
		{
			$accion = $registros[$id][apex_ei_analisis_fila];
			unset($registros[$id][apex_ei_analisis_fila]);
			switch($accion){
				case "A":
					$fila = $this->conversion_form_a_fila($registros[$id]);
					$this->id_intermedio_relaciones[$id] = $tabla->nueva_fila($fila);
					break;	
				case "B":
					$tabla->eliminar_fila($id);
					break;	
				case "M":
					$fila = $this->conversion_form_a_fila($registros[$id]);
					$tabla->modificar_fila($id, $fila);
					break;	
			}
		}
		//Se buscan ciclos
		$tablas = $this->controlador->get_entidad()->tabla('dependencias')->get_filas();
		$relaciones = $this->get_tabla()->get_filas();
		if ($this->hay_ciclos($tablas, $relaciones)) {
			$this->informar_msg("El esquema de relaciones actual contiene ciclos. ".
								"En un esquema con ciclos el mecanismo de sincronización no puede" .
								" encontrar automaticamente un orden sin violar las constraints de la BD. ".
								 " Se recomienda deshabilitar el chequeo de constraints hasta el final de la transacción."
								 , "info");
		}
		//ei_arbol($tabla->get_filas(),"FILAS");
	}
	
	function hay_ciclos($tablas, $relaciones)
	{
		$tester = new Structures_Graph_Manipulator_AcyclicTest();
		$grafo = toba_datos_relacion::grafo_relaciones($tablas, $relaciones);
		return ! $tester->isAcyclic($grafo);
	}	
	
	function conf__relaciones_lista()
	{	
		if($datos_tabla = $this->get_tabla()->get_filas() )
		{
			for($a=0;$a<count($datos_tabla);$a++){
				//Planifico el ORDEN
				$orden[] = $datos_tabla[$a]['orden'];
				//ADAPTO los datos al FORM
				$datos_tabla[$a] = $this->conversion_fila_a_form($datos_tabla[$a]);
			}
			array_multisort($orden, SORT_ASC , $datos_tabla);
			// EL formulario_ml necesita necesita que el ID sea la clave del array
			// No se solicita asi del DBR porque array_multisort no conserva claves numericas
			// y las claves internas del DBR lo son
			for($a=0;$a<count($datos_tabla);$a++){
				$id_interno = $datos_tabla[$a][apex_datos_clave_fila];
				unset( $datos_tabla[$a][apex_db_registros_clave] );
				$datos[ $id_interno ] = $datos_tabla[$a];
			}
			//ei_arbol($datos,"Datos para el ML: POST proceso");
			return $datos;
		}
	}

	function evt__relaciones_lista__seleccion($id)
	{
		if(isset($this->id_intermedio_relaciones[$id])){
			$id = $this->id_intermedio_relaciones[$id];
		}
		$this->s__seleccion_relacion = $id;
	}
	
	//-------------------------------------------------------------------------------------
	//---- DETALLE de la RELACION
	//-------------------------------------------------------------------------------------

	function get_datos_relacion_activa()
	{
		$relacion_activa = $this->get_tabla()->get_fila($this->s__seleccion_relacion);
		$this->rel_activa_padre = $relacion_activa['padre_objeto'];
		if(isset( $relacion_activa['padre_clave'] )){
			$this->rel_activa_padre_claves = explode(",",$relacion_activa['padre_clave']);			
		}
		$this->rel_activa_hijo = $relacion_activa['hijo_objeto'];
		if(isset( $relacion_activa['hijo_clave'] )){
			$this->rel_activa_hijo_claves = explode(",",$relacion_activa['hijo_clave']);
		}
	}

	function get_columnas_padre()
	{
		return toba_info_editores::get_lista_dt_columnas( $this->rel_activa_padre );
	}
	
	function get_columnas_hija()
	{
		return toba_info_editores::get_lista_dt_columnas( $this->rel_activa_hijo );
	}

	function evt__relaciones_columnas__modificacion($datos)
	{
		$padre_clave = array();
		$hijo_clave = array();
		for($a=0;$a<count($datos);$a++){
			$padre_clave[] = $datos[$a]['columnas_padre'];
			$hijo_clave[] = $datos[$a]['columnas_hija'];
		}
		if(count($padre_clave) != count($hijo_clave) ){
			throw new toba_error_def("La cantidad de claves tiene que ser simetrica");
		}
		$fila['padre_clave'] = implode(",",$padre_clave);
		$fila['hijo_clave'] = implode(",",$hijo_clave);
		$this->get_tabla()->modificar_fila($this->s__seleccion_relacion_anterior, $fila);
	}
	
	function evt__relaciones_columnas__aceptar($datos)
	{
		$this->evt__relaciones_columnas__modificacion($datos);
		$this->evt__relaciones_columnas__cancelar();
	}
	
	function evt__relaciones_columnas__cancelar()
	{
		$this->limpiar_seleccion();
	}
	
	function conf__relaciones_columnas()
	{
		$datos = array();
		$this->s__seleccion_relacion_anterior = $this->s__seleccion_relacion;
		for($a=0;$a<count($this->rel_activa_hijo_claves);$a++) {
			if ($this->rel_activa_padre_claves[$a] != '') {
				$datos[$a]['columnas_padre'] = $this->rel_activa_padre_claves[$a];
			}
			if ($this->rel_activa_hijo_claves[$a] != '') {
				$datos[$a]['columnas_hija'] = $this->rel_activa_hijo_claves[$a];
			}
		}
		return $datos;
	}

	//-------------------------------------------------------------------------------------
	//---- ESQUEMA de la RELACION
	//-------------------------------------------------------------------------------------
	
	function conf__relaciones_esquema()
	{
		$tablas = $this->controlador->get_entidad()->tabla('dependencias')->get_filas();
		$relaciones = $this->get_tabla()->get_filas();
		$grafo = toba_datos_relacion::grafo_relaciones($tablas, $relaciones);
		$diagrama = "digraph G { \n";
		$diagrama .= "size=\"7,7\";\n";		
		$diagrama .= "node [shape=record];\n";
		foreach ($grafo->getNodes() as $nodo) {
			$datos = $nodo->getData();
			$diagrama .=  $datos['identificador']."\n";	
			foreach ($nodo->getNeighbours() as $nodo_vecino) {
				$datos_vecino = $nodo_vecino->getData();
				$diagrama .= $datos['identificador'] . " -> " . $datos_vecino['identificador'] . "\n";
			}
		}
		$diagrama .= "}";
		return $diagrama;
	}
}
?>