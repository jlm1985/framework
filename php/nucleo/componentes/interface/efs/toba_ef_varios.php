<?php
/**
 * Muestra un checkbox con el tag <input type='checkbox'>
 * @package Componentes
 * @subpackage Efs
 * @jsdoc ef_checkbox ef_checkbox
 */
class toba_ef_checkbox extends toba_ef
{
    protected $valor;
    protected $valor_no_seteado;
    protected $valor_info = 'S�';
    protected $valor_info_no_seteado = 'No';
    protected $clase_css = 'ef-checkbox';
    
    static function get_lista_parametros()
    {
    	return array(
    					'check_valor_si',
    					'check_valor_no',
    					'check_desc_si',
    					'check_desc_no',
    					'check_ml_toggle'
    	);
    }
 
    
    function __construct($padre, $nombre_formulario, $id, $etiqueta, $descripcion, $dato, $obligatorio, $parametros)
    {
		//VAlor FIJO
		if(isset($parametros['estado_defecto'])){
			$this->estado_defecto = $parametros['estado_defecto'];		
			$this->estado = $this->estado_defecto;
		}
		if (isset($parametros['check_valor_si'])){
		    $this->valor = $parametros['check_valor_si'];
		} else {
			$this->valor = '1';
		}
		if (isset($parametros['check_valor_no'])){
		    $this->valor_no_seteado = $parametros['check_valor_no'];
		} else {
			$this->valor_no_seteado = '0';	
		}	
		if (isset($parametros["check_desc_si"])){
		    $this->valor_info = $parametros["check_desc_si"];
		}
		if (isset($parametros["check_desc_no"])){
		    $this->valor_info_no_seteado = $parametros["check_desc_no"];
		}		
		if (isset($parametros["check_ml_toggle"])){
		    $this->check_ml_toggle = $parametros["check_ml_toggle"];
		}			
		parent::__construct($padre, $nombre_formulario, $id, $etiqueta, $descripcion, $dato, $obligatorio,$parametros);
    }
    
	function get_input()
    {
    	//Esto es para eliminar un notice en php 5.0.4
    	if (!isset($this->estado))
    		$this->estado = null;
    		
         if ($this->solo_lectura) 
         {
		 	if ($this->estado != "")
	            $html_devuelto = toba_form::hidden($this->id_form, $this->estado);
			else
				$html_devuelto = "";
				
            if ($this->seleccionado()) {
                $html_devuelto .= toba_recurso::imagen_toba('nucleo/efcheck_on.gif',true,16,16);
            } else {
                $html_devuelto .= toba_recurso::imagen_toba('nucleo/efcheck_off.gif',true,16,16);            
            }
            return $html_devuelto;   
         } else {
         	$js = '';
			if ($this->cuando_cambia_valor != '') {
				$js = "onchange=\"{$this->get_cuando_cambia_valor()}\"";
			}         	
			$tab = $this->padre->get_tab_index();
			$extra = " tabindex='$tab'";		
            return toba_form::checkbox($this->id_form, $this->estado, $this->valor, $this->clase_css, $extra.' '.$js);
         }            
    }

	function set_estado($estado)
	//Carga el estado interno
	{
   		if(isset($estado)){								
    		$this->estado=$estado;
			return true;
	    }else{
			//Si el valor no seteado existe, paso el estado a ese valor.
			if (isset($this->valor_no_seteado)) {
	    		$this->estado = $this->valor_no_seteado;
	    		return true;
			} else {
    			$this->estado = null;			
			}
    	}
		return false;
	}
	
	function cargar_estado_post()
	{
		if(isset($_POST[$this->id_form])) {
			$this->set_estado($_POST[$this->id_form]);
    	} else {
    		$this->set_estado(null);
    	}
		return false;		
	}
	
	function get_consumo_javascript()
	{
		$consumos = array('efs/ef','efs/ef_checkbox');
		return $consumos;
	}	
	
	function tiene_estado()
	{
		return isset($this->estado) && 
				($this->estado == $this->valor || $this->estado == $this->valor_no_seteado);
	}	

	function seleccionado()
	{
		return isset($this->estado) && 
				($this->estado == $this->valor);
	}	
	
	function crear_objeto_js()
	{
		return "new ef_checkbox({$this->parametros_js()})";
	}	

	function get_descripcion_estado($tipo_salida)
	{
		if ( !isset($this->estado) || $this->estado == $this->valor_no_seteado ) {
			$valor = $this->valor_info_no_seteado;
		} else {
			$valor = $this->valor_info;
		}
		switch ($tipo_salida) {
			case 'html':
			case 'impresion_html':
				return "<div class='{$this->clase_css}'>$valor</div>";
			break;
			case 'pdf':
				return $valor;
			case 'excel':
				return array($valor, null);
		}		
	}
	
}
// ########################################################################################################
// ########################################################################################################

/**
 * Muestra un <div> con el estado actual dentro
 * �til para incluir contenidos est�ticos en el formulario
 * @jsdoc ef_fijo ef_fijo
 */
class toba_ef_fijo extends toba_ef_oculto
{
	protected $clase_css = 'ef-fijo';
	private $maneja_datos;
	
	static function get_lista_parametros()
	{
		$parametros[] = 'fijo_sin_estado';
		return $parametros;
	}
	
    
    static function get_lista_parametros_carga()
    {
    	$parametros = toba_ef::get_lista_parametros_carga_basico();    
		array_borrar_valor($parametros, 'carga_lista');
		array_borrar_valor($parametros, 'carga_col_clave');
		array_borrar_valor($parametros, 'carga_col_desc');
		return $parametros;
    }  	
	
	function __construct($padre, $nombre_formulario, $id, $etiqueta, $descripcion, $dato, $obligatorio, $parametros)
    {
		parent::__construct($padre, $nombre_formulario, $id, $etiqueta, $descripcion, $dato, $obligatorio,$parametros);
		if(isset($parametros['fijo_sin_estado']) && $parametros['fijo_sin_estado'] == 1){
			$this->maneja_datos = false;
		}else{
			$this->maneja_datos = true;
		}
		
	}
   
	function set_estado($estado=null)
	{
		/*
			Si el EF maneja datos utilizo la logica de persistencia del padre
		*/
		if($this->maneja_datos){
			return parent::set_estado($estado);
		}else{
			if(isset($estado)) {
				$this->estado = $estado;
			}		
		}
	}

	function set_opciones($descripcion, $maestros_cargados=true)
	{
		$this->set_estado($descripcion);
	}	
	
	function get_input()
    {
		$estado = (isset($this->estado)) ? $this->estado : null;
		$html = "<div class='{$this->clase_css}' id='{$this->id_form}'>".$estado."</div>";
		return $html;
	}
	
	function get_consumo_javascript()
	{
		$consumos = array('efs/ef');
		return $consumos;
	}	
	
	function crear_objeto_js()
	{
		return "new ef_fijo({$this->parametros_js()})";
	}	
			
}


// ########################################################################################################
// ########################################################################################################
//Editor WYSIWYG de HTML

/**
 * Incluye un editor HTML WYSYWYG llamado fckeditor
 * El HTML generado por este editor es bastante pobre en estructura, deber�a ser utilizado solo por usuarios finales
 * y no por desarrolladores que quieran agregar contenido din�micamente a la aplicaci�n.
 * @jsdoc ef ef
 */
class toba_ef_html extends toba_ef
{
	protected $ancho;
	protected $alto;
	protected $botonera;
	protected $fckeditor;

	static function get_lista_parametros()
	{
		$parametros[] = 'editor_ancho';
		$parametros[] = 'editor_alto';
		$parametros[] = 'editor_botonera';
		return $parametros;
	}	
	
	function __construct($padre, $nombre_formulario, $id, $etiqueta, $descripcion, $dato, $obligatorio, $parametros)
    {
		$this->ancho = (isset($parametros['editor_ancho']))? $parametros['editor_ancho'] : "100%";
		$this->alto = (isset($parametros['editor_alto']))? $parametros['editor_alto'] : "300px";
		$this->botonera = (isset($parametros['editor_botonera']))? $parametros['editor_botonera'] : "Toba";
        parent::__construct($padre, $nombre_formulario, $id, $etiqueta, $descripcion, $dato, $obligatorio, $parametros);
	}

	function get_consumo_javascript()
	{
		$consumo = parent::get_consumo_javascript();
		$consumo[] = "fck_editor";
		return $consumo;
	}
	
	/**
	 * Retorna el objeto fckeditor para poder modificarlo seg�n su propia API
	 * @return fckeditor
	 */
	function get_editor()
	{
		if (! isset($this->fckeditor)) {
			require_once(toba_dir().'/www/js/fckeditor/fckeditor_php5.php');
			$url = toba_recurso::url_toba().'/js/fckeditor/';
			$this->fckeditor = new FCKeditor($this->id_form) ;
			$this->fckeditor->BasePath = $url;
			$this->fckeditor->Width = $this->ancho;
			$this->fckeditor->Height = $this->alto;
			$this->fckeditor->ToolbarSet = $this->botonera;
			$this->fckeditor->Config['SkinPath'] = $url.'editor/skins/silver/';
			$this->fckeditor->Config['DefaultLanguage'] = 'es';
		}
		return $this->fckeditor;		
	}

	function get_input()
	{
		if(isset($this->estado)){
			$estado = $this->estado;
		}else{
			$estado = "";
		}

		if ($this->solo_lectura) {
			$html = "<div class='ef-html' style='width: {$this->ancho}'>$estado</div>";
		} else {
			$fck_editor = $this->get_editor();
			$fck_editor->Value = $estado;			
			$html = $fck_editor->CreateHtml() ;
		}
		return $html;
	}
}

?>