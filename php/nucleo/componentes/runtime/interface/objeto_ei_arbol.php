<?php
require_once("objeto_ei.php");

/**
* Consume una estructura arbolea que implementa la interfaz recorrible_como_arbol
* @package Objetos
* @subpackage Ei
*/
class objeto_ei_arbol extends objeto_ei
{
	protected $nodos_inicial;
	protected $item_propiedades = array();
	protected $nivel_apertura = 1;
	protected $datos_apertura;
	protected $todos_abiertos = false;
	protected $frame_destino = null;
	
    function __construct($id)
    {
        parent::__construct($id);
		$this->submit = "ei_arbol" . $this->id[1];
		$this->objeto_js = "objeto_ei_arbol_{$this->id[1]}";
	}
	
	function destruir()
	{
		$this->memoria["eventos"] = array();
		if(isset($this->eventos)){
			foreach($this->eventos as $id => $evento ){
				$this->memoria["eventos"][$id] = true;
			}
		}	
		parent::destruir();
	}

	function inicializar($parametros)
	{
		$this->id_en_padre = $parametros['id'];		
	}
	
	function servicio__ejecutar()
	{
		toba::get_hilo()->desactivar_reciclado();		
		$nodo = toba::get_hilo()->obtener_parametro('id_nodo');
		$nodo = $this->reportar_evento("cargar_nodo", $nodo);
		$html = $this->recorrer_hijos(current($nodo), 0);
		echo $html;
	}
	
	function set_item_propiedades($id_item)
	{
		$this->item_propiedades = $id_item;
	}
	
	function set_apertura_nodos($datos_apertura)	//$datos_apertura = array('id_nodo' => boolean, ...)
	{
		$this->datos_apertura = $datos_apertura;
	}
	
	function set_nivel_apertura($nivel)
	{
		$this->nivel_apertura = $nivel;
	}
	
	function set_todos_abiertos()
	{
		$this->todos_abiertos = true;	
	}
	
	function set_frame_destino($frame)
	{
		$this->frame_destino = $frame;
	}
	
    function cargar_datos($nodos=null, $memorizar=true)
    {
		$this->nodos_inicial = $nodos;
	}
	
	function get_lista_eventos()
	{
		$eventos = array();
		$eventos += eventos::ver_propiedades();
		return $eventos;
	}
	
	function disparar_eventos()
	{
		//Se guarda el layout del arbol actual				
		if (isset($_POST[$this->submit."__apertura_datos"])) {
			$datos_apertura = $_POST[$this->submit."__apertura_datos"];
			$pares = explode("||", $datos_apertura);
			$nodos = array();
			foreach ($pares as $par) {
				$par = explode("=", $par);
				if (count($par) == 2) {
					list($id, $visible) = $par;
					$nodos[$id] = $visible;
				}
			}				
			$this->datos_apertura = $nodos;
			//Se reporta el cambio de layout al padre				
			$this->reportar_evento("cambio_apertura", $this->datos_apertura);
		}
		if(isset($_POST[$this->submit]) && $_POST[$this->submit]!="") {
			$evento = $_POST[$this->submit];	
			//El evento estaba entre los ofrecidos?
			if(isset($this->memoria['eventos'][$evento]) ) {
				$parametros = null;
				if ($evento == 'ver_propiedades' && isset($_POST[$this->submit."__seleccion"])) {
					$this->reportar_evento( $evento, $_POST[$this->submit."__seleccion"] );
				}
			}
		}
	}
	
	function obtener_html()
	{
		$salida = "";
		$salida .= form::hidden($this->submit, '');
		$salida .= form::hidden($this->submit."__apertura_datos", '');
		$salida .= form::hidden($this->submit."__seleccion", '');
		$id = "id='{$this->objeto_js}_nodo_raiz'";
		if (isset($this->nodos_inicial)) {
			//--- Se incluye la barrita que contiene el path actual
			$barra = "";
			if (count($this->nodos_inicial) > 0) {
				$nodo = $this->nodos_inicial[0];
				while ($nodo->get_padre() != null) {
					$nodo = $nodo->get_padre();	
					$nodo_barra = "<a href='javascript: {$this->objeto_js}.ver_propiedades(\"";
					$nodo_barra .= $nodo->get_id()."\");' ";
					$nodo_barra .= "class='ei-arbol-ver-prop'>". $this->acortar_nombre($nodo->get_nombre_corto(),20)."</a>";
					$barra = $nodo_barra . " > ". $barra;
				}
				if ($barra != '') {
					$barra = "<div class='ei-arbol-barra-path'>$barra</div>";	
				}
				$salida .= $barra;
			}

			foreach ($this->nodos_inicial as $nodo_inicial) {
				$salida .= "\n<ul $id class='ei-arbol-raiz'>";
				$salida .= $this->recorrer_recursivo($nodo_inicial, true);
				$salida .= "</ul>";
				$id = null;	//El id lo tiene s�lo el primer nodo
			}
		}
		echo $salida;
	}
	
	protected function recorrer_recursivo($nodo, $es_raiz = false, $nivel = 0)
	{
		//Determina si el nodo es visible en la apertura
		$salida = "\n\t<li class='ei-arbol-nodo'>";
		$es_visible = $this->nodo_es_visible($nodo, $nivel);
		$salida .= $this->mostrar_nodo($nodo, $es_visible);

		//Recursividad
		if (! $nodo->es_hoja()) {
			$estilo =  ($es_visible) ? "" : "style='display:none'";
			$salida .= "\n<ul id_nodo='{$nodo->get_id()}' class='ei-arbol-rama' $estilo>";
			$nivel = $nivel + 1;
			if ($nodo->tiene_hijos_cargados()) {
				$salida .= $this->recorrer_hijos($nodo, $nivel);
			}
			$salida .= "</ul>";
		}
		$salida .= "</li>\n";
		return $salida;
	}
	
	protected function recorrer_hijos($nodo, $nivel)
	{
		$salida = "";
		foreach ($nodo->get_hijos() as $nodo_hijo) {
			$salida .= $this->recorrer_recursivo($nodo_hijo, false, $nivel);										
		}
		return $salida;
	}
	
	protected function mostrar_nodo(recorrible_como_arbol $nodo, $es_visible)
	{
		$salida = '';
		$salida .= $this->mostrar_utilerias($nodo);
		if (! $nodo->es_hoja()) {
			if ($es_visible) {
				$img_exp_contr = recurso::imagen_apl('arbol/contraer.gif', false); 
			} else {
				$img_exp_contr = recurso::imagen_apl('arbol/expandir.gif', false);
			}
			$salida .= "<img src='$img_exp_contr' onclick='{$this->objeto_js}.cambiar_expansion(this);' 
						 class='ei-arbol-exp-contr'> ";
		} else {
			$salida .= gif_nulo(14,1);
		}
		$salida .= $this->mostrar_iconos($nodo);
		
		//Nombre
		$corto = $this->acortar_nombre($nodo->get_nombre_corto());
		$title= "<b>Nombre</b>: ".$nodo->get_nombre_largo()."<br><b>Id</b>:  ".$nodo->get_id();
		$extra = $nodo->get_info_extra();
		if ($extra != '') {
			$title .= "<hr>$extra";
		}
		
		$ayuda = recurso::ayuda(null,  $title, 'ei-arbol-nombre');
		$nombre= "<span $ayuda>$corto</span>";
		if ($nodo->tiene_propiedades()) {
			$salida .= "<a href='javascript: {$this->objeto_js}.ver_propiedades(\"".$nodo->get_id()."\");' ".
						"class='ei-arbol-ver-prop'>$nombre</a>";			
		} else {
			$salida .= $nombre;
		}
		return $salida;
	}
	
	protected function nodo_es_visible($nodo, $nivel)
	//Determina si un nodo es visible viendo en la apertura de nodos
	{
		$cargado_parcial = !$nodo->es_hoja() && $nodo->tiene_hijos_cargados();
		if ($this->todos_abiertos) {
			return $cargado_parcial;
		}
		if (isset($this->datos_apertura[$nodo->get_id()])) {
			return $this->datos_apertura[$nodo->get_id()] && $cargado_parcial;
		}
		//Si no esta se determina por el nivel de apertura estandar
		return ($nivel < $this->nivel_apertura) && $cargado_parcial;
	}
	
	protected function mostrar_iconos($nodo)
	{
		$salida = '';
		foreach ($nodo->get_iconos() as $icono) {
			$img = recurso::imagen($icono['imagen'], null, null, $icono['ayuda']);
			if (isset($icono['vinculo'])) {
				$salida .= "<a target='{$this->frame_destino}' href='".$icono['vinculo']."'>$img</a>\n";
			} else {
				$salida .= $img."\n";
			}
		}	
		return $salida;
	}
	
	protected function mostrar_utilerias($nodo)
	{
		$utilerias = $nodo->get_utilerias();
		if (count($utilerias) > 0) {
			$salida = "<span style='float: right'>";
			foreach ($utilerias as $utileria) {
				$img = recurso::imagen($utileria['imagen'], null, null, $utileria['ayuda']);
				if (isset($utileria['vinculo'])) {
					if (isset($utileria['target'])) {
						$target = "target='".$utileria['target']."'";
					} else {
						$target = "target='{$this->frame_destino}'";
					}
					$salida .= "<a href='".$utileria['vinculo']."' $target>$img</a>\n";
				} else {
					$salida .= $img;
				}
			}
			$salida .= "</span>";
			return $salida;
		}
	}

	protected function acortar_nombre($nombre, $limite=30) 
	{
		if (strlen($nombre) <= $limite)
			return $nombre;
		else
			return substr($nombre, 0, $limite)."...";
		return $nombre;
	}
	
	//-------------------------------------------------------------------------------
	//---- JAVASCRIPT ---------------------------------------------------------------
	//-------------------------------------------------------------------------------

	protected function crear_objeto_js()
	{
		$identado = js::instancia()->identado();
		$item = js::arreglo($this->item_propiedades, false);
		$opciones['servicio'] = 'ejecutar';
		$opciones['objetos_destino'] = array($this->id);
		$autovinculo = toba::get_vinculador()->crear_autovinculo("", $opciones );
		echo $identado."window.{$this->objeto_js} = new objeto_ei_arbol('{$this->objeto_js}',
												 '{$this->submit}', $item, '$autovinculo');\n";
	}

	//-------------------------------------------------------------------------------

	public function consumo_javascript_global()
	{
		$consumo = parent::consumo_javascript_global();
		$consumo[] = 'clases/objeto_ei_arbol';
		return $consumo;
	}	

}

?>