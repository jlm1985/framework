<?
	if($editable = $this->zona->obtener_editable_propagado()){
		include_once("nucleo/browser/clases/objeto_ei_formulario.php");
		$this->zona->cargar_editable();//Cargo el editable de la zona
		$this->zona->obtener_html_barra_superior();
		$form =& new objeto_ei_formulario($editable);
		enter();
		echo "<div align='center'>\n";
		echo "<table class='objeto-base' width='100'>\n";
		echo "<tr><td>";
		$form->inicializar(array("nombre_formulario"=>"formulario"));
		$form->obtener_html();
		echo "</td></tr>\n";
		echo "</table>\n";
		echo "</div>\n";
		enter();
		$this->zona->obtener_html_barra_inferior();
		//dump_session();
	}else{
		echo ei_mensaje("INSTANCIADOR de ABMS: No se explicito el objeto a a cargar","error");
	}
?>