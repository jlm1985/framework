<?
require_once("objeto_ei_formulario.php");	//Ancestro de todos los	OE
require_once("nucleo/browser/interface/ef.php");//	Elementos de interface

class	objeto_ei_formulario_ml	extends objeto_ei_formulario
/*
	@@acceso: actividad
	@@desc: Esta clase contruye la Interface Grafica de un registro de una tabla

	- Registro de modificacion en el cliente
	- Array de modificacion para alguien que lo mapee en un buffer
	- Validacion en el cargar_post
	- Flag de agregar filas
	
	Un formulario tiene que saber que si viene del post, para dejar cargase datos o no???
	Cual es la solucion para esta competencia??
	
*/
{
	var $datos;		//Datos que tiene el formulario
	var $lista_ef_totales = array();
	protected $objeto_js;
	
	function __construct($id)
/*
	@@acceso: nucleo
	@@desc: constructor de la clase
*/
	{
		parent::__construct($id);
		$this->objeto_js = "objeto_{$id[1]}";
	}
	//-------------------------------------------------------------------------------

	function inicializar($parametros)
	{
		parent::inicializar($parametros);
	}
	//-------------------------------------------------------------------------------

	function inicializar_especifico()
	{
		for($a=0;$a<count($this->info_formulario_ef);$a++)
		{
			if($this->info_formulario_ef[$a]["total"]){
				$this->lista_ef_totales[] = $this->info_formulario_ef[$a]["identificador"];
			}
		}
		$this->modelo_eventos = "omni";
	}
	//-------------------------------------------------------------------------------

	function obtener_definicion_db()
	{
		$sql = parent::obtener_definicion_db();
		//Formulario
		$sql["info_formulario"]["sql"] = "SELECT	auto_reset as	auto_reset,
										scroll as 					scroll,					
										ancho as					ancho,
										alto as						alto,
										filas as					filas,
										filas_agregar as			filas_agregar,
										ev_agregar				as 	ev_agregar,				
										ev_agregar_etiq			as 	ev_agregar_etiq,
										ev_mod_modificar		as 	ev_mod_modificar,		
										ev_mod_modificar_etiq	as 	ev_mod_modificar_etiq,
										ev_mod_eliminar         as 	ev_mod_eliminar,
										ev_mod_eliminar_etiq	as 	ev_mod_eliminar_etiq,
										ev_mod_limpiar	        as 	ev_mod_limpiar,
										ev_mod_limpiar_etiq		as 	ev_mod_limpiar_etiq										
								FROM	apex_objeto_ut_formulario
								WHERE	objeto_ut_formulario_proyecto='".$this->id[0]."'
								AND		objeto_ut_formulario='".$this->id[1]."';";
		$sql["info_formulario"]["tipo"]="1";
		$sql["info_formulario"]["estricto"]="1";
		//EF
		$sql["info_formulario_ef"]["sql"] = "SELECT	identificador as identificador,
										columnas	as				columnas,
										obligatorio	as				obligatorio,
										elemento_formulario as		elemento_formulario,
										inicializacion	as			inicializacion,
										etiqueta	as				etiqueta,
										descripcion	as				descripcion,
										clave_primaria	as			clave_primaria,
										orden	as					orden,
										total as 					total,
										lista_columna_estilo as		columna_estilo
								FROM	apex_objeto_ut_formulario_ef
								WHERE	objeto_ut_formulario_proyecto='".$this->id[0]."'
								AND	objeto_ut_formulario='".$this->id[1]."'
								AND	(desactivado=0	OR	desactivado	IS	NULL)
								ORDER	BY	orden;";
		$sql["info_formulario_ef"]["tipo"]="x";
		$sql["info_formulario_ef"]["estricto"]="1";
		return $sql;
	}

	//-------------------------------------------------------------------------------
	//-------------------------------------------------------------------------------
	//-----------------------------	INFORMACION	 -----------------------------------
	//-------------------------------------------------------------------------------
	//-------------------------------------------------------------------------------

	function	info_estado_ef()
/*
	@@acceso: actividad
	@@desc: Muestra el estado de los	EF
*/
	{
		foreach ($this->lista_ef as $ef){
			$temp1[$ef]	= $this->elemento_formulario[$ef]->obtener_estado();
			$temp2[$ef]	= $this->elemento_formulario[$ef]->obtener_dato();
		}
		$temp["DATOS"]=$temp2;
		$temp["ESTADO"]=$temp1;
		//ei_arbol($temp,"Estado actual	de	los ELEMENTOS de FORMULARIO");
	}

	//-------------------------------------------------------------------------------
	//-------------------------------------------------------------------------------
	//--------------------------------	EVENTOS  -----------------------------------
	//-------------------------------------------------------------------------------
	//-------------------------------------------------------------------------------

	function obtener_evento()
	//ATENCION: esto hay que pensarlo. Que eventos se necesitan??
	// Como es la interaccion de un ML con un buffer?
	{

		if($this->controlar_modificacion())
		{
			return "modificacion";
		}
		return null;
	}
	//-------------------------------------------------------------------------------

	function controlar_modificacion()
	//ATENCION: Esto hay que mejorarlo
	{
		if(acceso_post()){
			return true;
		}else{
			return false;
		}
	}
	//-------------------------------------------------------------------------------
	

	//-------------------------------------------------------------------------------
	//-------------------------------------------------------------------------------
	//--------------------------------	PROCESOS  -----------------------------------
	//-------------------------------------------------------------------------------
	//-------------------------------------------------------------------------------

	function recuperar_interaccion()
	{
		if(! $this->cargar_post())
			$this->carga_inicial();
	}
	//-------------------------------------------------------------------------------

	function carga_inicial()
/*
	@@acceso: interno
	@@desc: Carga los datos a partir de la definici�n
*/
	{
		if (!isset($this->datos) || $this->datos === null) {
			$this->datos = array();
			if ($this->info_formulario["filas"] > 0 ) {
				for ($i = 0; $i < $this->info_formulario["filas"]; $i++) {
					$this->datos[$i] = array();
				}
			}
		}	
	}
	
	function cargar_post()
	{
/*
	@@acceso: interno
	@@desc: Carga los datos a partir del POST
*/
		if (! isset($_POST[$this->objeto_js.'_listafilas']))
			return false;

		$this->datos = array();			
		$lista_filas = $_POST[$this->objeto_js.'_listafilas'];
		if ($lista_filas != '') {
			$filas = explode('_', $lista_filas);
			//Por cada fila
			$i = 0;
			foreach ($filas as $fila)
			{
				//1) Cargo los EFs
				foreach ($this->lista_ef as $ef){
					$this->elemento_formulario[$ef]->establecer_id_form($fila);
					$x	= $this->elemento_formulario[$ef]->cargar_estado();
				}
				//2) Seteo el registro
				$this->cargar_ef_a_registro($i);
				$i++;
			}
		}
		return true;
	}
	//-------------------------------------------------------------------------------

	function validar_estado()
/*
	@@acceso: interno
	@@desc: Valida	el	registro
	@@pendiente: grados:	EJ	un	ef_oculto_proyecto no la deberia	dejar	pasar...
*/
	{
		return false;
	}
	//-------------------------------------------------------------------------------

	function limpiar_interface()
/*
	@@acceso: actividad
	@@desc: Resetea los elementos	de	formulario
*/
	{
		foreach ($this->lista_ef as $ef){
			$this->elemento_formulario[$ef]->resetear_estado();
		}
	}
	//-------------------------------------------------------------------------------

	function cargar_estado_ef($array_ef)
	{
		//ATENCION: En un multilinea esto es distinto. FALTA
	}
	//-------------------------------------------------------------------------------

	function obtener_nombres_ef()
/*
	@@acceso: actividad
	@@desc: Recupera la lista de nombres de EF
	@@retorno: array | Listado	de	cada elemento de formulario
*/
	{
		foreach ($this->lista_ef_post	as	$ef){
			$nombres_ef[$ef] = $this->elemento_formulario[$ef]->obtener_id_form_orig();		
		}
		return $nombres_ef;
	}

	//-------------------------------------------------------------------------------
	//-------------------------------------------------------------------------------
	//-------------------------	  MANEJO de DATOS	---------------------------------
	//-------------------------------------------------------------------------------
	//-------------------------------------------------------------------------------

	function cantidad_lineas()
	{
		return count($this->datos);
	}
	//-------------------------------------------------------------------------------	
	function obtener_datos()
	{
		return $this->datos;
	}
	//-------------------------------------------------------------------------------

	function cargar_datos($datos)
	{
		$this->datos = $datos;
		$this->carga_inicial();
	}
	//-------------------------------------------------------------------------------

	function existen_datos_cargados()
	{
		if(isset($this->datos)){
			if(count($this->datos) > 0){
				//ei_arbol($this->datos,"DATOS");
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}

	//-------------------------------------------------------------------------------
	//-------------------------------------------------------------------------------
	//------------------------  Multiplexacion de EFs  ------------------------------
	//-------------------------------------------------------------------------------
	//-------------------------------------------------------------------------------

	function cargar_ef_a_registro($id_registro)
/*
	@@acceso: actividad
	@@desc: Carga el estado del array de EFs en un registro
	@@retorno: array | estado de cada elemento de formulario
*/
	{
		foreach ($this->lista_ef as $ef)
		{
			//Aplano el estado del EF en un array
			$dato	= $this->elemento_formulario[$ef]->obtener_dato();
			$estado = $this->elemento_formulario[$ef]->obtener_estado();
			if(is_array($dato)){	//El EF maneja	DATO COMPUESTO
				if((count($dato))!=(count($estado))){//Error	de	consistencia interna	del EF
					echo ei_mensaje("obtener_datos: Error de consistencia	interna en el EF etiquetado: ".
										$this->elemento_formulario[$ef]->obtener_etiqueta(),"error");
				}
				for($x=0;$x<count($dato);$x++){
					$this->datos[$id_registro][$dato[$x]]	= $estado[$dato[$x]];
				}
			}else{					//El EF maneja	un	DATO SIMPLE
				$this->datos[$id_registro][$dato] = $estado;
			}
		}
		//ei_arbol($this->datos,"CArga de registros");
	}
	//-------------------------------------------------------------------------------

	function cargar_registro_a_ef($id_registro)
/*
	@@acceso: actividad
	@@desc: Carga un REGISTRO en el array de EFs
	@@retorno: array | estado de cada elemento de formulario
*/
	{
		$datos = (isset($this->datos[$id_registro])) ? $this->datos[$id_registro] : array();
		foreach ($this->lista_ef as $ef)
		{
			//Seteo el ID-formulario del EF para que referencie al registro actual
			$this->elemento_formulario[$ef]->establecer_id_form($id_registro);
			$this->elemento_formulario[$ef]->resetear_estado();
			$dato = $this->elemento_formulario[$ef]->obtener_dato();
			if(is_array($dato)){	//El EF maneja	 *** DATO COMPUESTO
				$temp = array();
				for($x=0;$x<count($dato);$x++){
					$temp[$dato[$x]]=stripslashes($datos[$dato[$x]]);
				}
			}else{					//El EF maneja	un	*** DATO SIMPLE
				$temp = (isset($datos[$dato])) ? stripslashes($datos[$dato]) : null;
			}
			if ($temp !== null)
				$this->elemento_formulario[$ef]->cargar_estado($temp);
		}
	}

	//-------------------------------------------------------------------------------
	//-------------------------------------------------------------------------------
	//----------------------------	  SALIDA	  -----------------------------------
	//-------------------------------------------------------------------------------
	//-------------------------------------------------------------------------------

	function generar_formulario()
	{
		//Botonera de agregar
		if ($this->info_formulario['filas_agregar']) {
			echo "<div style='text-align: left;'>";
			echo form::button_html("{$this->objeto_js}_subir", recurso::imagen_apl('ml/subir.gif', true), "onclick='{$this->objeto_js}.subir_seleccionada();' disabled");
			echo form::button_html("{$this->objeto_js}_bajar", recurso::imagen_apl('ml/bajar.gif', true), "onclick='{$this->objeto_js}.bajar_seleccionada();' disabled");
			echo form::button_html("{$this->objeto_js}_agregar", recurso::imagen_apl('ml/agregar.gif', true), "onclick='{$this->objeto_js}.crear_fila();'");
			echo form::button_html("{$this->objeto_js}_eliminar", recurso::imagen_apl('ml/borrar.gif', true), "onclick='{$this->objeto_js}.eliminar_seleccionada();' disabled");
			$html = recurso::imagen_apl('ml/deshacer.gif', true)."<span id='{$this->objeto_js}_deshacer_cant'  style='font-size: 8px;'></span>";
			echo form::button_html("{$this->objeto_js}_deshacer", $html, " onclick='{$this->objeto_js}.deshacer();' disabled");
			echo "</div>\n";
		}				
		$ancho = isset($this->info_formulario["ancho"]) ? $this->info_formulario["ancho"] : "500";
		//SCROLL???
		if($this->info_formulario["scroll"]){
			$alto = isset($this->info_formulario["alto"]) ? $this->info_formulario["alto"] : "auto";
			echo "<div style='overflow: scroll; height: $alto; width: $ancho; border: 1px inset; padding: 0px;'>";
		}else{
			echo "<div>";
		}
		echo form::hidden("{$this->objeto_js}_listafilas",'');
		echo "<table width='$ancho' class='tabla-0'>\n";

		//------ TITULOS -----
		echo "<thead>\n<tr>\n";
		if ($this->info_formulario['filas_agregar']) {
			echo "<td class='abm-columna'>&nbsp;</td>\n";
		}
		foreach ($this->lista_ef_post	as	$ef){
			echo "<td  class='abm-columna'>\n";
			echo $this->elemento_formulario[$ef]->envoltura_ei_ml();
			echo "</td>\n";
		}
		echo "</tr>\n</thead>\n";

		//------ Totales ------
		if(count($this->lista_ef_totales)>0){
			echo "\n<!-- TOTALES ------------->\n\n";
			echo "<tfoot>\n<tr>\n";
			if ($this->info_formulario['filas_agregar']) {
				echo "<td class='abm-total'>&nbsp;</td>\n";
			}			
			foreach ($this->lista_ef_post as $ef){
				echo "<td  class='abm-total'>\n";
				if(in_array($ef, $this->lista_ef_totales)){
					$this->elemento_formulario[$ef]->establecer_id_form("s");
					$id_form_total = $this->elemento_formulario[$ef]->obtener_id_form();
					echo "<div id='$id_form_total' class='abm-total'>&nbsp;</div>";
				}else{
					echo "&nbsp;";
				}
				echo "</td>\n";
			}
			echo "</tr>\n</tfoot>\n";
		}		

		//------ FILAS ------
		//Se recorre una fila m�s para insertar una nueva fila 'modelo' para agregar en js
		echo "<tbody>";
		for($a=0; $a <  count($this->datos) + 1; $a++) {
			if ($a < count($this->datos)) {
				$fila = $a;
				$estilo = "'";
			} else {
				$fila = "__fila__";
				$estilo = "style='display:none;'";
			}
			$this->cargar_registro_a_ef($fila);
			//Aca va el codigo que modifica el estado de cada EF segun los datos...
			echo "\n<!-- FILA $fila ------------->\n\n";
			echo "<tr $estilo id='{$this->objeto_js}_fila$fila' onclick='{$this->objeto_js}.seleccionar($fila)'>";
			if ($this->info_formulario['filas_agregar']) {
				echo "<td class='abm-fila-ml'>\n<span id='{$this->objeto_js}_numerofila$fila'>".($a + 1);
				echo "</span></td>\n";
			}
			foreach ($this->lista_ef_post as $ef){
				echo "<td  class='abm-fila-ml'>\n";
				echo $this->elemento_formulario[$ef]->establecer_id_form($fila);
				echo $this->elemento_formulario[$ef]->obtener_input();
				echo "</td>\n";
			}
			echo "</tr>\n";
		}
		echo "</tbody>\n</table>\n</div>";
	}

	//-------------------------------------------------------------------------------
	//---- JAVASCRIPT ---------------------------------------------------------------
	//-------------------------------------------------------------------------------

	function obtener_funciones_javascript()
	{
		echo js::abrir();
		//Creaci�n de los objetos javascript de los objetos
		$con_agregar = ($this->info_formulario['filas_agregar']) ? "true" : "false";
		echo "var {$this->objeto_js} = new objeto_ei_formulario_ml('{$this->objeto_js}', {$this->cantidad_lineas()}, $con_agregar);\n";
		foreach ($this->lista_ef_post	as	$ef){
			echo "{$this->objeto_js}.agregar_ef({$this->elemento_formulario[$ef]->crear_objeto_js()});\n";
		}
		//Agregado de callbacks para calculo de totales
		if(count($this->lista_ef_totales)>0) {
			foreach ($this->lista_ef_post as $ef) {
				if(in_array($ef, $this->lista_ef_totales)){
					$objeto_js_ef = $this->elemento_formulario[$ef]->objeto_js();
					echo "{$this->objeto_js}.agregar_totalizacion('$objeto_js_ef');\n";
				}
			}
		}		
		echo js::cerrar();
	}
	
	function consumo_javascript_global()
	{
		$consumos = parent::consumo_javascript_global();
		$consumos[] = 'clases/objeto_ei_formulario_ml';
		return $consumos;
	}
	
	function obtener_javascript()
/*
	@@acceso: interno
	@@desc: devuelve JAVASCRIPT que se ejecuta en el onSUBMIT del FORMULARIO
*/
	{
		echo "\nif (! {$this->objeto_js}.submit()) return false;";
	}	
}
?>
