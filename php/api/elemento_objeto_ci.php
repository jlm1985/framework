<?php
require_once('api/elemento_objeto_ei.php');
require_once('api/elemento_objeto_ci_pantalla.php');

class elemento_objeto_ci extends elemento_objeto_ei
{
	
	//---------------------------------------------------------------------	
	//-- Recorrible como ARBOL
	//---------------------------------------------------------------------

	function es_hoja()
	{
		return (count($this->hijos()) == 0);
	}	

	function hijos()
	{
		//Las dependencias son sus hijos
		//Hay una responsabilidad no bien limitada
		//Este objeto tiene las dependencias, cada pantalla deber�a poder sacar las que les concierne
		//Pero tambien este objeto deber�a saber cuales no son utilizadas por las pantallas
		$pantallas = array();
		if (isset($this->datos['apex_objeto_ci_pantalla'])) {
			//Se ordena por la columna orden
			$datos_pantallas = rs_ordenar_por_columna($this->datos['apex_objeto_ci_pantalla'],'orden');
			foreach ($datos_pantallas as $pantalla) {
				$pantallas[] = new elemento_objeto_ci_pantalla($pantalla, $this->subelementos);
			}
		}
		//Busca Dependencias libres
		$dependencias_libres = array();
		foreach ($this->subelementos as $dependencia) {
			$libre = true;
			foreach ($pantallas as $pantalla) {
				if ($pantalla->tiene_dependencia($dependencia)) {
					$libre = false;
				}
			}
			if ($libre) {
				$dependencias_libres[] = $dependencia;
			}
		}
		return array_merge($pantallas, $dependencias_libres);
	}	

	function utilerias()
	{
		$iconos = array();
		$iconos[] = array(
			'imagen' => recurso::imagen_apl("objetos/objeto_nuevo.gif", false),
			'ayuda' => "Crear un objeto asociado al controlador",
			'vinculo' => toba::get_vinculador()->generar_solicitud("toba","/admin/objetos_toba/crear",
								array(	'destino_tipo' => 'ci', 
										'destino_proyecto' => $this->proyecto,
										'destino_id' => $this->id),
										false, false, null, true, "central")
		);
		return array_merge($iconos, parent::utilerias());	
	}		

	//---------------------------------------------------------------------	
	//-- EVENTOS
	//---------------------------------------------------------------------

	function eventos_predefinidos()
	{
		$eventos = parent::eventos_predefinidos();	
		/*	Hay que agregar entradas y salidas de pantallas */
		return $eventos;
	}

	static function get_modelos_evento()
	{
		$modelo[0]['id'] = 'proceso';
		$modelo[0]['nombre'] = 'Proceso';
		return $modelo;
	}

	static function get_lista_eventos_estandar($modelo)
	{
		$evento = array();
		switch($modelo){
			case 'proceso':
				$evento[0]['identificador'] = "procesar";
				$evento[0]['etiqueta'] = "Proce&sar";
				$evento[0]['orden'] = 0;
				$evento[0]['en_botonera'] = 1;
				$evento[1]['identificador'] = "cancelar";
				$evento[1]['etiqueta'] = "&Cancelar";
				$evento[1]['maneja_datos'] = 0;
				$evento[1]['orden'] = 1;
				$evento[1]['en_botonera'] = 1;
				break;
		}
		return $evento;
	}
	
	//---------------------------------------------------------------------	
	//-- METACLASE
	//---------------------------------------------------------------------

	function generar_cuerpo_clase($opciones)
	{
		$cuerpo = parent::generar_cuerpo_clase($opciones);
		if ($opciones['eventos']) {
			//Eventos de la clase
			$cuerpo .= clase_php::separador_seccion_chica('Eventos CI');
			foreach ($this->eventos_predefinidos() as $evento => $info) {
				$cuerpo .= clase_php::generar_metodo('evt__' . $evento);
			}
			//Eventos de las dependencias
			if(count($this->subelementos)>0){
				$cuerpo .= clase_php::separador_seccion_grande('DEPENDENCIAS');
				foreach ($this->subelementos as $elemento) {
					//ATENCION: Hay que controlar que no sea CI!
					$rol = $elemento->rol_en_consumidor();
					$cuerpo .= clase_php::separador_seccion_chica($rol);
					//Eventos predefinidos del elemento
					foreach($elemento->eventos_predefinidos() as $evento => $info){
						$cuerpo .= clase_php::generar_metodo('evt__' . $rol . '__' .$evento, $info['parametros']);
					}
					//Metodo de CARGA!
					$comentario_carga = $elemento->get_comentario_carga();
					$cuerpo .= clase_php::generar_metodo('evt__' . $rol . '__carga', null, null, $comentario_carga);
				}
			}
		}
		return $cuerpo;
	}

	function generar_metodos()
	{
		$metodos = parent::generar_metodos();
		$metodos[] = "\t".
'function mantener_estado_sesion()
	!#c2//Declarar todas aquellas propiedades de la clase que se desean persistir autom�ticamente
	!#c2//entre los distintos pedidos de p�gina en forma de variables de sesi�n.
	{
		$propiedades = parent::mantener_estado_sesion();
		!#c1//$propiedades[] = \'propiedad_a_persistir\';
		return $propiedades;
	}
';
		return $this->filtrar_comentarios($metodos);
	}
}
?>