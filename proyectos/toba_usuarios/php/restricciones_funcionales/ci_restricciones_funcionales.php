<?php 
class ci_restricciones_funcionales extends toba_ci
{
	protected $s__arbol_cargado = false;	
	protected $s__filtro;
	protected $restriccion = -1;
	
	function conf__seleccion()
	{
		if (!isset($this->s__filtro)) {
			$this->pantalla('seleccion')->eliminar_evento('agregar');
		}
	}	

	function conf__arbol(arbol_restricciones_funcionales $arbol) 
	{
		if (! isset($this->s__arbol_cargado) || !$this->s__arbol_cargado) {
			$catalogador = new toba_catalogo_restricciones_funcionales( $this->s__filtro['proyecto'], $this->restriccion );
			$raiz = $catalogador->cargar();
			$arbol->set_datos($raiz, true);
			$this->s__arbol_cargado = true;
		}
	}

	function evt__guardar()
	{
		//En el alta...
		//Por cada raiz $raiz->set_restriccion('...');	
	}
	
	function evt__agregar()
	{
		$this->set_pantalla('edicion');
	}
	
	function evt__cancelar()
	{
		unset($this->s__arbol_cargado);
		$this->restriccion = -1;
		$this->set_pantalla('seleccion');
	}
	
	function evt__eliminar()
	{
		
	}
	
	function evt__cuadro_restricciones__seleccion($seleccion)
	{
		$this->restriccion = $seleccion['restriccion_funcional'];
		$this->dep('restricciones')->cargar();
		$this->set_pantalla('edicion');	
	}
	
	function conf__cuadro_restricciones($componente)
	{
		if (isset($this->s__filtro)) {
			$datos = consultas_instancia::get_restricciones_proyecto($this->s__filtro['proyecto']);
			$componente->set_datos($datos);
		}
	}
	
	function evt__filtro_proyectos__filtrar($datos)
	{
		$this->s__filtro = $datos;
	}
	
	function evt__filtro_proyectos__cancelar()
	{
		unset($this->s__filtro);
	}
	
	function conf__filtro_proyectos($componente)
	{
		if (isset($this->s__filtro)) {
			$componente->set_datos($this->s__filtro);
		}		
	}
}

?>