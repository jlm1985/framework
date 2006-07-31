<?php
require_once("nucleo/negocio/objeto_cn_ent.php");	//Ancestro de todos los OE
/*
	Coordina la ABM de entidades, con logica de SELECCION y EDICION
	Maneja el flujo de lo que pasa
	
*/
class objeto_cn_ent_se extends objeto_cn_ent
{
	protected $etapa;

	function __construct($id, $resetear=false)
	{
		parent::__construct($id, $resetear);
	}

	function mantener_estado_sesion()
	{
		$estado = parent::mantener_estado_sesion();
		$estado[] = "etapa";
		return $estado;
	}

	function get_etapa_activa()
	{
		if( $this->existe_entidad_cargada() )
		{
			//echo "CARGADA";
			return 2;
		}elseif( $this->etapa == "ALTA")
		{
			//echo "ALTA";
			return 2;
		}else		
		{
			return 1;
		}
	}

	function get_opciones()
	{
		if( $this->existe_entidad_cargada() )
		{
			$opciones[0]['etiqueta'] = "Eliminar";
			$opciones[0]['metodo'] = "procesar";
			$opciones[0]['metodo_param'] = "eliminar";
			$opciones[1]['etiqueta'] = "Modificar";
			$opciones[1]['metodo'] = "procesar";
			$opciones[2]['etiqueta'] = "Cancelar";
			$opciones[2]['metodo'] = "cancelar";
			$opciones[2]['rol'] = "cancelar";
		}
		elseif( $this->etapa == "ALTA")
		{
			$opciones[0]['etiqueta'] = "Procesar";
			$opciones[0]['metodo'] = "procesar";
			$opciones[2]['etiqueta'] = "Cancelar";
			$opciones[2]['metodo'] = "cancelar";
			$opciones[2]['rol'] = "cancelar";
		}
		else		
		{
			$opciones[0]['etiqueta'] = "Agregar nuevo";
			$opciones[0]['metodo'] = "agregar_entidad";
		}
		return $opciones;
	}
	
	function agregar_entidad()
	{
		$this->etapa = "ALTA";
	}

	function eliminar_entidad()
	{
		$this->etapa = null;		
	}
	
	function cancelar()
	{
		$this->etapa = null;
		$this->descargar();
	}

	function cargar($id)
	{
		$this->entidad_id = $id;
		$this->entidad->cargar($id);
		$this->etapa = null;
	}
	
	function procesar_especifico($parametros=null)
	{
		if($parametros=="eliminar"){
			$this->entidad->eliminar();
		}else{
			$this->entidad->sincronizar_db();
		}
		$this->etapa = null;
		$this->descargar();
	}

}
?>