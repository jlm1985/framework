<?
	if($editable = $this->zona->obtener_editable_propagado()){
		$this->zona->cargar_editable();//Cargo el editable de la zona
		$this->zona->obtener_html_barra_superior();
		echo ei_mensaje("La COMPOSICION de OBJETOS se encuentra desactivada");
/*
	//--> Estoy navegando la ZONA con un editable...
		//-[1]- Cargo la lista de Objetos
		$lista = $this->cargar_objeto("objeto_lista",0);
		if($lista > -1){
			//-[2]- Cargo el ABM que permite asociar objetos
			$abms = $this->cargar_objeto("objeto_mt_abms",0);
			if($abms > -1){
				$this->zona->cargar_editable();//Cargo el editable de la zona
				//$this->zona->info();
				$cargar_ef = array("item"=>$editable[1]);

				$this->objetos[$abms]->cargar_estado_ef($cargar_ef);
				$this->objetos[$abms]->procesar();
				$this->objetos[$lista]->cargar_datos(array("(i.item = '".$editable[1]."') ",
															"(i.proyecto = '".$editable[0]."') " ) );
				$this->zona->obtener_html_barra_superior();
				$this->objetos[$lista]->obtener_html();
				$this->objetos[$abms]->obtener_html();
				$this->zona->obtener_html_barra_inferior();

				//$this->objetos[$abms]->info_estado();		

			}else{
				echo ei_mensaje("No fue posible instanciar el ABM");
			}
*/
	}else{
		echo ei_mensaje("No se especifico que EDITABLE utilizar");
	}
?>
