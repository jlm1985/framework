<?php
/**
 * @package Componentes
 * @subpackage Negocio
 */
class toba_servicio_web extends toba_componente
{

	final function __construct($id)
	{
		parent::__construct($id);
		// Cargo las dependencias
		foreach( $this->_lista_dependencias as $dep){
			$this->cargar_dependencia($dep);
			$this->_dependencias[$dep]->set_controlador($this, $dep);
			$this->dep($dep)->inicializar();
		}		
	}
	

	/**
	 * Ventana de extensi�n que se ejecuta al iniciar el componente en todos los pedidos en los que participa.
	 * @ventana
	 */
	function ini()
	{
	}	


}
?>