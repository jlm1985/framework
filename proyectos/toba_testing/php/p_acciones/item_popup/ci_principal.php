<?php

class ci_principal extends objeto_ci
{
	function extender_objeto_js()
	{
	}

	function mantener_estado_sesion()
	{
		$propiedades = parent::mantener_estado_sesion();
		return $propiedades;
	}

	//-------------------------------------------------------------------
	//--- DEPENDENCIAS
	//-------------------------------------------------------------------
	function evt__cuadro__carga()
	{
		$datos = array(
			array('clave' => 1, 'valor' => 'Uno'),
			array('clave' => 2, 'valor' => 'Dos'),
			array('clave' => 3, 'valor' => 'Tres')
		);
		return $datos;	
	}

}

?>